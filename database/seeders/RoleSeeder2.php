<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperadmin = Role::create(['name' => 'service_client']);
        $roleGuest      = Role::create(['name' => 'technician']);
    }
}
