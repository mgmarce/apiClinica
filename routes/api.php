<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//rutas para los pacientes
Route::get('/v1/patients', [PatientController::class, 'index']);
Route::post('/v1/patients', [PatientController::class, 'store']);
//Ruta con parametro
Route::get('/v1/patients/{patientId}', [PatientController::class, 'patient_by_id']);
//PUT actualiza completamente todo el recurso
//PATCH actualiza solo una parte de todo el recurso
Route::patch('/v1/patients/{patientId}', [PatientController::class, 'update']);

//rutas para las citas
Route::post('/v1/appointments', [AppointmentsController::class, 'store']);
//Route::get('/v1/appointments/{startDate?}/{endDate?}', [AppointmentsController::class, 'get_appointments']);