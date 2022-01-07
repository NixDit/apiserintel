<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Line;
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
        $line = Line::create(['name' => 'Fichas']);

        $brand->products()->create([
            'name'                  => 'Abono a credito',
            'code'                  => 'Abono-Credito-Serintel',
            'description'           => 'Abono a credito por la cantidad especificada',
            'cost'                  => 0,
            'retail_price'          => 0,
            'wholesale_price'       => 0,
            'special_price'         => 0,
            'super_special_price'   => 0,
            'category_id'           => $category->id,
            'line_id'               => $line->id,
            'deleted_at'            => Carbon::now(),
        ]);
        $brand->products()->create([
            'name'                  => 'Saldo a recargas',
            'code'                  => 'Saldo-Recargas-Serintel',
            'description'           => 'Venta de saldo a recargas por la cantidad especificada',
            'cost'                  => 0,
            'retail_price'          => 0,
            'wholesale_price'       => 0,
            'special_price'         => 0,
            'super_special_price'   => 0,
            'category_id'           => $category->id,
            'line_id'               => $line->id,
            'deleted_at'            => Carbon::now(),
        ]);
        $brand->products()->create([
            'name'                  => 'Saldo a servicios',
            'code'                  => 'Saldo-Servicios-Serintel',
            'description'           => 'Venta de saldo a servicios por la cantidad especificada',
            'cost'                  => 0,
            'retail_price'          => 0,
            'wholesale_price'       => 0,
            'special_price'         => 0,
            'super_special_price'   => 0,
            'category_id'           => $category->id,
            'line_id'               => $line->id,
            'deleted_at'            => Carbon::now(),
        ]);
        $brand->products()->create([
            'name'                  => 'Saldo a monedero',
            'code'                  => 'Saldo-Monedero-Serintel',
            'description'           => 'Venta de saldo a monedero por la cantidad especificada',
            'cost'                  => 0,
            'retail_price'          => 0,
            'wholesale_price'       => 0,
            'special_price'         => 0,
            'super_special_price'   => 0,
            'category_id'           => $category->id,
            'line_id'               => $line->id,
            'deleted_at'            => Carbon::now(),
        ]);

        $brand->products()->create([
            'name'                  => 'Ficha 100',
            'code'                  => 'Telcel-100',
            'description'           => 'Ficha telefonica con un valor de 100 pesos en credito Telcel',
            'cost'                  => 55.00,
            'retail_price'          => 98.00,
            'wholesale_price'       => 95.00,
            'special_price'         => 90.00,
            'super_special_price'   => 85.00,
            'category_id'           => $category->id,
            'line_id'               => $line->id
        ]);

        $brand->products()->create([
            'name'                  => 'Ficha 200',
            'code'                  => 'Telcel-200',
            'description'           => 'Ficha telefonica con un valor de 200 pesos en credito Telcel',
            'cost'                  => 155.00,
            'retail_price'          => 198.00,
            'wholesale_price'       => 195.00,
            'special_price'         => 190.00,
            'super_special_price'   => 185.00,
            'category_id'           => $category->id,
            'line_id'               => $line->id
        ]);

        $brand->products()->create([
            'name'                  => 'Ficha 300',
            'code'                  => 'Telcel-300',
            'description'           => 'Ficha telefonica con un valor de 300 pesos en credito Telcel',
            'cost'                  => 255.00,
            'retail_price'          => 298.00,
            'wholesale_price'       => 295.00,
            'special_price'         => 290.00,
            'super_special_price'   => 285.00,
            'category_id'           => $category->id,
            'line_id'               => $line->id
        ]);
        $brand->products()->create([
            'name'                  => 'Ficha 400',
            'code'                  => 'Telcel-400',
            'description'           => 'Ficha telefonica con un valor de 400 pesos en credito Telcel',
            'cost'                  => 355.00,
            'retail_price'          => 398.00,
            'wholesale_price'       => 395.00,
            'special_price'         => 390.00,
            'super_special_price'   => 385.00,
            'category_id'           => $category->id,
            'line_id'               => $line->id
        ]);
        $brand->products()->create([
            'name'                  => 'Ficha 500',
            'code'                  => 'Telcel-500',
            'description'           => 'Ficha telefonica con un valor de 500 pesos en credito Telcel',
            'cost'                  => 455.00,
            'retail_price'          => 498.00,
            'wholesale_price'       => 495.00,
            'special_price'         => 490.00,
            'super_special_price'   => 485.00,
            'category_id'           => $category->id,
            'line_id'               => $line->id
        ]);


        $second_brand = Brand::create([
            'name' => 'Serintel',
        ]);

        $second_brand->image()->create([
            'path' => '/brands/serintel.jpg'
        ]);

        $second_category = Category::create(['name' => 'Servicios']);
        $second_line = Line::create(['name' => 'Linea generica']);

        $second_brand->products()->create([
            'name'                  => 'Reparacion pantalla de celular',
            'code'                  => 'Reparacion-pantalla',
            'description'           => 'Reparacion de la pantalla de cualquier modelo',
            'cost'                  => 400.00,
            'retail_price'          => 899.00,
            'wholesale_price'       => 799.00,
            'special_price'         => 749.00,
            'super_special_price'   => 700.00,
            'category_id'           => $second_category->id,
            'line_id'               => $second_line->id
        ]);
        
        $second_brand->products()->create([
            'name'                  => 'Liberacion de celular',
            'code'                  => 'Liberacion-celular',
            'description'           => 'Liberacion a cualquier compañia',
            'cost'                  => 400.00,
            'retail_price'          => 899.00,
            'wholesale_price'       => 799.00,
            'special_price'         => 749.00,
            'super_special_price'   => 700.00,
            'category_id'           => $second_category->id,
            'line_id'               => $second_line->id
        ]);

    }
}
