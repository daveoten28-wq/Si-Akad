<?php

use App\Http\Controllers\T013AkademikController;
use App\Http\Controllers\T013AuthController;
use App\Http\Controllers\T013MatakuliahController;
use App\Http\Controllers\T013UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [T013AuthController::class, 'showLogin']);

Route::prefix('siakad-013')->group(function () {
    Route::get('/login', [T013AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [T013AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::match(['get', 'post'], '/logout', [T013AuthController::class, 'logout'])
        ->middleware('t013.role:Admin,Dosen,Mahasiswa');

    Route::middleware('t013.role:Admin,Dosen,Mahasiswa')->group(function () {
        Route::get('/dashboard', function () {
            $mahasiswa = \App\Models\T013Mahasiswa::where('t013_user_id', session('t013_user_id'))
                ->first();

            if (! $mahasiswa) {
                $mahasiswa = \App\Models\T013Mahasiswa::where('t013_nim', session('t013_username'))->first();
            }

            return view('t013_dashboard', [
                'displayName' => $mahasiswa->t013_nama ?? session('t013_username'),
            ]);
        });
    });

    Route::middleware('t013.role:Admin,Dosen')->group(function () {
        Route::get('/matakuliah', [T013MatakuliahController::class, 'index']);
        Route::get('/matakuliah/create', [T013MatakuliahController::class, 'create']);
        Route::post('/matakuliah', [T013MatakuliahController::class, 'store']);
        Route::get('/matakuliah/{id}/edit', [T013MatakuliahController::class, 'edit']);
        Route::put('/matakuliah/{id}', [T013MatakuliahController::class, 'update']);
        Route::patch('/matakuliah/{id}', [T013MatakuliahController::class, 'update']);
        Route::delete('/matakuliah/{id}', [T013MatakuliahController::class, 'destroy']);
    });

    Route::middleware('t013.role:Admin')->group(function () {
        Route::get('/users', [T013UserController::class, 'index']);
        Route::get('/users/create', [T013UserController::class, 'create']);
        Route::post('/users', [T013UserController::class, 'store']);
        Route::get('/users/{id}/edit', [T013UserController::class, 'edit']);
        Route::put('/users/{id}', [T013UserController::class, 'update']);
        Route::patch('/users/{id}', [T013UserController::class, 'update']);
        Route::delete('/users/{id}', [T013UserController::class, 'destroy']);
    });

    Route::middleware('t013.role:Dosen')->group(function () {
        Route::get('/input-nilai', [T013AkademikController::class, 'gradeCourses']);
        Route::get('/input-nilai/{matakuliah}', [T013AkademikController::class, 'gradeStudents']);
        Route::post('/input-nilai/{matakuliah}', [T013AkademikController::class, 'storeGrade']);
    });

    Route::middleware('t013.role:Mahasiswa')->group(function () {
        Route::get('/khs', [T013AkademikController::class, 'khs']);
        Route::get('/lihat-khs', function () {
            return redirect('/siakad-013/khs');
        });
    });
});
