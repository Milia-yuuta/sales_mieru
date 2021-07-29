<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::insert([
            [
                'type' => 2,
                'name' => 'test株式会社',
                'zip_code' => '100-1021',
                'address1' => '東京都千代田区紀尾井町',
                'address2' => '3',
                'address3' => 'testビル',
                'address4' => '16F',
                'email' => 'test@gmail.com',
                'tel' => ' 03-9390-9120',
                'fax' => '03-9390-9120',
            ],
        ]);
    }
}
