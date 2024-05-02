<?php

use App\Models\Material;
use App\Models\ToolDeployment;
use App\Models\User;
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
        Schema::create('lti_launches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ToolDeployment::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Material::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('launch_type');
            $table->string('course_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lti_launches');
    }
};
