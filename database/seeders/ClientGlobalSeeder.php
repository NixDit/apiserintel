<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientGlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //BEGIN:: Create the global client
        $client = User::create([
            'name'      => 'Cliente',
            'last_name' => 'Global',
            'email'     => 'clienteglobal@gmail.com',
            'password'  => Hash::make('ClienteGlobal2023'),
        ]);

        $client->assignRole('client');

        $client_code = 'SC-' . (str_pad( $client->id, 10, '0', STR_PAD_LEFT));

        $client->clientInformation()->create([
            'business_name' => 'Cliente Global',
            'code'          => $client_code,
            'phone'         => '9999999999',
            'address'       => 'Calle global Sur 1111',
            'latlng'        => '00.000000,00.000000'
        ]);
        //END:: Create the global client
    }
}
