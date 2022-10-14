<?php

use App\Models\Category;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('code')->nullable();
            $table->string('name');
            $table->enum('unit', ['gram', 'pcs'])->nullable();
            $table->enum('type', ['storage', 'sell'])->nullable();
            $table->integer('stock')->default(0);
            $table->integer('price')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::create('item_details', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->foreignIdFor(Item::class)->constrained();
            $table->integer('needs');
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
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_details');
    }
};
