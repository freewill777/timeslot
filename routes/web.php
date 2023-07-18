<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\ServiceController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\Consultant;
use App\Models\Service;

use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    $appointments = Appointment::all();
    $consultants = Consultant::all();
    $services = Service::all();
    return view('welcome', [
        'appointments' => $appointments,
        'consultants' => $consultants,
        'services' => $services,
    ]);
})->name('index');

Route::post(
    '/appointments',
    [AppointmentController::class, 'create']
)->name('appointment.create');

Route::delete(
    '/appointment/{id}',
    [AppointmentController::class, 'delete']
)->name('appointment.delete');

Route::post(
    '/consultants',
    [ConsultantController::class, 'create']
)->name('consultant.create');

Route::delete(
    '/consultant/{id}',
    [ConsultantController::class, 'delete']
)->name('consultant.delete');

Route::post(
    '/services',
    [ServiceController::class, 'create']
)->name('service.create');

Route::delete(
    '/service/{id}',
    [ServiceController::class, 'delete']
)->name('service.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    $appointments = Appointment::all();
    $consultants = Consultant::all();
    $services = Service::all();
    return view(
        'admin',
        [
            'appointments' => $appointments,
            'consultants' => $consultants,
            'services' => $services,
        ]
    );
})->name('admin');

Route::get('health-check', function () {
    return response()->json(['status' => 'OK', 'timestamp' => Carbon::now()]);
});

Route::post('booking', function (Request $request) {
    $body = $request->getContent();
    $data = json_decode($body);

    $appointment = new Appointment();
    $appointment->consultant_name = $data->consultant;
    $appointment->service_name = $data->service;
    $appointment->date = $data->date;
    $saved = $appointment->save();

    if (!$saved) {
        return response()->json([
            'status' => 'Error',
            'message' => 'Failed to save the appointment',
        ], 500);
    }

    return response()->json(
        [
            'status' => 'Success',
            'timestamp' => Carbon::now(),
            'echo' => $body,
            'appointment' => $appointment,

        ]
    );
    ;
});

require __DIR__ . '/auth.php';
