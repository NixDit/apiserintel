<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $brand = Brand::create([
            'name' => 'Telcel',
        ]);

        $brand->image()->create([
            'path' => '/brands/telcel.png'
        ]);

        $category = Category::create(['name' => 'Productos']);

        $brand->products()->create([
            'name'              => 'Ficha 100',
            'code'              => 'Telcel-100',
            'description'       => 'Ficha telefonica con un valor de 100 pesos en credito Telcel',
            'retail_price'      => 98.00,
            'wholesale_price'   => 95.00,
            'category_id'       => $category->id
        ]);

        $brand->products()->create([
            'name'              => 'Ficha 200',
            'code'              => 'Telcel-200',
            'description'       => 'Ficha telefonica con un valor de 200 pesos en credito Telcel',
            'retail_price'      => 198.00,
            'wholesale_price'   => 195.00,
            'category_id'       => $category->id
        ]);
        $brand->products()->create([
            'name'              => 'Ficha 300',
            'code'              => 'Telcel-300',
            'description'       => 'Ficha telefonica con un valor de 300 pesos en credito Telcel',
            'retail_price'      => 198.00,
            'wholesale_price'   => 195.00,
            'category_id'       => $category->id
        ]);
        $brand->products()->create([
            'name'              => 'Ficha 400',
            'code'              => 'Telcel-400',
            'description'       => 'Ficha telefonica con un valor de 400 pesos en credito Telcel',
            'retail_price'      => 198.00,
            'wholesale_price'   => 195.00,
            'category_id'       => $category->id
        ]);
        $brand->products()->create([
            'name'              => 'Ficha 500',
            'code'              => 'Telcel-500',
            'description'       => 'Ficha telefonica con un valor de 500 pesos en credito Telcel',
            'retail_price'      => 198.00,
            'wholesale_price'   => 195.00,
            'category_id'       => $category->id
        ]);


        $second_brand = Brand::create([
            'name' => 'Serintel',
        ]);

        $second_brand->image()->create([
            'path' => '/brands/serintel.jpg'
        ]);

        $second_category = Category::create(['name' => 'Servicios']);

        $second_brand->products()->create([
            'name'              => 'Reparacion pantalla de celular',
            'code'              => 'Reparacion-pantalla',
            'description'       => 'Reparacion de la pantalla de cualquier modelo',
            'retail_price'      => 999.00,
            'wholesale_price'   => 799.00,
            'category_id'       => $second_category->id
        ]);
        $second_brand->products()->create([
            'name'              => 'Liberacion de celular',
            'code'              => 'Liberacion-celular',
            'description'       => 'Liberacion a cualquier compañia',
            'retail_price'      => 49900,
            'wholesale_price'   => 299.00,
            'category_id'       => $second_category->id
        ]);

    }
}
