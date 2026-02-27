<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/',            'AuthController::index');
$routes->get('login',        'AuthController::index');
$routes->post('auth/login',  'AuthController::login');
$routes->get('auth/logout',  'AuthController::logout');

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {

    $routes->get('dashboard', 'AdminController::index');

    $routes->get('doctors',                        'AdminController::doctors');
    $routes->get('doctors/create',                 'AdminController::createDoctor');
    $routes->post('doctors/store',                 'AdminController::storeDoctor');
    $routes->get('doctors/edit/(:segment)',         'AdminController::editDoctor/$1');
    $routes->post('doctors/update/(:segment)',      'AdminController::updateDoctor/$1');
    $routes->get('doctors/delete/(:segment)',       'AdminController::deleteDoctor/$1');

    $routes->get('patients',                       'AdminController::patients');
    $routes->get('patients/create',                'AdminController::createPatient');
    $routes->post('patients/store',                'AdminController::storePatient');
    $routes->get('patients/edit/(:segment)',        'AdminController::editPatient/$1');
    $routes->post('patients/update/(:segment)',     'AdminController::updatePatient/$1');
    $routes->get('patients/delete/(:segment)',      'AdminController::deletePatient/$1');

    $routes->get('appointments',                   'AdminController::appointments');
    $routes->get('appointments/create',            'AdminController::createAppointment');
    $routes->post('appointments/store',            'AdminController::storeAppointment');
    $routes->get('appointments/edit/(:segment)',    'AdminController::editAppointment/$1');
    $routes->post('appointments/update/(:segment)', 'AdminController::updateAppointment/$1');
    $routes->get('appointments/delete/(:segment)', 'AdminController::deleteAppointment/$1');

    $routes->get('rooms',                          'AdminController::rooms');
    $routes->get('rooms/create',                   'AdminController::createRoom');
    $routes->post('rooms/store',                   'AdminController::storeRoom');
    $routes->get('rooms/edit/(:segment)',           'AdminController::editRoom/$1');
    $routes->post('rooms/update/(:segment)',        'AdminController::updateRoom/$1');
    $routes->get('rooms/delete/(:segment)',         'AdminController::deleteRoom/$1');

    $routes->get('records',                        'AdminController::records');
    $routes->get('records/create',                 'AdminController::createRecord');
    $routes->post('records/store',                 'AdminController::storeRecord');
    $routes->get('records/edit/(:segment)',         'AdminController::editRecord/$1');
    $routes->post('records/update/(:segment)',      'AdminController::updateRecord/$1');
    $routes->get('records/delete/(:segment)',       'AdminController::deleteRecord/$1');
});

$routes->group('doctor', ['filter' => 'auth:doctor'], function ($routes) {

    $routes->get('dashboard',                          'DoctorController::index');
    $routes->post('update-status',                     'DoctorController::updateAvailability');

    $routes->get('appointments',                       'DoctorController::appointments');
    $routes->post('appointments/update/(:segment)',     'DoctorController::updateAppointmentStatus/$1');

    $routes->get('records',                            'DoctorController::records');
    $routes->get('records/create',                     'DoctorController::createRecord');
    $routes->post('records/store',                     'DoctorController::storeRecord');
    $routes->get('records/edit/(:segment)',             'DoctorController::editRecord/$1');
    $routes->post('records/update/(:segment)',          'DoctorController::updateRecord/$1');

    $routes->get('patients',                           'DoctorController::patients');
    $routes->get('profile',                            'DoctorController::profile');
    $routes->post('profile/upload-photo',              'DoctorController::uploadPhoto');
});

$routes->group('patient', ['filter' => 'auth:patient'], function ($routes) {

    $routes->get('dashboard',    'PatientController::index');
    $routes->post('book',        'PatientController::bookAppointment');
    $routes->get('appointments', 'PatientController::appointments');
    $routes->get('records',      'PatientController::records');
    $routes->get('profile',       'PatientController::profile');
    $routes->post('profile/upload-photo', 'PatientController::uploadPhoto');
});

$routes->group('api', function ($routes) {

    $routes->post('auth/login', 'Api\Auth::login');
    $routes->post('auth/logout', 'Api\Auth::logout');
    $routes->get('auth/me', 'Api\Auth::me');

    $routes->resource('patients', ['controller' => 'Api\Patient']);
    $routes->resource('doctors', ['controller' => 'Api\Doctor']);
    $routes->resource('appointments', ['controller' => 'Api\Appointment']);
    $routes->resource('medicalrecords', ['controller' => 'Api\MedicalRecord']);
    $routes->resource('rooms', ['controller' => 'Api\Room']);
});
