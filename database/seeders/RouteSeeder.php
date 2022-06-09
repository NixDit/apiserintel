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
            'name'          => 'Tehuacan Centro',
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

        $route = Route::create([
            'name'          => 'Tehuacan Sur',
            'employee_id'   => 2,
            'day'           => 2
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);

        $route = Route::create([
            'name'          => 'Tehuacan Poniente',
            'employee_id'   => 2,
            'day'           => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);

        $route = Route::create([
            'name'          => 'Ajalpan Centro',
            'employee_id'   => 2,
            'day'           => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);

        $route = Route::create([
            'name'          => 'Ajalpan Norte',
            'employee_id'   => 2,
            'day'           => 5
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        $route = Route::create([
            'name'          => 'San Pedro',
            'employee_id'   => 2,
            'day'           => 6
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 3
        ]);

    }
}
