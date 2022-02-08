<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('seller_id')->constrained('users')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('gig_id')->constrained('gigs')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gig_package_id')->constrained('gig_packages')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status',config('app.order_status'))
                ->default(config('app.order_status.pending'));
            $table->string('transaction_no')->nullable();
            $table->string('card_last_four_digits')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('cvv_number')->nullable();
            $table->decimal('service_fee');
            $table->decimal('sub_total');
            $table->string('delivery_time');
            $table->longText('requirements');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
