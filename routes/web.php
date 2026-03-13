<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PaketWisatawanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LiburNasionalController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AkomodasiController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\PermohonanAkunController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Public Paket Wisata Routes (Landing Page)
Route::get('/paket-wisata', [PaketWisatawanController::class, 'publicIndex'])->name('paket.public.index');
Route::get('/paket-wisata/{id}', [PaketWisatawanController::class, 'publicShow'])->name('paket.public.show');

// Public About Us Route (Landing Page)
Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');

// Public Form Permohonan Routes (Landing Page)
Route::get('/form-permohonan', [PermohonanAkunController::class, 'create'])->name('form-permohonan');
Route::post('/form-permohonan', [PermohonanAkunController::class, 'store'])->name('form-permohonan.store');

// Login Routes - Separated by Role
// Wisatawan Login
Route::get('/login/wisatawan', [LoginController::class, 'showWisatawanLoginForm'])->name('login.wisatawan');
Route::post('/login/wisatawan', [LoginController::class, 'wisatawanLogin'])->name('login.wisatawan.submit');

// Admin Login (untuk admin dan super admin)
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'adminLogin'])->name('login.admin.submit');

// Super Admin Login - redirect ke admin login (sudah digabung)
Route::get('/login/super-admin', function () {
    return redirect()->route('login.admin');
})->name('login.super-admin');

// Legacy login route - redirect to wisatawan login
Route::get('/login', function () {
    return redirect()->route('login.wisatawan');
})->name('login');

// Logout Routes (bisa diakses via GET atau POST)
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        $user = auth()->user();
        
        // Get statistics
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_destinasi' => \App\Models\Destinasi::count(),
            'total_paket' => \App\Models\Paket::count(),
            'total_restaurant' => \App\Models\Restaurant::count(),
            'total_akomodasi' => \App\Models\Akomodasi::count(),
            'total_libur' => \App\Models\LiburNasional::count(),
        ];
        
        return view('admin.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    })->name('admin.dashboard');
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('destinasi', DestinasiController::class);
        Route::resource('paket', PaketController::class);
        Route::resource('user', UserController::class);
        Route::resource('libur_nasional', LiburNasionalController::class);
        Route::resource('restaurant', RestaurantController::class);
        Route::resource('akomodasi', AkomodasiController::class);
    });



    
    Route::get('/wisatawan/dashboard', function () {
        return view('wisatawan.dashboard', ['user' => auth()->user()]);
    })->name('wisatawan.dashboard');

    // Wisatawan Routes
    Route::prefix('wisatawan')->name('wisatawan.')->group(function () {
        Route::get('/itinerary', [ItineraryController::class, 'index'])->name('itinerary.index');
        Route::get('/itinerary/create', [ItineraryController::class, 'create'])->name('itinerary.create');
        
        // AJAX Endpoints - HARUS SEBELUM route dengan parameter {id}
        Route::get('/itinerary/destinations', [ItineraryController::class, 'getDestinations'])->name('itinerary.destinations');
        Route::post('/itinerary/generate', [ItineraryController::class, 'generate'])->name('itinerary.generate');
        Route::post('/itinerary/reoptimize', [ItineraryController::class, 'reoptimize'])->name('itinerary.reoptimize');
        Route::get('/api/holiday-info', [ItineraryController::class, 'getHolidayInfo'])->name('api.holiday-info');
        Route::get('/api/restaurant-recommendations', [ItineraryController::class, 'getRestaurantRecommendations'])->name('api.restaurant-recommendations');
        Route::get('/api/akomodasi-recommendations', [ItineraryController::class, 'getAkomodasiRecommendations'])->name('api.akomodasi-recommendations');
        
        // Store itinerary
        Route::post('/itinerary', [ItineraryController::class, 'store'])->name('itinerary.store');
        
        // Routes dengan parameter {id} - HARUS SETELAH route spesifik
        Route::get('/itinerary/{id}', [ItineraryController::class, 'show'])->name('itinerary.show');
        Route::get('/itinerary/{id}/edit', [ItineraryController::class, 'edit'])->name('itinerary.edit');
        Route::delete('/itinerary/{id}', [ItineraryController::class, 'destroy'])->name('itinerary.destroy');
        
        // Paket Wisata Routes
        Route::get('/paket', [PaketWisatawanController::class, 'index'])->name('paket.index');
        Route::get('/paket/{id}', [PaketWisatawanController::class, 'show'])->name('paket.show');
    });

});
