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
        // DB::table('division')->insert([
        //     'name'          =>'Bat',
        //     'created_at'    => Carbon::now(),
        // ]);
        // DB::table('division')->insert([
        //     'name'          =>'Cables',
        //     'created_at'    => Carbon::now(),
        // ]);
        // DB::table('division')->insert([
        //     'name'          =>'Case',
        //     'created_at'    => Carbon::now(),
        // ]);
        DB::table('division')->insert([
            'name'          =>'Baterias',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Cargadores',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Robot',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Cristales',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Equipos',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'PC',
            'created_at'    => Carbon::now(),
        ]);
        DB::table('division')->insert([
            'name'          =>'Varios',
            'created_at'    => Carbon::now(),
        ]);
    }
}
