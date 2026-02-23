<?php

use App\Livewire\CourseIndex;
use App\Livewire\CourseShow;
use App\Livewire\Dashboard;
use App\Livewire\LessonShow;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', CourseIndex::class)->name('home');

Route::get('/courses/{slug}', CourseShow::class)->name('courses.show');

// Guests can view preview lessons, so we don't apply the auth middleware unconditionally on the route.
Route::get('/courses/{slug}/lessons/{lesson}', LessonShow::class)->name('lessons.show');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/courses/{course:slug}/certificate/preview', [\App\Http\Controllers\CertificateController::class, 'preview'])->name('certificates.preview');
    Route::post('/courses/{course:slug}/certificate/generate', [\App\Http\Controllers\CertificateController::class, 'generate'])->name('certificates.generate');
});

Route::get('/certificates/{id}', [\App\Http\Controllers\CertificateController::class, 'show'])->name('certificates.show');
Route::get('/admin/certificates/{certificate}/download/{lang}', [\App\Http\Controllers\CertificateController::class, 'downloadAdmin'])->name('admin.certificates.download');




Route::get('/server-status', function () {
    try {
        DB::connection()->getPdo();

        Cache::put('health_check', true, 5);
        $cache = Cache::get('health_check');

        return response()->json([
            'status' => 'ok',
            'app' => true,
            'database' => true,
            'cache' => $cache === true,
            'timestamp' => now()->toDateTimeString(),
        ], 200);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'System unhealthy',
            'error' => $e->getMessage(),
        ], 503);
    }
});
Route::get('/clear', function () {

    abort_unless(
        request()->header('X-SYSTEM-TOKEN') === config('app.system_token'),
        403,
        'Unauthorized'
    );

    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');

    return response()->json([
        'status' => 'success',
        'message' => 'Optimization cache cleared',
    ]);
});
