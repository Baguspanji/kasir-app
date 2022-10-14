<?php

use App\Models\CostShop;
use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_shops', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->integer('price');
            // $table->json('items');
            $table->text('description')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::create('cost_shop_details', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->foreignIdFor(CostShop::class)->constrained();
            $table->foreignIdFor(Item::class)->constrained();
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('app_id')->references('id')->on('apps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_shop_details');
        Schema::dropIfExists('cost_shops');
    }
};
