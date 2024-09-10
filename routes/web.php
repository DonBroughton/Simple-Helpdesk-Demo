<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;

Route::view('/', 'home');
Route::resource('ticket', TicketController::class)->middleware('auth')->except(['edit', 'destroy']);
Route::resource('ticket.reply', TicketReplyController::class)->middleware('auth')->only(['store']);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
