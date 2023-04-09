<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class RecargasCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name' => 'Recargas']);
    }
}
