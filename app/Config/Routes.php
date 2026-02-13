<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/admin', 'AdminController::index');
$routes->get('/doctor', 'DoctorController::index');
$routes->get('patient', 'PatientController::index');
