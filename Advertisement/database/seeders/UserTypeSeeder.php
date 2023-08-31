<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            ['id'=>'1','type' => 'Admin', 'is_active' => true],
            [ 'id'=>'2','type' => 'Temporary advertiser', 'is_active' => true],
            [ 'id'=>'3','type' => 'public', 'is_active' => true],
            [ 'id'=>'4','type' => 'Advertising agency', 'is_active' => true],

        ]);
    }
}
