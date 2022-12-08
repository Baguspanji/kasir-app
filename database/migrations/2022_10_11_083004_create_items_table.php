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
            $table->foreignIdFor(Category::class)->nullable()->constrained();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->enum('type', ['storage', 'sell'])->default('sell');
            $table->integer('stock')->nullable();
            $table->integer('take_price')->default(0);
            $table->integer('price')->default(0);
            $table->json('needs')->nullable();
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
