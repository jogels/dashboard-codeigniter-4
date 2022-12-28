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
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('auth/login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('create-db', function () {
    $forge = \Config\Database::forge();
    if ($forge->createDatabase('webopsid_webops_db')) {
        echo 'Database created';
    }
});
$routes->get('', 'Auth::login');
$routes->get('/', 'Home::index');
$routes->get('home_admin', 'Home::home_admin');
$routes->get('home_admin_close', 'Home::home_admin_close');
$routes->get('home_admin_utility', 'Home::home_admin_utility');
$routes->get('home_user', 'Home::home_user');
$routes->get('home_user_close', 'Home::home_user_close');
$routes->get('home_admin_test', 'Home::home_admin_test');
$routes->get('home_user_test', 'Home::home_user_test');
$routes->get('register', 'Signup::index');
$routes->post('insert_user', 'Home::insert_user');
// $routes->get('/add', 'Home::create');
// $routes->post('/', 'Home::store');
// $routes->get('/update', 'Home::update');
$routes->get('/edit/(:any)', 'Home::edit/$1');
$routes->put('update/(:any)', 'Home::update/$1');
$routes->delete('home/(:segment)', 'Home::destroy/$1');
$routes->get('/profile', 'Home::view_db_profile');
$routes->get('/bydate', 'Home::view_db_intv_bydate');
$routes->get('/bydatebyintv', 'Home::view_db_intv_bydate_byintv');
$routes->get('/db_qc', 'Home::view_db_qc');
$routes->get('/db_quota', 'Home::view_db_quota');
$routes->get('/db_quota_admin', 'Home::view_db_quota_admin');
$routes->get('/db_quota_int', 'Home::view_db_quota_int');
$routes->get('/db_quota_int_perarea', 'Home::view_db_quota_int_perarea');
$routes->get('/db_intv', 'Home::view_db_intv');
$routes->get('/db_rtd_intproj1', 'Home::view_db_rtd_intproj1');
$routes->get('/db_rtd_vendor', 'Home::view_db_rtd_vendor');
$routes->get('/db_rtd_int', 'Home::view_db_rtd_int');
// $routes->get('/db_rtd_int_perproj', 'Home::view_db_rtd_int_perproj_i');
$routes->get('/db_rtd_int_perproj_i', 'Home::view_db_rtd_int_perproj_i');
$routes->get('/db_rtd_int_perproj_v', 'Home::view_db_rtd_int_perproj_v');
$routes->get('/db_sfm_load0', 'Home::view_db_sfm_load0');
$routes->get('/db_sfm_load1', 'Home::view_db_sfm_load1');
$routes->get('/db_sfm_load2', 'Home::view_db_sfm_load2');
$routes->get('/db_qualyload', 'Home::view_db_qualyload');
$routes->get('/db_dpload', 'Home::view_db_dpload');
$routes->get('/db_qualy', 'Home::view_db_qualy');
$routes->get('/db_rtd_int_proj', 'Home::view_db_rtd_int_proj');
$routes->get('/db_target_interviewer', 'Home::view_db_target_interviewer');
$routes->get('/db_rtd_int_backup', 'Home::view_db_rtd_int_backup');
$routes->get('/update_intv', 'Home::update_intv');
$routes->get('/login', 'Home::login_user');
$routes->get('/signup', 'Home::signup_user');
$routes->get('/export', 'Home::export');
$routes->get('/generatepdf', 'Home::generatepdf');
$routes->post('/import', 'Home::import');

/*
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
