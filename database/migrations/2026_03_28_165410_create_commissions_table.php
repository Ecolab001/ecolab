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
    Schema::create('commissions', function (Blueprint $table) {
        $table->id();

        // 🔗 Relations
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // représentant
        $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();

        // 💰 Montant
        $table->integer('amount')->default(500);

        // 📊 Statut
        $table->enum('status', [
            'pending',
            'paid'
        ])->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
