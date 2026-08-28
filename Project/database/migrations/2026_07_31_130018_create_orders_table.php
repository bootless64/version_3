<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('transaction_id')->nullable()->comment('شناسه تراکنش از درگاه');
            $table->bigInteger('total_amount');
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone');
            
            $table->boolean('terms_accepted')->default(false);
            
            $table->text('admin_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};