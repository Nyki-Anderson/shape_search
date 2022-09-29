<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(TRUE);
$routes->set404Override();
$routes->setAutoRoute(FALSE);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Default Route
$routes->get('/', 'Home::index', ['as' => 'home']);

$routes->get('pages/(:segment)', 'Home::view_pages/$1', ['pages']);

// Login and Registration
$routes->match(['get', 'post'], 'users/register', 'Users::register', ['filter' => 'noauth', 'as' => 'register']);
$routes->match(['get', 'post'], 'users/login', 'Users::login', ['filter' => 'noauth', 'as' => 'login']);

// Admin Routes
$routes->group('users/admin', ['filter' => 'auth'], function ($routes) 
{
    $routes->post('/dashboard', 'admin::dashboard');
});

// Users Routes
$routes->group('users/members', ['filter' => 'auth'], function ($routes)
{
    $routes->get('dashboard', 'Dashboard::index', ['as' => 'member_dashboard']);
    $routes->get('feed/(:segment)', 'Dashboard::feed/$1', ['as' => 'feed']);
    $routes->get('history', 'Dashboard::view_history', ['as' => 'history']);
    $routes->get('favorites', 'Dashboard::view_favorites', ['as' => 'favorites']);
    $routes->match(['get', 'post'], 'view_profile/(:segment)', 'Dashboard::view_profile/$1', ['as' => 'member_profile']);
    $routes->match(['get', 'post'], 'edit_profile', 'Users::edit_profile', ['as' => 'edit_profile']);
    $routes->match(['get', 'post'], 'upload_profile_image', 'Users::profile_image', ['as' => 'profile_image']);
    $routes->match(['get', 'post'], 'manage_uploads', 'Dashboard::manage_uploads', ['as' => 'manage_uploads']);
    $routes->match(['get', 'post'], 'upload_image/(:alphanum)', 'Dashboard::upload_image/$1', ['as' => 'edit_upload']);
    $routes->match(['get', 'post'], 'upload_image', 'Dashboard::upload_image', ['as' => 'new_upload']);
    $routes->get('manage_uploads/(:alphanum)', 'Dashboard::delete_upload/$1', ['as' => 'delete_upload']);
});

// Images Routes
$routes->group('images', ['filter' => 'auth'], function ($routes) {
    $routes->get('gallery', 'Gallery::index', ['as' => 'gallery']);
    $routes->match(['get', 'post'], 'view_image/(:alphanum)', 'Gallery::view_image/$1', ['as' => 'view_image']);
});

// Logout
$routes->get('logout', 'Users::logout', ['as' => 
'logout']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
