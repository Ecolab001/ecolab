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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        // 🔗 Relations (IMPORTANT : nullable car soit abonnement soit candidat)
        $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
        $table->foreignId('candidate_id')->nullable()->constrained()->cascadeOnDelete();

        // 🔥 Type de paiement
        $table->enum('type', [
            'subscription_payment',
            'candidate_payment'
        ]);

        // 💰 Montant
        $table->integer('amount');

        // 🔒 Transaction unique (CRITIQUE)
        $table->string('transaction_id')->unique();

        // 📊 Statut paiement (CRITIQUE)
        $table->enum('status', [
            'pending',
            'processing',
            'paid',
            'failed'
        ])->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
