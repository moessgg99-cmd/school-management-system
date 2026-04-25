<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('main');
})->name('home');

Route::get('/login',[AuthController::class,'login'])->name('login');

Route::get('/register',[AuthController::class,'register'])->name('register');

Route::get('/enrollment',[StudentController::class,'enrollment'])->name('student.enroll');

Route::get('/attend',[StudentController::class,'attend'])->name('student.attend');

Route::get('/grade',[StudentController::class,'grade'])->name('student.grade');

Route::get('/teacher/directory',[TeacherController::class,'directory'])->name('teacher.directory');

Route::get('/teacher/schedule',[TeacherController::class,'schedule'])->name('teacher.schedule');

Route::get('/teacher/performance',[TeacherController::class,'performance'])->name('teacher.performance');

Route::get('/timetable',[TimetableController::class,'index'])->name('timetable.index');

Route::get('/exams',[TimetableController::class,'exams'])->name('timetable.exams');

Route::get('/fee',[TimetableController::class,'fee'])->name('fees');

Route::get('/library',[TimetableController::class,'library'])->name('library');






