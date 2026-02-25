<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('admin/dashboard', 'AdminController::index');
$routes->get('doctor/dashboard', 'DoctorController::index');
$routes->get('patient/dashboard', 'PatientController::index');

$routes->get('admin/doctors', 'AdminController::doctors');
$routes->post('admin/doctors/store', 'AdminController::storeDoctor');
$routes->post('admin/doctors/update/(:segment)', 'AdminController::updateDoctor/$1');
$routes->get('admin/doctors/delete/(:segment)', 'AdminController::deleteDoctor/$1');

$routes->post('doctor/update-status', 'DoctorController::updateAvailability');

$routes->post('patient/store', 'PatientController::store');