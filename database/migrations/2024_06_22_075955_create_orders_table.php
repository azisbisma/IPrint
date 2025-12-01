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
            $table->unsignedBigInteger('user_id');
            $table->string('order_number',10)->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('postcode');
            $table->enum('payment_status',['Lunas','Menunggu Pembayaran']);
            $table->enum('status',['Baru', 'Pesanan Diproses', 'Pesanan Dikirim', 'Pesanan Diterima', 'Batal'])->default('Baru');
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
