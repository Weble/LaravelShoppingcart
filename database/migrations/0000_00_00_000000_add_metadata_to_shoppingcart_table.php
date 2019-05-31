<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetadataToShoppingcartTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table(config('cart.database.table'), function (Blueprint $table) {
            $table->json('metadata')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table(config('cart.database.table'), function (Blueprint $table) {
            $table->dropColumn('metadata');
        });
    }
}
