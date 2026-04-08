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
    Schema::table('commissions', function (Blueprint $table) {
        $table->timestamp('paid_at')->nullable();

        // 🔥 Détails paiement
        $table->string('payment_reference')->nullable();
        $table->string('payment_method')->nullable(); // cash, momo, cheque...
        $table->string('payment_note')->nullable();   // numéro fiche, remarque
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            //
        });
    }
};
