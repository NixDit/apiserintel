<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperadmin    = Role::create(['name' => 'superadmin']);
        $roleGuest         = Role::create(['name' => 'employee']);
        $roleGuest         = Role::create(['name' => 'client']);
        $roleGuest         = Role::create(['name' => 'guest']);
    }
}
