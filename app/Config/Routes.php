<?php

use CodeIgniter\Router\RouteCollection;

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
$routes->get('verify-email/(:segment)', 'SignUp::verifyEmail/$1');
$routes->get('verify-email/(:any)', 'SignUp::verifyEmail/$1');
$routes->get('/lock-screen', 'LockScreen::index');
$routes->post('/lock-screen/unlock', 'LockScreen::unlock');
$routes->get('/lock-screen/unlock', 'LockScreen::index');
$routes->get('/logout', 'LockScreen::logout');
$routes->get('/dashboard', 'Dashboard::index');


