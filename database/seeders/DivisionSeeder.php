<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('division')->insert([
            'name'          =>'Bat',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Cables',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Case',
            'created_at'    => Carbon::now(),
        ]);
    }
}
