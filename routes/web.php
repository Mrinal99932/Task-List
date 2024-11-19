<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;


Route::get('/login',[UserController::class,'index'])->name('loginpage');
Route::post('/auth',[UserController::class,'login'])->name('login');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/signup',[UserController::class,'signup'])->name('signup');
Route::post('/register',[UserController::class,'register'])->name('register');
Route::get('/user-request',[UserController::class,'userrequest'])->name('user-request');
Route::post('/user-requests/{id}/accept', [UserController::class, 'acceptRequest'])->name('accept-request');

Route::get('/',[TaskController::class,'index'])->name('dashboard');
Route::get('/add-tasks',[TaskController::class,'addtasks'])->name('add-tasks');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/task/{id}/complete', [TaskController::class, 'completeTask'])->name('complete-task');