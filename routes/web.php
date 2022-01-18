<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\User\Note\Notes;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrganizationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['is_admin'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('dashboard', [App\http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('organization', App\http\Controllers\Admin\OrganizationController::class);
        Route::resource('user', App\http\Controllers\Admin\UserController::class);
        Route::get('position',function () {
            return view('admin.position.index', ['sidebar' => 'position']);
        })->name('position.index');
        Route::get('password',function () {
            return view('admin.setting.change-password', [
                'sidebar' => 'password'
            ]);
        })->name('password');
        
    });

    Route::middleware(['is_operator'])->prefix('operator')->name('operator.')->group(function () {
        Route::get('dashboard', [App\http\Controllers\Operator\DashboardController::class, 'index'])->name('dashboard');
        // Route::get('division',function () {
        //     return view('operator.division.index', ['sidebar' => 'division']);
        // })->name('division.index');
        Route::get('position',function () {
            return view('operator.position.index', ['sidebar' => 'position']);
        })->name('position.index');
        Route::get('user',function () {
            return view('operator.user.index', ['sidebar' => 'user']);
        })->name('user.index');
        Route::get('mutasi',function () {
            return view('operator.user.mutasi', ['sidebar' => 'mutasi']);
        })->name('user.mutasi');
        Route::get('password',function () {
            return view('operator.setting.change-password', [
                'sidebar' => 'password',
            ]);
        })->name('password');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('home', [App\http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        // Route::get('password', [App\http\Controllers\User\DashboardController::class, 'index'])->name('password');
        Route::post('password', [App\http\Controllers\User\SettingController::class, 'updatePassword'])->name('password.update');
        Route::get('password',function () {
            return view('user.setting.change-password');
        })->name('password');
        Route::get('setting', [App\http\Controllers\User\DashboardController::class, 'index'])->name('setting');

        // Route::get('notes', App\Http\Livewire\User\Note\Notes::class);
        
        Route::resource('note', App\http\Controllers\User\NoteController::class);
        Route::get('export/note/{note}', [App\http\Controllers\User\NoteController::class, 'export2'])->name('export.note');
        Route::get('share/note/{note}', [App\http\Controllers\User\NoteController::class, 'share'])->name('share.note');

        Route::get('attendance/{note}/create', [App\http\Controllers\User\AttendanceController::class, 'create'])->name('attendance.create');
       
        Route::get('photo/{note}/create', [App\http\Controllers\User\PhotoController::class, 'create'])->name('photo.create');
        Route::post('photo/{note}/store', [App\http\Controllers\User\PhotoController::class, 'store'])->name('photo.store');
        Route::delete('photo/{note}/{photo}', [App\http\Controllers\User\PhotoController::class, 'destroy'])->name('photo.destroy');
    });

    
});


