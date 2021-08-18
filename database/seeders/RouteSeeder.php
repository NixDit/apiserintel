<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteClient;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $route = Route::create([
            'name'          => 'Cañada',
            'employee_id'   => 2,
            'day'           => 1
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);
    }
}
