<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MechanicController;

Route::get('/', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/mechanics/available', [MechanicController::class, 'getAvailableMechanics'])->name('mechanics.available');

Route::prefix('admin')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('admin.appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
});
