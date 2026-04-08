<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\RepresentativeController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/legal/mentions', 'legal.mentions')->name('legal.mentions');
Route::view('/legal/privacy', 'legal.privacy')->name('legal.privacy');
Route::view('/legal/cgu', 'legal.cgu')->name('legal.cgu');
Route::view('/legal/cgv', 'legal.cgv')->name('legal.cgv');
Route::view('/legal/payment', 'legal.payment')->name('legal.payment');
Route::view('/representants', 'legal.representatives')->name('legal.representatives');

Route::view('/contact', 'contact')->name('contact');

  Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
    
Route::view('/devenir-representant', 'become-representative')
    ->name('become.representative');


/*
|--------------------------------------------------------------------------
| Subscription Required
|--------------------------------------------------------------------------
*/

Route::get('/subscription-required', function () {
    return view('subscription.required');
})->name('subscription.required');

/*
|--------------------------------------------------------------------------
| Paiements
|--------------------------------------------------------------------------
*/

// 🔁 Redirection paiement
Route::get('/payment/redirect/{id}', function ($id) {
    $payment = \App\Models\Payment::findOrFail($id);
    return view('payment.redirect', compact('payment'));
})->name('payment.redirect');

// 🔔 Webhook (PUBLIC)
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])
    ->name('payment.webhook');

// 💳 Paiement abonnement
Route::post('/subscription/pay', [PaymentController::class, 'createSubscriptionPayment'])
    ->middleware(['auth'])
    ->name('subscription.pay');

// 💳 Paiement candidat
Route::post('/candidate/{candidate}/pay', [PaymentController::class, 'createCandidatePayment'])
    ->middleware(['auth'])
    ->name('candidate.pay');

/*
|--------------------------------------------------------------------------
| Routes protégées (auth + abonnement)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'subscription'])->group(function () {

    Route::get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'representative') {
       return redirect()->route('representative.rep.dashboard');
    }

    abort(403);

})->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

    
    // 🔹 Events
    Route::resource('events', EventController::class);
    Route::post('events/{event}/toggle', [EventController::class, 'toggle'])->name('events.toggle');

    // 🔹 Candidats
    Route::resource('candidates', CandidateController::class);
    Route::post('/admin/candidates/{id}/replace-docs',
    [\App\Http\Controllers\Admin\CandidateController::class, 'replaceDocs']
)->name('admin.candidates.replaceDocs');
    // 🔹 Modules
    Route::resource('modules', ModuleController::class);

    // 🔹 Centres
    Route::resource('centers', CenterController::class);

    // 🔹 Représentants
    Route::resource('representatives', RepresentativeController::class);

    // 🔹 Commissions
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::post('commissions/{id}/pay', [CommissionController::class, 'pay'])->name('commissions.pay');
    Route::post('commissions/pay-all/{user}', [CommissionController::class, 'payAll'])->name('commissions.payAll');

    // 🔹 Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 🔹 Rapports
    Route::get('reports', [DashboardController::class, 'reports'])->name('admin.reports');

  

    // 🔹 Messages de contact
    Route::get('contacts', function () {
        return view('admin.contacts.index', [
            'contacts' => \App\Models\Contact::latest()->get()
        ]);
    })->name('admin.contacts');
    });

/*
|--------------------------------------------------------------------------
| REPRESENTATIVES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'subscription'])
    ->prefix('representative')
    ->name('representative.') 
    ->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\Representative\DashboardController::class, 'index'])
        ->name('rep.dashboard');

    Route::resource('candidates', \App\Http\Controllers\Representative\CandidateController::class);

    Route::get('commissions', [\App\Http\Controllers\Representative\CommissionController::class, 'index'])
        ->name('rep.commissions');

});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';