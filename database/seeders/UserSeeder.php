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
        $superadmin = User::create([
            'name'      => 'Serintel',
            'last_name' => 'Superadmin',
            'email'     => 'superadmin@mail.com',
            'password'  => Hash::make('Superadmin@2021'),
        ]);
        
        $superadmin->assignRole('superadmin');

        $employee = User::create([
            'name'      => 'Empleado',
            'last_name' => 'Serintel',
            'email'     => 'empleado@mail.com',
            'password'  => Hash::make('Empleado@2021'),
        ]);
        
        $employee->assignRole('employee');
    }
}
