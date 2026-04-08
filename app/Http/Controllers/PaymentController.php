<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{
    /**
     * 🔥 PAIEMENT ABONNEMENT
     */
    public function createSubscriptionPayment(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'phone' => 'required|string|min:8'
        ]);

                // 🔥 ID interne (TON système)
        $transactionId = 'SUB_' . Str::uuid();

        DB::beginTransaction();

        $payment = Payment::create([
            'user_id' => $user->id,
            'type' => 'subscription_payment',
            'amount' => 2000,
            'transaction_id' => $transactionId,
            'status' => 'pending',
        ]);

        DB::commit();

        \Log::info('PAIEMENT CRÉÉ', [
            'payment_id' => $payment->id,
            'transaction_id' => $payment->transaction_id
        ]);

        // 🔥 Format téléphone
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        if (strlen($phone) === 8) {
            $phone = '229' . $phone;
        }

        try {

            \Log::info('ENVOI FEEXPAY', [
                'reference_envoyee' => $payment->transaction_id,
                'phone' => $phone
            ]);

            $response = Http::timeout(60)
                ->retry(3, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('FEEXPAY_API_KEY'),
                    'Accept' => 'application/json',
                ])
                ->post(env('FEEXPAY_API_URL'), [
                    'shop' => env('FEEXPAY_SHOP_ID'),
                    'amount' => $payment->amount,
                    'phoneNumber' => $phone,
                    'reference' => $payment->transaction_id,
                    'description' => 'Abonnement ECOLAB',
                    'callback_url' => env('FEEXPAY_CALLBACK_URL'),
                ]);

        } catch (\Exception $e) {
            \Log::error('Erreur FeexPay', [
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Erreur réseau.');
        }

        $data = $response->json();

        \Log::info('FEEXPAY RESPONSE', $data);

        if (!$response->successful()) {
            return back()->with('error', 'Erreur lors de la demande de paiement.');
        }

        // 🔥 SAUVEGARDE REFERENCE FEEXPAY (CRITIQUE)

        if (isset($data['reference'])) {

            $payment->feexpay_reference = trim($data['reference']);
            $payment->save();

            \Log::info('REFERENCE FEEXPAY SAUVEGARDEE', [
                'payment_id' => $payment->id,
                'feexpay_reference' => $payment->feexpay_reference
            ]);

            // 🔍 VERIFICATION DIRECTE DB
            $freshPayment = \App\Models\Payment::find($payment->id);

            \Log::info('VERIF DB APRES SAVE', [
                'payment_id' => $freshPayment->id,
                'feexpay_reference' => $freshPayment->feexpay_reference
            ]);
        }
        return back()->with('success', 'Demande envoyée. Vérifiez votre téléphone.');
    }

public function createCandidatePayment(Request $request, $candidateId)
{
    $candidate = \App\Models\Candidate::findOrFail($candidateId);

    // 🔒 Sécurité : vérifier propriétaire
    if ($candidate->user_id !== auth()->id()) {
        abort(403);
    }

    // 🔒 Empêcher double paiement
    if ($candidate->status === 'paid') {
        return back()->with('error', 'Déjà payé');
    }

    // 🔒 Validation numéro saisi
    $request->validate([
        'phone' => 'required|string|min:8'
    ]);

    // 📱 Nettoyage numéro
    $phone = preg_replace('/[^0-9]/', '', $request->phone);

    // 🔧 Normalisation
    if (strlen($phone) === 8) {
        $phone = '229' . $phone;
    }

    if (strlen($phone) === 9 && str_starts_with($phone, '0')) {
        $phone = '229' . substr($phone, 1);
    }

    \Log::info('NUMERO PAIEMENT CANDIDAT', [
        'saisi' => $request->phone,
        'formatte' => $phone
    ]);

    // 🔥 Création transaction
    $transactionId = 'CAND_' . \Illuminate\Support\Str::uuid();

    DB::beginTransaction();

    $payment = \App\Models\Payment::create([
        'user_id' => $candidate->user_id,
        'candidate_id' => $candidate->id,
        'type' => 'candidate_payment',
        'amount' => 2500,
        'transaction_id' => $transactionId,
        'status' => 'pending',
    ]);

    // 🔥 Mettre statut en cours
    $candidate->update([
        'status' => 'pending'
    ]);

    DB::commit();

    try {

        \Log::info('ENVOI FEEXPAY CANDIDAT', [
            'reference' => $payment->transaction_id,
            'phone' => $phone
        ]);

       $response = Http::timeout(60)
        ->retry(3, 1000)
        ->withHeaders([
            'Authorization' => 'Bearer ' . env('FEEXPAY_API_KEY'),
            'Accept' => 'application/json',
        ])
        ->post(env('FEEXPAY_API_URL'), [
            'shop' => env('FEEXPAY_SHOP_ID'),
            'amount' => $payment->amount,
            'phoneNumber' => $phone, // ✅ CORRIGÉ
            'reference' => $payment->transaction_id,
            'description' => 'Paiement Matieres Premieres CMV',
            'callback_url' => env('FEEXPAY_CALLBACK_URL'),
        ]);

    } catch (\Exception $e) {

        \Log::error('Erreur FeexPay CANDIDAT', [
            'message' => $e->getMessage()
        ]);

        return back()->with('error', 'Erreur réseau');
    }

    \Log::info('FEEXPAY RAW RESPONSE CANDIDAT', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);

    if (!$response->successful()) {
        return back()->with('error', 'Erreur paiement : ' . $response->body());
    }

    $data = $response->json();

    // 🔥 Sauvegarde référence FeexPay
    if (isset($data['reference'])) {
        $payment->feexpay_reference = trim($data['reference']);
        $payment->save();
    }

    return back()->with('success', 'Demande envoyée au candidat');
}
    /**
     * 🔥 WEBHOOK FEEXPAY
     */
public function handleWebhook(Request $request)
{
    \Log::info('WEBHOOK FEEXPAY', $request->all());

    $reference = $request->input('reference')
        ?? $request->input('order_id');

    $status = strtoupper($request->input('status') ?? '');

    if (!$reference) {
        \Log::error('Reference manquante', $request->all());
        return response()->json(['error' => 'Reference manquante'], 400);
    }

    \Log::info('Recherche paiement', [
        'reference_recue' => $reference
    ]);

    // 🔍 Nettoyage référence
    $cleanReference = trim($reference);

    // 🔍 Recherche paiement
    $payment = Payment::whereRaw('TRIM(feexpay_reference) = ?', [$cleanReference])
        ->orWhereRaw('TRIM(transaction_id) = ?', [$cleanReference])
        ->first();

    if (!$payment) {
        \Log::error('Paiement introuvable ❌', [
            'reference' => $reference
        ]);
        return response()->json(['error' => 'Paiement introuvable'], 404);
    }

    \Log::info('Paiement trouvé ✅', [
        'payment_id' => $payment->id,
        'type' => $payment->type
    ]);

    // 🔒 Idempotence
    if ($payment->status === 'paid') {
        \Log::warning('Paiement déjà traité ⚠️', [
            'payment_id' => $payment->id
        ]);
        return response()->json(['message' => 'Déjà traité']);
    }

    // 🔥 Statuts acceptés
    $successStatuses = ['SUCCESS', 'SUCCESSFUL', 'PAID'];

    if (!in_array($status, $successStatuses)) {
        $payment->update(['status' => 'failed']);

        \Log::warning('Paiement échoué ❌', [
            'status' => $status,
            'payment_id' => $payment->id
        ]);

        return response()->json(['message' => 'Paiement échoué']);
    }

    // ✅ Paiement validé
    $payment->update(['status' => 'paid']);

    \Log::info('Paiement validé ✅', [
        'payment_id' => $payment->id
    ]);

    /*
    |--------------------------------------------------------------------------
    | 🔥 CAS 1 : ABONNEMENT
    |--------------------------------------------------------------------------
    */
    if ($payment->type === 'subscription_payment') {

        $user = $payment->user;

        if (!$user) {
            \Log::error('Utilisateur introuvable');
            return response()->json(['error' => 'Utilisateur introuvable'], 500);
        }

        $end = now()->addMonths(3);

        Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'amount' => 2000,
                'start_date' => now(),
                'end_date' => $end,
                'status' => 'active'
            ]
        );

        $user->update([
            'status' => 'active',
            'expires_at' => $end
        ]);

        \Log::info('Abonnement activé ✅', [
            'user_id' => $user->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 CAS 2 : PAIEMENT CANDIDAT
    |--------------------------------------------------------------------------
    */
    if ($payment->type === 'candidate_payment') {

        $candidate = $payment->candidate;

        if (!$candidate) {
            \Log::error('Candidat introuvable');
            return response()->json(['error' => 'Candidat introuvable'], 500);
        }

        // ✅ Mise à jour statut candidat
        $candidate->update([
            'status' => 'paid'
        ]);

        \Log::info('Candidat payé ✅', [
            'candidate_id' => $candidate->id
        ]);

        // 🔒 Éviter double commission
        if (!$candidate->commission) {

            \App\Models\Commission::create([
                'user_id' => $candidate->user_id,
                'candidate_id' => $candidate->id,
                'amount' => 500,
                'status' => 'pending'
            ]);

            \Log::info('Commission créée ✅', [
                'candidate_id' => $candidate->id
            ]);
        }
    }

    return response()->json(['message' => 'OK']);
}
}