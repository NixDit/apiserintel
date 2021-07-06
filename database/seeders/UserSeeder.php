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
            'email'     => 'serintel@mail.com',
            'password'  => Hash::make('Serintel@2021'),
        ]);
        
        $superadmin->assignRole('superadmin');
    }
}
