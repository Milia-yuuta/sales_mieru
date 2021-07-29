<?php

use App\Models\PropertyMaster;
use Illuminate\Database\Seeder;

class PropertyMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PropertyMaster::insert([
            [
                'group_num' => 1,
                'name' => '新耐震',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 1,
                'name' => '旧耐震',
                'val' => 2,
                'seq' => 2,
            ],
            [
                'group_num' => 2,
                'name' => '鉄骨造',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 2,
                'name' => '鉄筋コンクリート造',
                'val' => 2,
                'seq' => 2,
            ],
            [
                'group_num' => 2,
                'name' => '鉄骨鉄筋コンクリート造',
                'val' => 3,
                'seq' => 3,
            ],
            [
                'group_num' => 2,
                'name' => '木造',
                'val' => 4,
                'seq' => 4,
            ],
            [
                'group_num' => 3,
                'name' => '所有権',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 3,
                'name' => '旧法地上権',
                'val' => 2,
                'seq' => 2,
            ],
            [
                'group_num' => 3,
                'name' => '旧法賃借権',
                'val' => 3,
                'seq' => 3,
            ],
            [
                'group_num' => 4,
                'name' => '規約なし・要実態確認',
                'val' => 1,
                'seq' => 1,
            ],
            [
                'group_num' => 4,
                'name' => '規約制限付で飼育可',
                'val' => 2,
                'seq' => 2,
            ],
            [
                'group_num' => 4,
                'name' => '飼育不可',
                'val' => 3,
                'seq' => 3,
            ],
        ]);
    }
}
