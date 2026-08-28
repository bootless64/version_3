<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_proposals', function (Blueprint $table) {
            $table->string('submission_type')->default('article')->after('user_id');

            $table->string('thesis_type')->nullable()->after('type');
            $table->string('student_name')->nullable()->after('authors');
            $table->string('supervisor')->nullable()->after('student_name');
            $table->string('research_field')->nullable()->after('supervisor');
            $table->string('defense_year')->nullable()->after('publication_year');

            $table->text('title_explanation')->nullable()->after('description');
            $table->string('similar_status')->nullable()->after('title_explanation');
            $table->string('similar_year')->nullable()->after('similar_status');
            $table->string('similar_place')->nullable()->after('similar_year');
            $table->string('similar_link')->nullable()->after('similar_place');
        });
    }

    public function down(): void
    {
        Schema::table('article_proposals', function (Blueprint $table) {
            $table->dropColumn([
                'submission_type',
                'thesis_type',
                'student_name',
                'supervisor',
                'research_field',
                'defense_year',
                'title_explanation',
                'similar_status',
                'similar_year',
                'similar_place',
                'similar_link',
            ]);
        });
    }
};

