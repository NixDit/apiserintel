<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServicesColumnsToProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sale', function (Blueprint $table) {
            $table->boolean('is_service')->nullable()->default(false)->after('company_id');
            $table->string('no_service')->nullable()->after('is_service');
            $table->integer('company_service_id')->nullable()->after('no_service');
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
            $table->dropColumn('is_service');
            $table->dropColumn('no_service');
            $table->dropColumn('company_service_id');
        });
    }
}
