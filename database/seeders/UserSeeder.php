<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //BEGIN:: Create a superadmin
        $superadmin = User::create([
            'name'      => 'Serintel',
            'last_name' => 'Superadmin',
            'email'     => 'superadmin@mail.com',
            'password'  => Hash::make('Superadmin2022'),
        ]);
        //END:: Create an superadmin

        $superadmin->assignRole('superadmin');


        //BEGIN:: Create an employee
        $employee = User::create([
            'name'      => 'Luis',
            'last_name' => 'Hernandez',
            'email'     => 'empleado@mail.com',
            'password'  => Hash::make('Empleado2022'),
        ]);

        $employee->assignRole('employee');
        //END:: Create an employee

        //BEGIN:: Create an employee
        $second_employee = User::create([
            'name'      => 'Clara',
            'last_name' => 'Luz',
            'email'     => 'empleado2@mail.com',
            'password'  => Hash::make('Empleado2022'),
        ]);

        $second_employee->assignRole('employee');
        //END:: Create an employee

        //BEGIN:: Create a client
        $client = User::create([
            'name'      => 'Josmar Salvador',
            'last_name' => 'Marroquin Parra',
            'email'     => 'josmarmp96@gmail.com',
            'password'  => Hash::make('Cliente2022'),
        ]);

        $client->assignRole('client');

        $client_code = 'SC-' . (str_pad( $client->id, 10, '0', STR_PAD_LEFT));

        $client->clientInformation()->create([
            'business_name' => 'Abarrotes la Corona',
            'code'          => $client_code,
            'phone'         => '5562316601',
            'address'       => 'Calle 3 Ote 322',
            'latlng'        => '18.4606981,-97.3925737'
        ]);
        //END:: Create a client

        //BEGIN:: Create a client
        $second_client = User::create([
            'name'      => 'Juan Pablo',
            'last_name' => 'Bonilla Mendez',
            'email'     => 'jpm_caprico@gmail.com',
            'password'  => Hash::make('Cliente2022'),
        ]);

        $second_client->assignRole('client');

        $second_client_code = 'SC-' . (str_pad( $second_client->id, 10, '0', STR_PAD_LEFT));

        $second_client->clientInformation()->create([
            'business_name' => 'Abarrotes Rosy',
            'code'          => $second_client_code,
            'phone'         => '5562316601',
            'address'       => 'Calle 3 Poniente',
            'latlng'        => '18.4611909,-97.4024359'
        ]);
        //END:: Create a client

         //BEGIN:: Create a client
         $third_client = User::create([
            'name'      => 'Adan',
            'last_name' => 'Marroquin Mendez',
            'email'     => 'adan_marroquin@gmail.com',
            'password'  => Hash::make('Cliente2022'),
        ]);

        $third_client->assignRole('client');

        $third_client_code = 'SC-' . (str_pad( $third_client->id, 10, '0', STR_PAD_LEFT));

        $third_client->clientInformation()->create([
            'business_name' => 'Abarrotes el gallo de tehuacan',
            'code'          => $third_client_code,
            'phone'         => '5562316601',
            'address'       => 'Calle 3 Ote 535',
            'latlng'        => '18.4609287,-97.3899697'
        ]);
        //END:: Create a client

        //BEGIN:: Create a client
        $fourth_client = User::create([
            'name'      => 'Abarrotes conchita',
            'last_name' => 'Lopez',
            'email'     => 'conchita@gmail.com',
            'password'  => Hash::make('Cliente2022'),
        ]);

        $fourth_client->assignRole('client');

        $fourth_client_code = 'SC-' . (str_pad( $fourth_client->id, 10, '0', STR_PAD_LEFT));

        $fourth_client->clientInformation()->create([
            'business_name' => 'Abarrotes Conchita',
            'code'          => $fourth_client_code,
            'phone'         => '5562316601',
            'address'       => 'Calle 7 Sur ',
            'latlng'        => '18.4586785,-97.389476'
        ]);
        //END:: Create a client

        //BEGIN:: Create a client
        $client = User::create([
            'name'      => 'Abarrotes Vinos',
            'last_name' => 'Licores',
            'email'     => 'vinos@gmail.com',
            'password'  => Hash::make('Cliente2022'),
        ]);

        $client->assignRole('client');

        $client_code = 'SC-' . (str_pad( $client->id, 10, '0', STR_PAD_LEFT));

        $client->clientInformation()->create([
            'business_name' => 'Abarrotes Vinos y Licores Fandango',
            'code'          => $client_code,
            'phone'         => '5562316601',
            'address'       => 'Calle 5 Ote 524',
            'latlng'        => '18.4585225,-97.3904625'
        ]);
        //END:: Create a client


        //BEGIN:: Create a client
        $client = User::create([
            'name'      => 'Mueganos',
            'last_name' => 'Aguila',
            'email'     => 'aguila@gmail.com',
            'password'  => Hash::make('Cliente2022'),
        ]);

        $client->assignRole('client');

        $client_code = 'SC-' . (str_pad( $client->id, 10, '0', STR_PAD_LEFT));

        $client->clientInformation()->create([
            'business_name' => 'Mueganos El Aguila',
            'code'          => $client_code,
            'phone'         => '5562316601',
            'address'       => 'Calle 3 Sur 519',
            'latlng'        => '18.4579508,-97.393339'
        ]);
        //END:: Create a client


    }
}
