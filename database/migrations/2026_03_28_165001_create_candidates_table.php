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
    Schema::create('candidates', function (Blueprint $table) {
        $table->id();

        // 🔗 Relations
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // représentant
        $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        $table->foreignId('module_id')->constrained()->cascadeOnDelete();

        // Infos candidat
        $table->string('first_name');
        $table->string('last_name');
        $table->string('phone');
        $table->string('photo')->nullable();
        $table->string('document')->nullable();

        // 🔥 Code unique
        $table->string('code')->unique();

        // 🔥 Statut métier
        $table->enum('status', [
            'pending',
            'paid',
            'validated',
            'rejected',
            'completed'
        ])->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
