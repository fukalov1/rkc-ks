<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Главная',
                'url' => '',
                'order' => 1
            ],
            [
                'name' => 'О Компании',
                'url' => 'o_kompanii',
                'order' => 2
            ],
            [
                'name' => 'Информация',
                'url' => 'informaciya',
                'order' => 3
            ],
            [
                'name' => 'Законодательство',
                'url' => 'zakonodatelstvo',
                'order' => 4
            ],
            [
                'name' => 'Объявления',
                'url' => 'obyavleniya',
                'order' => 5
            ],
        ];

        foreach ($data as $item) {
            Page::updateOrCreate($item);
        }
    }
}
