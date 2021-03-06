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
        // BEGIN:: LUNES
        $route = Route::create([
            'name'          => 'Tehuacan',
            'employee_id'   => 2,
            'day'           => 1
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);
        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 6
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 7
        ]);

        $route2 = Route::create([
            'name'          => 'Tehuacan Clara',
            'employee_id'   => 3,
            'day'           => 1
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 8
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 9
        ]);
        // END:: LUNES


        // BEGIN:: MARTES
        $route = Route::create([
            'name'          => 'Tehuacan Centro',
            'employee_id'   => 2,
            'day'           => 2
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 9
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 8
        ]);
        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 7
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 6
        ]);

        $route2 = Route::create([
            'name'          => 'Tehuacan Centro Clara',
            'employee_id'   => 3,
            'day'           => 2
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 5
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 4
        ]);
        // END:: MARTES

        // BEGIN:: MIERCOLES
        $route = Route::create([
            'name'          => 'Tehuacan Centro Miercoles',
            'employee_id'   => 2,
            'day'           => 3
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 7
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 8
        ]);
        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 9
        ]);

        $route2 = Route::create([
            'name'          => 'Tehuacan Centro Miercoles Clara',
            'employee_id'   => 3,
            'day'           => 3
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 5
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 6
        ]);
        // END:: MIERCOLES

        // BEGIN:: JUEVES
        $route = Route::create([
            'name'          => 'Tehuacan Jueves',
            'employee_id'   => 2,
            'day'           => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);
        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 7
        ]);

        $route2 = Route::create([
            'name'          => 'Tehuacan Jueves Clara',
            'employee_id'   => 3,
            'day'           => 4
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 6
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 8
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 9
        ]);
        // END:: JUEVES

        // BEGIN:: VIERNES
        $route = Route::create([
            'name'          => 'Tehuacan Ruta Centro Viernes',
            'employee_id'   => 2,
            'day'           => 5
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);
        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 6
        ]);

        $route2 = Route::create([
            'name'          => 'Tehuacan Ruta Centro Viernes Clara',
            'employee_id'   => 3,
            'day'           => 5
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 7
        ]);
        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 8
        ]);
        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 9
        ]);
        // END:: VIERNES

        // BEGIN:: SABADO
        $route = Route::create([
            'name'          => 'Tehuacan Sabado',
            'employee_id'   => 2,
            'day'           => 6
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 4
        ]);

        RouteClient::create([
            'route_id'  => $route->id,
            'user_id'   => 5
        ]);

        $route2 = Route::create([
            'name'          => 'Tehuacan Sabado Clara',
            'employee_id'   => 3,
            'day'           => 6
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 6
        ]);

        RouteClient::create([
            'route_id'  => $route2->id,
            'user_id'   => 7
        ]);



        
    }
}
