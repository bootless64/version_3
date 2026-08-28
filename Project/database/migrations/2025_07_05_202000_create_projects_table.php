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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('applicant_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('assessment_request_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('primary_coach_id')->constrained('users')->default(1)->onDelete('restrict');
            $table->foreignId('secondary_coach_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('title');
            $table->enum('status', ['request_submission', 'initial_audit', 'contract_signing', 'testing_and_monitoring', 'final_confirmation', 'final_report_submission', 'end_of_contract'])->default('request_submission');

            $table->text('request_submission')->nullable();
            $table->string('request_submission_file')->nullable();
            $table->text('initial_audit')->nullable();
            $table->string('initial_audit_file')->nullable();
            $table->text('contract_signing')->nullable();
            $table->string('contract_signing_file')->nullable();
            $table->text('testing_and_monitoring')->nullable();
            $table->string('testing_and_monitoring_file')->nullable();
            $table->text('final_confirmation')->nullable();
            $table->string('final_confirmation_file')->nullable();
            $table->text('final_report_submission')->nullable();
            $table->string('final_report_submission_file')->nullable();
            $table->text('end_of_contract')->nullable();
            $table->string('end_of_contract_file')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
