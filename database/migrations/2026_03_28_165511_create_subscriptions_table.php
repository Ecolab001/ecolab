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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation utilisateur
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // 💰 Montant abonnement
            $table->integer('amount')->default(2000);

            // 📅 Dates (SAFE pour MySQL)
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            // 📊 Statut abonnement
            $table->enum('status', ['active', 'expired'])
                  ->default('active');

            // 🕒 Timestamps Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};