<?php

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->string('name')->nullable();
            $table->integer('total_take_price');
            $table->integer('total_price');
            $table->integer('amount_paid')->default(0);
            $table->date('date');
            $table->string('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->foreignIdFor(Transaction::class)->constrained();
            $table->foreignIdFor(Item::class)->constrained();
            $table->integer('take_price');
            $table->integer('price');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::create('transaction_detail_items', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->foreignIdFor(TransactionDetail::class)->constrained();
            $table->foreignIdFor(Item::class)->constrained();
            $table->integer('quantity');
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
        Schema::dropIfExists('transaction_detail_items');
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
    }
};
