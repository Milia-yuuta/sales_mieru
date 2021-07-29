<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(
            [
                [
                    'sei' => 'dev',
                    'mei' => '確認用',
                    'email' => 'app@examroople.com',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 1,
                ],
                [
                    'sei' => 'test-1',
                    'mei' => '確認アカウント',
                    'email' => 'r-takeda@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 2,
                ],
                [
                    'sei' => 'test-2',
                    'mei' => '確認アカウント',
                    'email' => 'hoshino@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 1,
                ],
                [
                    'sei' => 'test-3',
                    'mei' => '確認アカウント',
                    'email' => 'm-kawada@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 2,
                ],
                [
                    'sei' => 'test-4',
                    'mei' => '確認アカウント',
                    'email' => 's-arai@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 1,
                ],
                [
                    'sei' => 'test-5',
                    'mei' => '確認アカウント',
                    'email' => 'y-wariishi@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 2,
                ],
                [
                    'sei' => 'test-6',
                    'mei' => '確認アカウント',
                    'email' => 'tomita@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 1,
                ],
                [
                    'sei' => 'test-7',
                    'mei' => '確認アカウント',
                    'email' => 'h-ichikawa@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 2,
                ],
                [
                    'sei' => 'test-8',
                    'mei' => '確認アカウント',
                    'email' => 't-shimizu@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 1,
                ],
                [
                    'sei' => 'test-10',
                    'mei' => '確認アカウント',
                    'email' => 'i-iijima@ohkuraya.co.jp',
                    'password' => Hash::make('1234567890'),
                    'office_master_id' => 1,
                    'status_id' => 2,
                ],
            ]
        );
        User::factory(10)->create();
    }
}
