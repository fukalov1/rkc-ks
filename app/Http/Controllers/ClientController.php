<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\RkcLs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{

    private $client;
    private $rkc_ls;

    public function __construct(Client $client, RkcLs $rkc_ls)
    {
        $this->client = $client;
        $this->rkc_ls = $rkc_ls;
    }

    public function auth(ClientRequest $request)
    {
        $data = [
            'auth' => false,
            'customer' => [
                'clientname' => null,
                'devices' => []
                ]
        ];


        $account = $request->account;
        $code = $request->code;

        $client = $this->client
            ->where('clientid', $account)
            ->where('toolid', $code)
            ->first();

        if ($client) {
            session(['clientid' =>  $client->clientid]);
            $data = [
                'auth' => true,
                'customer' => [
                    'clientname' => $client->clientname,
                    'devices' => $client->where('clientid', $client->clientid)->get()
                    ]
            ];
        }
        else {
            $data = [
                'auth' => false,
                'message' => 'Клиент не найден!'
            ];
        }

        return $data;
    }

    public function authQR(ClientRequest $request)
    {
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
                'check_day_start' => env('CHECK_DAY_START'),
                'check_day_end' => env('CHECK_DAY_END'),
            ]);
        }
        else {
            return view('customer', [
                'qr_auth' => 0,
                'check_day_start' => env('CHECK_DAY_START'),
                'check_day_end' => env('CHECK_DAY_END'),
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
                $data['message'] = $exception->getMessage();
            }

        }
        return $data;
    }


    public function listSlips()
    {
        $data = [
            'success' => false,
            'message' => 'Клиент не авторизован'
        ];

        if (session('clientid')) {
            $uid = $this->rkc_ls->where('ls', session('clientid'))->first();
            if ($uid) {
                $data['uid'] = $uid->GUID;
                $data['slips'] = $this->listMonth();
                $data['message'] = null;
            }
        }
        return $data;
    }

    private function listMonth()
    {
        $data = [];
        $months = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
        for ($i=0; $i>=-2; $i--) {
            $data[] = [
                'year' => date('Y', strtotime("$i month"))-1,
                'month' => $months[date('m', strtotime("$i month"))-1],
                'month_id' => (int)date('m', strtotime("$i month"))
            ];
        }
        return $data;
    }

}
