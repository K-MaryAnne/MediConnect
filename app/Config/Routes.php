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
$routes->get('/lock-screen', 'LockScreen::index');
$routes->post('/lock-screen/unlock', 'LockScreen::unlock');
$routes->get('/logout', 'LockScreen::logout');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('verify-email', 'SignUp::verifyEmail');

$routes->get('healthprovider-profile', 'HealthcareProviderProfileController::index');
$routes->get('patient-profile', 'PatientProfileController::index');
$routes->get('patient-profile/profile', 'PatientProfileController::profile');
$routes->post('patient-profile/editProfile', 'PatientProfileController::editProfile');
$routes->post('patient-profile/uploadPhoto', 'PatientProfileController::uploadPhoto');

$routes->get('rate/doctor/(:num)', 'Rating::rateDoctor/$1');
$routes->get('rate/patient/(:num)', 'Rating::ratePatient/$1');

$routes->post('rating/rateDoctor/(:num)', 'RatingController::rateDoctor/$1');
$routes->post('rating/ratePatient/(:num)', 'RatingController::ratePatient/$1');

$routes->get('admin-dashboard', 'AdminDashboardController::index');

$routes->get('doctors/add', 'DoctorCrudController::add');
$routes->get('doctors/edit/(:num)', 'DoctorCrudController::edit/$1');
$routes->get('doctors/delete/(:num)', 'DoctorCrudController::delete/$1');



//$routes->get('applications', 'DoctorCrudController::applications');

$routes->get('applications_view', 'DoctorCrudController::applications_view');
$routes->get('/DoctorCrudController', 'DoctorCrudController::index');
$routes->get('/DoctorCrudController/applications_view', 'DoctorCrudController::applications_view');
$routes->get('/DoctorCrudController/accept_application/(:num)', 'DoctorCrudController::accept_application/$1');
$routes->get('/DoctorCrudController/deny_application/(:num)', 'DoctorCrudController::deny_application/$1');


$routes->post('DoctorCrudController/update_doctor/(:num)', 'DoctorCrudController::update_doctor/$1');
$routes->post('NurseCrudController/update_nurse/(:num)', 'NurseCrudController::update_nurse/$1');


$routes->get('manage-users', 'DoctorCrudController::manage_users');
$routes->get('view-doctors', 'DoctorCrudController::view_doctors');
$routes->get('view-patients', 'DoctorCrudController::view_patients');


$routes->get('/view_doctors', 'DoctorCrudController::view_doctors');
$routes->get('/view_nurses', 'NurseCrudController::view_nurses');


$routes->get('admin/profile', 'AdminController::profile');
$routes->get('/NurseCrudController', 'NurseCrudController::index');
$routes->get('view-nurses', 'NurseCrudController::view_nurses');
$routes->get('patient-profile/dashboard', 'PatientProfileController::dashboard');
$routes->post('patient-profile/bookAppointment', 'PatientProfileController::bookAppointment');
$routes->get('DoctorCrudController/edit_doctor/(:num)', 'DoctorCrudController::edit_doctor/$1');
$routes->post('DoctorCrudController/update_doctor/(:num)', 'DoctorCrudController::update_doctor/$1');
$routes->get('DoctorCrudController/delete_doctor/(:num)', 'DoctorCrudController::delete_doctor/$1');
$routes->get('NurseCrudController/edit_nurse/(:num)', 'NurseCrudController::edit_nurse/$1');
$routes->post('NurseCrudController/update_nurse/(:num)', 'NurseCrudController::update_nurse/$1');
$routes->get('NurseCrudController/delete_nurse/(:num)', 'NurseCrudController::delete_nurse/$1');
$routes->post('doctor/update/(:num)', 'DoctorCrudController::update_doctor/$1');
$routes->post('nurse/update/(:num)', 'NurseCrudController::update_nurse/$1');
$routes->get('stats', 'Stats::index');


$routes->get('healthcareprovider-profile', 'HealthcareProviderProfileController::index');
$routes->get('healthcareprovider-profile/profile', 'HealthcareProviderProfileController::profile');
$routes->post('healthcareprovider-profile/editProfile', 'HealthcareProviderProfileController::editProfile');
$routes->post('healthcareprovider-profile/uploadPhoto', 'HealthcareProviderProfileController::uploadPhoto');

// Rating routes
$routes->get('rate/doctor/(:num)', 'RatingController::rateDoctor/$1');
$routes->post('rate/doctor/(:num)', 'RatingController::rateDoctor/$1');
$routes->get('rate/patient/(:num)', 'RatingController::ratePatient/$1');
$routes->post('rate/patient/(:num)', 'RatingController::ratePatient/$1');

$routes->get('appointments', 'AppointmentController::index');
$routes->get('appointments/book', 'AppointmentController::book');
$routes->post('appointments/book', 'AppointmentController::book');

// Dashboard route
$routes->get('dashboard', 'Dashboard::index');

// Admin routes (example)
$routes->group('admin', function ($routes) {
    $routes->get('profile', 'AdminController::profile');
    $routes->get('users', 'AdminController::users');
    $routes->post('users/create', 'AdminController::createUser');
    $routes->get('users/edit/(:num)', 'AdminController::editUser/$1');
    $routes->post('users/update/(:num)', 'AdminController::updateUser/$1');
    $routes->post('users/delete/(:num)', 'AdminController::deleteUser/$1');
});
