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
    Schema::create('modules', function (Blueprint $table) {
        $table->id();

        // 🔗 Relations
        $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        $table->foreignId('center_id')->constrained()->cascadeOnDelete();

        // Infos module
        $table->string('name');
        $table->text('description')->nullable();
        $table->integer('capacity')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
