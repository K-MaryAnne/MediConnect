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

$routes->get('user-profile', 'HealthcareProviderProfileController::index');


