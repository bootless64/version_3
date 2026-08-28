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
        Schema::create('assessment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');

            $table->boolean('security_assessment');
            $table->boolean('quality_assessment');

            $table->enum('person_type', ['natural_person', 'legal_person']);
            $table->string('applicant_name');
            $table->string('applicant_national_id')->nullable();
            $table->string('applicant_economic_code')->nullable();
            $table->string('applicant_landline_phone')->nullable();
            $table->string('applicant_mobile_phone')->nullable();
            $table->string('applicant_email')->nullable();
            $table->string('applicant_fax')->nullable();

            $table->string('manager_name')->nullable();
            $table->string('manager_national_id')->nullable();
            $table->string('manager_phone')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('technical_manager_name')->nullable();
            $table->string('technical_manager_national_id')->nullable();
            $table->string('technical_manager_phone')->nullable();
            $table->string('technical_manager_email')->nullable();

            $table->enum('product_type', ['local', 'non_local'])->default('local');
            $table->string('product_name');
            $table->string('product_brand_name')->nullable();
            $table->string('software_version')->nullable();
            $table->boolean('client_server');
            $table->boolean('mobile_application');
            $table->boolean('desktop_application');
            $table->boolean('web_application');
            $table->string('product_description')->nullable();

            $table->string('file')->nullable();

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
        Schema::dropIfExists('assessment_requests');
    }
};
