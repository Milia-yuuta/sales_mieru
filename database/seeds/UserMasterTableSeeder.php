<?php

use App\Models\UserMaster;
use Illuminate\Database\Seeder;

class UserMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserMaster::insert([
            [
                'group_num' => 1,
                'name' => '新宿',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 1,
                'name' => '五反田',
                'val' => 2,
                'seq' => 2,
            ],
            [
                'group_num' => 1,
                'name' => '上野',
                'val' => 3,
                'seq' => 3,
            ],
            [
                'group_num' => 1,
                'name' => '渋谷',
                'val' => 4,
                'seq' => 4,
            ],
            [
                'group_num' => 1,
                'name' => '池袋',
                'val' => 5,
                'seq' => 5,
            ],
            [
                'group_num' => 1,
                'name' => '東陽町',
                'val' => 6,
                'seq' => 6,
            ],
            [
                'group_num' => 1,
                'name' => '飯田橋',
                'val' => 7,
                'seq' => 7,
            ],
            [
                'group_num' => 1,
                'name' => '三鷹',
                'val' => 8,
                'seq' => 8,
            ],
            [
                'group_num' => 1,
                'name' => '横浜',
                'val' => 9,
                'seq' => 9,
            ],
            [
                'group_num' => 1,
                'name' => '溝の口',
                'val' => 9,
                'seq' => 9,
            ],
            [
                'group_num' => 1,
                'name' => '川崎',
                'val' => 10,
                'seq' => 10,
            ],
            [
                'group_num' => 1,
                'name' => '西川口',
                'val' => 11,
                'seq' => 11,
            ],
            [
                'group_num' => 1,
                'name' => '船橋',
                'val' => 12,
                'seq' => 12,
            ],
            [
                'group_num' => 1,
                'name' => '蒲田',
                'val' => 13,
                'seq' => 13,
            ],
            [
                'group_num' => 1,
                'name' => '北千住',
                'val' => 14,
                'seq' => 14,
            ],
            [
                'group_num' => 1,
                'name' => '首都圏',
                'val' => 15,
                'seq' => 15,
            ],
            [
                'group_num' => 2,
                'name' => '営業',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 2,
                'name' => 'hat',
                'val' => 2,
                'seq' => 2,
            ],
            [
                'group_num' => 2,
                'name' => 'その他',
                'val' => 3,
                'seq' => 3,
            ],
            [
                'group_num' => 3,
                'name' => '男',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 3,
                'name' => '女',
                'val' => 2,
                'seq' => 2,
            ],
        ]);
    }
}
