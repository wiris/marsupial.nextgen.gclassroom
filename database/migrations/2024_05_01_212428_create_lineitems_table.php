<?php

use App\Models\Material;
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
        Schema::create('lineitems', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Material::class)->constrained()->cascadeOnDelete();
            $table->double('score_given')->nullable();
            $table->double('score_maximum')->nullable();
            $table->string('activity_progress')->default('Initialized');
            $table->string('grading_progress')->default('NotReady');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineitems');
    }
};
