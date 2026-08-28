<?php

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
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('category', ['technical', 'financial', 'support', 'content', 'other'])->default('other')->after('subject');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
        public function down()
        {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn(['category', 'priority']);
            });
        }
};
