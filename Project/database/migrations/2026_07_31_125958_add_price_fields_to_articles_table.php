<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->bigInteger('price')->nullable()->after('status')->comment('قیمت به تومان');
            $table->boolean('is_free')->default(true)->after('price')->comment('رایگان یا پولی');
            $table->foreignId('price_set_by')->nullable()->constrained('users')->onDelete('set null')->after('is_free')->comment('کیف قیمت رو مشخص کرده');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('is_free');
            $table->dropColumn('price_set_by');
        });
    }
};