<?php

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Services;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('sign-up', 'SignUp::index');
$routes->post('sign-up/register', 'SignUp::register');
$routes->get('login', 'SignUp::loginForm');
$routes->post('sign-up/authenticate', 'SignUp::authenticate');
$routes->get('forgot-password', 'SignUp::forgotPasswordForm');
$routes->post('sign-up/send-reset-password-email', 'SignUp::sendResetPasswordEmail');
$routes->get('reset-password/(:segment)', 'SignUp::resetPasswordForm/$1');
$routes->post('sign-up/update-password', 'SignUp::updatePassword');
$routes->get('reset-password/(:segment)', 'SignUp::resetPasswordForm/$1');
$routes->get('/lock-screen', 'LockScreen::index');
$routes->post('/lock-screen/unlock', 'LockScreen::unlock');
$routes->get('/lock-screen/unlock', 'LockScreen::index');
$routes->get('/logout', 'Lockscreen::logout');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('verify-email', 'SignUp::verifyEmail');

$routes->get('healthprovider-profile', 'HealthcareProviderProfileController::index');
$routes->get('patient-profile', 'PatientProfileController::index');

$routes->get('admin-dashboard', 'AdminDashboardController::index');


// $routes->get('register', 'Register::index'); // Show the admin profiles
// $routes->get('register/create', 'Register::create'); // Show the create admin form
// $routes->post('register/store', 'Register::store'); // Handle the create admin form submission
// $routes->get('register/edit/(:num)', 'Register::edit/$1'); // Show the edit admin form
// $routes->post('register/update/(:num)', 'Register::update/$1'); // Handle the edit admin form submission
// $routes->get('register/delete/(:num)', 'Register::delete/$1'); // Handle the admin deletion




//$routes->get('doctors', 'DoctorCrudController::index');
$routes->get('doctors/add', 'DoctorCrudController::add');
$routes->get('doctors/edit/(:num)', 'DoctorCrudController::edit/$1');
$routes->get('doctors/delete/(:num)', 'DoctorCrudController::delete/$1');

//$routes->get('applications', 'DoctorCrudController::applications');

$routes->get('applications_view', 'DoctorCrudController::applications_view');
//$routes->get('application/accept/(:num)', 'DoctorCrudController::accept_application/$1');
//$routes->get('application/deny/(:num)', 'DoctorCrudController::deny_application/$1');


//$routes->get('DoctorCrudController/accept_application/(:num)', 'DoctorCrudController::accept_application/$1');
//$routes->get('DoctorCrudController/deny_application/(:num)', 'DoctorCrudController::deny_application/$1');


$routes->get('/DoctorCrudController', 'DoctorCrudController::index');
$routes->get('/DoctorCrudController/applications_view', 'DoctorCrudController::applications_view');
$routes->get('/DoctorCrudController/accept_application/(:num)', 'DoctorCrudController::accept_application/$1');
$routes->get('/DoctorCrudController/deny_application/(:num)', 'DoctorCrudController::deny_application/$1');


$routes->get('manage-users', 'DoctorCrudController::manage_users');
$routes->get('view-doctors', 'DoctorCrudController::view_doctors');
$routes->get('view-patients', 'DoctorCrudController::view_patients');

$routes->get('admin/profile', 'AdminController::profile');


$routes->get('/NurseCrudController', 'NurseCrudController::index');
$routes->get('view-nurses', 'NurseCrudController::view_nurses');
