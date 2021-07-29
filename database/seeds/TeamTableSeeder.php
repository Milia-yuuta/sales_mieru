<?php

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::insert([
            [
                'sales_id' => 1,
                'hat_id' => 2,
                'office_master_id' => 1,
                'area_master_id' => 24,
            ],
            [
                'sales_id' => 3,
                'hat_id' => 4,
                'office_master_id' => 1,
                'area_master_id' => 25,
            ],
            [
                'sales_id' => 5,
                'hat_id' => 6,
                'office_master_id' => 1,
                'area_master_id' => 26,
            ],
            [
                'sales_id' => 7,
                'hat_id' => 8,
                'office_master_id' => 1,
                'area_master_id' => 27,
            ],
            [
                'sales_id' => 9,
                'hat_id' => 10,
                'office_master_id' => 1,
                'area_master_id' => 28
            ],
//            [
//                'sales_id' => 11,
//                'hat_id' => 12,
//                'office_master_id' => 1,
//                'area_master_id' => 29,
//            ],
        ]);
    }
}
