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
        Schema::create('assessment_request_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_request_id')->constrained()->onDelete('cascade');

            $table->boolean('qa_product_catalog')->nullable();
            $table->boolean('qa_user_manual')->nullable();
            $table->boolean('qa_basic_procedures_description')->nullable();
            $table->boolean('qa_product_security_requirements')->nullable();
            $table->boolean('qa_product_release_version')->nullable();
            $table->boolean('qa_product_architecture')->nullable();
            $table->boolean('qa_database_documentation')->nullable();
            $table->boolean('qa_non_functional_requirements')->nullable();
            $table->boolean('qa_system_diagrams')->nullable();
            $table->boolean('qa_questionnaire')->nullable();
            $table->boolean('qa_manufacturer_info')->nullable();
            $table->boolean('qa_maintenance_manual')->nullable();
            $table->boolean('qa_communication_protocols')->nullable();
            $table->boolean('qa_programming_environment')->nullable();

            $table->boolean('sa_product_catalog')->nullable();
            $table->boolean('sa_user_manual')->nullable();
            $table->boolean('sa_product_identity')->nullable();
            $table->boolean('sa_product_security_requirements')->nullable();
            $table->boolean('sa_analysis_design_doc')->nullable();
            $table->boolean('sa_product_architecture')->nullable();
            $table->boolean('sa_security_target_doc')->nullable();
            $table->boolean('sa_product_release_version')->nullable();
            $table->boolean('sa_agd')->nullable();
            $table->boolean('sa_alc')->nullable();
            $table->boolean('sa_adv')->nullable();
            $table->boolean('sa_crypto_capability_declaration')->nullable();

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
        Schema::dropIfExists('assessment_request_checklists');
    }
};
