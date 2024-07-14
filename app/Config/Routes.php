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
 $routes->get('lock-screen', 'LockScreen::index');
 $routes->post('lock-screen/unlock', 'LockScreen::unlock');
 $routes->get('logout', 'LockScreen::logout');
 $routes->get('dashboard', 'Dashboard::index');
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
 $routes->post('doctors/update/(:num)', 'DoctorCrudController::update/$1');

 $routes->get('nurses/add', 'NurseCrudController::add');
 $routes->get('nurses/edit/(:num)', 'NurseCrudController::edit/$1');
 $routes->get('nurses/delete/(:num)', 'NurseCrudController::delete/$1');
 $routes->post('nurses/update/(:num)', 'NurseCrudController::update/$1');

 $routes->get('patients/add', 'PatientCrudController::add');
 $routes->get('patients/edit/(:num)', 'PatientCrudController::edit/$1');
 $routes->get('patients/delete/(:num)', 'PatientCrudController::delete/$1');
 $routes->post('patients/update/(:num)', 'PatientCrudController::update/$1');
 
 $routes->get('applications_view', 'DoctorCrudController::applications_view');
 $routes->get('DoctorCrudController/accept_application/(:num)', 'DoctorCrudController::accept_application/$1');
 $routes->get('DoctorCrudController/deny_application/(:num)', 'DoctorCrudController::deny_application/$1');
 $routes->get('/DoctorCrudController/applications_view', 'DoctorCrudController::applications_view');

 
 $routes->get('manage-users', 'DoctorCrudController::manage_users');
 $routes->get('view-doctors', 'DoctorCrudController::view_doctors');
 $routes->get('view-patients', 'PatientCrudController::view_patients');
 $routes->get('view-nurses', 'NurseCrudController::view_nurses');

 $routes->get('view_doctors', 'DoctorCrudController::view_doctors');
 $routes->get('view_nurses', 'NurseCrudController::view_nurses');
 $routes->get('view_patients', 'DoctorCrudController::view_patients');


 
 $routes->get('admin/profile', 'AdminController::profile');
 $routes->post('admin/updateProfile', 'AdminController::updateProfile');

 $routes->get('NurseCrudController', 'NurseCrudController::index');
 $routes->get('patient-profile/dashboard', 'PatientProfileController::dashboard');
 $routes->post('patient-profile/bookAppointment', 'PatientProfileController::bookAppointment');
 
 $routes->get('stats', 'Stats::index');
 
 $routes->get('DoctorCrudController/suspend_doctor/(:num)', 'DoctorCrudController::suspend_doctor/$1');
 $routes->get('view-suspended-doctors', 'DoctorCrudController::view_suspended_doctors');
 $routes->get('DoctorCrudController/restore_doctor/(:num)', 'DoctorCrudController::restore_doctor/$1');
 $routes->get('doctors/edit/(:num)', 'DoctorCrudController::edit/$1');
 $routes->get('DoctorCrudController/edit_doctor/(:num)', 'DoctorCrudController::edit_doctor/$1');
 $routes->post('DoctorCrudController/update_doctor/(:num)', 'DoctorCrudController::update_doctor/$1');
 $routes->get('DoctorCrudController/delete_doctor/(:num)', 'DoctorCrudController::delete_doctor/$1');
 $routes->post('doctor/update/(:num)', 'DoctorCrudController::update_doctor/$1');

 $routes->get('NurseCrudController/suspend_nurse/(:num)', 'NurseCrudController::suspend_nurse/$1');
 $routes->get('view-suspended-nurses', 'NurseCrudController::view_suspended_nurses');
 $routes->get('NurseCrudController/restore_nurse/(:num)', 'NurseCrudController::restore_nurse/$1');
 $routes->get('nurse/edit/(:num)', 'NurseCrudController::edit/$1');
 $routes->get('NurseCrudController/edit_nurse/(:num)', 'NurseCrudController::edit_nurse/$1');
 $routes->post('NurseCrudController/update_nurse/(:num)', 'NurseCrudController::update_nurse/$1');
 $routes->get('NurseCrudController/delete_nurse/(:num)', 'NurseCrudController::delete_nurse/$1');
 $routes->post('nurse/update/(:num)', 'NurseCrudController::update_nurse/$1');


 $routes->get('PatientCrudController/edit_patient/(:num)', 'PatientCrudController::edit_patient/$1');
 $routes->get('PatientCrudController/delete_patient/(:num)', 'PatientCrudController::delete_patient/$1');
 $routes->get('patients/edit/(:num)', 'PatientCrudController::edit/$1');
$routes->post('PatientCrudController/update_patient/(:num)', 'PatientCrudController::update_patient/$1');
$routes->get('PatientCrudController/delete_patient/(:num)', 'PatientCrudController::delete_patient/$1');



 $routes->get('doctor/search', 'DoctorCrudController::search');
 $routes->get('nurse/search', 'NurseCrudController::search');
 $routes->get('patient/search', 'PatientCrudController::search');

 
 $routes->get('healthcareprovider-profile/profile', 'HealthcareProviderProfileController::profile');
 $routes->post('healthcareprovider-profile/editProfile', 'HealthcareProviderProfileController::editProfile');
 $routes->post('healthcareprovider-profile/uploadPhoto', 'HealthcareProviderProfileController::uploadPhoto');
 
 $routes->get('appointments', 'AppointmentController::index');
 $routes->get('appointments/book', 'AppointmentController::book');
 $routes->post('appointments/book', 'AppointmentController::book');
 
 // Admin routes
 $routes->group('admin', function ($routes) {
     $routes->get('profile', 'AdminController::profile');
     $routes->get('users', 'AdminController::users');
     $routes->post('users/create', 'AdminController::createUser');
     $routes->get('users/edit/(:num)', 'AdminController::editUser/$1');
     $routes->post('users/update/(:num)', 'AdminController::updateUser/$1');
     $routes->post('users/delete/(:num)', 'AdminController::deleteUser/$1');
    

});
