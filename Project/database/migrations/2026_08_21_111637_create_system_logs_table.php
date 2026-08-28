<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            
            $table->timestamp('event_time')->useCurrent();
            $table->string('event_type', 100);
            $table->string('event_category', 50);
            $table->boolean('event_result');
            
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            $table->string('session_id')->nullable();
            $table->string('method', 10)->nullable();
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            
            $table->text('description')->nullable();
            $table->json('details')->nullable();
            $table->text('error_message')->nullable();
            $table->string('affected_entity')->nullable();
            $table->unsignedBigInteger('affected_entity_id')->nullable();
            
            $table->timestamps();
            
            $table->index(['event_time', 'event_type', 'user_id']);
            $table->index(['event_category', 'event_result']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_logs');
    }
};