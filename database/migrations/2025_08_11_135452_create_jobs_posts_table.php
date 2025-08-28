<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->enum('job_status', ['draft','pending','active','inactive','filled','expired','rejected'])->default('pending');
            $table->enum('job_type', ['hybrid', 'on-site', 'remote']);
            $table->integer('salary_start')->nullable();
            $table->integer('salary_end')->nullable();
            $table->text('job_description');
            $table->string('job_location')->nullable();
            $table->time('job_start_time')->nullable();
            $table->time('job_end_time')->nullable();
            $table->json('job_skills')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained('industries')->onDelete('set null');
            $table->foreignId('company_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};

