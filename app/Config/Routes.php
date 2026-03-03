<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// --------------------------------------------------------------------
// WEB ROUTES (Returns HTML Views to the Browser)
// --------------------------------------------------------------------

// 1. The public admission form
$routes->get('admission', '\App\Controllers\Web\AdmissionController::index');

// 2. The form submission endpoint (Protected automatically by the Global CSRF filter)
$routes->post('admission/submit', '\App\Controllers\Web\AdmissionController::submit');

// 3. The protected Admin Dashboard
// Notice the 'filter' => 'auth:admin,staff'. This runs our AuthFilter BEFORE loading the view!
// Note: We're simply returning a view directly here for demonstration, but normally 
// you would point to an AdminController.
$routes->get('admin/dashboard', function() {
    return view('admin/dashboard');
}, ['filter' => 'auth:admin,staff']);

// --------------------------------------------------------------------
// REST API ROUTES (Returns JSON to React/Mobile Apps)
// --------------------------------------------------------------------
// We group APIs by Version. If we change the database structure next year,
// we can make a V2 API without breaking the old mobile apps still using V1!
$routes->group('api/v1', function($routes) {
    // This creates GET, POST, PUT, DELETE routes for us automatically
    // It maps POST /api/v1/admissions to Api\V1\AdmissionController::create
    // It maps GET /api/v1/admissions to Api\V1\AdmissionController::index
    $routes->resource('admissions', [
        'controller' => '\App\Controllers\Api\V1\AdmissionController'
    ]);
});
