<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRechargesColumnsToProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sale', function (Blueprint $table) {
            $table->boolean('is_recharge')->nullable()->default(false)->after('quantity');
            $table->string('phone')->nullable()->after('is_recharge');
            $table->integer('company_id')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_sale', function (Blueprint $table) {
            $table->dropColumn('is_recharge');
            $table->dropColumn('phone');
            $table->dropColumn('company_id');
        });
    }
}
