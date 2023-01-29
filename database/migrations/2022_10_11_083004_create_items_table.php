<?php

use App\Models\Category;
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
            $table->string('code_1')->nullable();
            $table->string('code_2')->nullable();
            $table->string('code_3')->nullable();
            $table->string('code_4')->nullable();
            $table->string('code_5')->nullable();
            $table->string('code_6')->nullable();
            $table->string('code_7')->nullable();
            $table->string('code_8')->nullable();
            $table->string('code_9')->nullable();
            $table->string('code_10')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('take_price')->default(0);
            $table->integer('price')->default(0);
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
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
    }
};
