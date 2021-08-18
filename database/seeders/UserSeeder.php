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
            'password'  => Hash::make('Superadmin@2021'),
        ]);
        //END:: Create an superadmin
        
        $superadmin->assignRole('superadmin');


        //BEGIN:: Create an employee
        $employee = User::create([
            'name'      => 'Empleado',
            'last_name' => 'Serintel',
            'email'     => 'empleado@mail.com',
            'password'  => Hash::make('Empleado@2021'),
        ]);
        
        $employee->assignRole('employee');
        //END:: Create an employee

        //BEGIN:: Create a client
        $client = User::create([
            'name'      => 'Josmar Salvador',
            'last_name' => 'Marroquin Parra',
            'email'     => 'josmarmp96@gmail.com',
            'password'  => Hash::make('Cliente@2021'),
        ]);
        
        $client->assignRole('client');

        $digits = 5;
        $random_number = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        $client->clientInformation()->create([
            'business_name' => 'Josmii & Glass Videogames',
            'code'          => "Serintel-{$client->id}-{$random_number}",
            'phone'         => '2381473627',
            'address'       => 'Calle Hidalgo 434 Altepexi, Puebla.',
            'latlng'        => '18.3655904,-97.3017397'
        ]);
        //END:: Create a client

        //BEGIN:: Create a client
        $second_client = User::create([
            'name'      => 'Juan Pablo',
            'last_name' => 'Bonilla Mendez',
            'email'     => 'jpm_caprico@gmail.com',
            'password'  => Hash::make('Cliente@2021'),
        ]);
        
        $second_client->assignRole('client');

        $digits = 5;
        $random_number = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        $second_client->clientInformation()->create([
            'business_name' => 'NIX Desarrollo, Innovacion y Tecnologia',
            'code'          => "Serintel-{$second_client->id}-{$random_number}",
            'phone'         => '2361201744',
            'address'       => 'Andador C 80 Ajalpan, Puebla',
            'latlng'        => '18.376444,-97.275152'
        ]);
        //END:: Create a client

         //BEGIN:: Create a client
         $third_client = User::create([
            'name'      => 'Adan',
            'last_name' => 'Marroquin Mendez',
            'email'     => 'adan_marroquin@gmail.com',
            'password'  => Hash::make('Marroquin@2021'),
        ]);
        
        $third_client->assignRole('client');

        $digits = 5;
        $random_number = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        $third_client->clientInformation()->create([
            'business_name' => 'GYM Kajoma',
            'code'          => "Serintel-{$third_client->id}-{$random_number}",
            'phone'         => '2361201743',
            'address'       => 'Calle Insurgentes 619 Altepexi, Puebla',
            'latlng'        => '18.3683379,-97.302974'
        ]);
        //END:: Create a client

        
    }
}
