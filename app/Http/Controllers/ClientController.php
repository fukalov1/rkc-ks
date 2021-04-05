<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\RkcInfo;
use App\Models\RkcKvitki;
use App\Models\RkcLs;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    private $client;
    private $rkc_ls;
    private $rkc_kvitki;
    private $info;
    private $setting;

    public function __construct(Client $client, RkcInfo $info,
                                RkcKvitki $rkc_kvitki, RkcLs $rkc_ls, Setting $setting)
    {
        $this->client = $client;
        $this->rkc_ls = $rkc_ls;
        $this->rkc_kvitki = $rkc_kvitki;
        $this->setting = $setting;
        $this->info = $info;
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return view('index');
    }

    public function auth(ClientRequest $request)
    {

        $account = $request->account;
        $code = $request->code;

        $client = $this->client
            ->where('clientid', $account)
            ->where('toolid', $code)
            ->first();


        if ($client) {
            session(['clientid' =>  $client->clientid]);
            $data = [
                'auth' => 1,
                'message' => 'success'
            ];
        }
        else {
            $data = [
                'auth' => 0,
                'message' => 'Клиент не найден!'
            ];
        }

        return $data;
    }

    public function getCustomer()
    {

        $id = session('clientid');
        if ($id) {
            $client = $this->client->where('clientid', $id)->first();

            $info = $this->info
                ->where('clientid', $id)->first();

            if ($client) {
                $data = [
                    'auth' => 1,
                    'customer' => [
                        'clientname' => $client->clientname,
                        'balance' => $info->balanse,
                        'address' => $info->address,
                        'date' => $info->balanse_date,
                        'devices' => $this->client
                            ->where('clientid', $id)
                            ->where('tooltype', '<>', 'А')
                            ->get()
                    ]
                ];
            } else {
                $data = [
                    'auth' => 0,
                    'message' => 'Клиент не найден!'
                ];
            }
        }
        return $data;
    }

    public function existAuth()
    {
        $client = $this->client
            ->where('clientid', session('clientid'))
            ->first();

        if ($client) {
            $data = [
                'auth' => 1,
                'customer' => [
                    'clientname' => $client->clientname,
                    'devices' => $client->where('clientid', $client->clientid)->get()
                ]
            ];
        }
        else {
            $data = [
                'auth' => 0,
                'message' => 'Клиент не найден!'
            ];
        }

        return $data;
    }


    public function authQR(Request $request)
    {
       $settings = $this->setting->pluck('value', 'name')->all();

        $account = $request->account;
        $code = $request->code;

        $client = $this->client
            ->where('clientid', $account)
            ->where('toolid', $code)
            ->first();

        if ($client) {
            session(['clientid' =>  $client->clientid]);

            return view('customer', [
                'qr_auth' => 1,
                'auth' => 1,
                'check_day_start' => $settings['check_day_start'],
                'check_day_end' => $settings['check_day_end'],
            ]);
        }
        else {
            return view('customer', [
                'qr_auth' => 0,
                'auth' => 0,
                'check_day_start' => $settings['check_day_start'],
                'check_day_end' => $settings['check_day_end'],
            ]);
        }
    }

    public function sendData(Request $request)
    {
        $data = [
            'success' => false,
            'message' => 'Клиент не авторизован'
        ];


        if (session('clientid')) {
            try {
                foreach ($request->customer['devices'] as $item) {
                    $this->client
                        ->where('clientid', $item['clientid'])
                        ->where('tooltype', $item['tooltype'])
                        ->where('toolid', $item['toolid'])
                        ->update(
                            [
                                'value_new' => $item['value_new'],
                                'value_date' => date('Y-m-d H:i:s')
                            ]);
                }
                $data['success'] = true;
                $data['message']  = 'Данные успешно обновлены!';
            }
            catch (\Throwable $exception) {
                $data['message'] = "Ошибка сохранения данных! Проверьте показания и повторите попытку.";
            }

        }
        return $data;
    }


    public function listSlips()
    {

        $data = [];
        $id = session('clientid');
        if ($id) {
            $slips = $this->rkc_kvitki
                ->select('ls_date', 'ls', 'date', 'year', 'month', 'date_txt', 'dwltime')
                ->with('links')
                ->where('ls', $id)
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->get()
                ->take(12);

            $data = [
                'success' => false,
                'message' => 'Квитанции не найдены'
            ];


            if ($slips) {
                $data['slips'] = $slips;
                $data['message'] = null;
            }
        }
        else {
            $data = [
                'success' => false,
                'message' => 'Клиент не авторизован'
            ];
        }
        return $data;
    }

    private function listMonth()
    {
        $data = [];
        $months = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
        for ($i=0; $i>=-11; $i--) {
            $data[] = [
                'year' => date('Y', strtotime("$i month"))-1,
                'month' => $months[date('m', strtotime("$i month"))-1],
                'month_id' => (int)date('m', strtotime("$i month"))
            ];
        }
        return $data;
    }

}
