<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// Admin Dashboard
$routes->get('/admin', 'Admin::index');

// Doctor Dashboard
$routes->get('/doctor', 'Doctor::index');

// Patient Dashboard
$routes->get('/patient', 'Patient::index');