<?php

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Property::insert([
            [
                'property_name' => 'testCompany.',
                'office_master_id' => 1,
            ]
        ]);
        Property::factory(100)->create();
    }
}
