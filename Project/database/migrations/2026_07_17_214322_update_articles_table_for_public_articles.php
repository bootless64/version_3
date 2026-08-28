<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('keywords')->nullable()->after('title');
            $table->string('authors')->nullable()->after('keywords');
            $table->string('publication_year')->nullable()->after('authors');
            $table->string('abstract_file')->nullable()->after('file');
            $table->boolean('is_published')->default(true)->after('status');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('keywords');
            $table->dropColumn('authors');
            $table->dropColumn('publication_year');
            $table->dropColumn('abstract_file');
            $table->dropColumn('is_published');
        });
    }
};