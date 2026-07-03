<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_profiles', function (Blueprint $table) {
            $table->string('job_title')->nullable()->change();
            $table->string('company_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_profiles', function (Blueprint $table) {
            $table->string('job_title')->nullable(false)->change();
            $table->string('company_name')->nullable(false)->change();
        });
    }
};
