<?php

use CodeIgniter\Router\RouteCollection;
// use 

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/registration', 'Home::register_user');
$routes->get('/login', 'Home::login');
$routes->post('/authentication', 'Home::authenticate');
$routes->get('/dashboard', 'Home::dashboard');
$routes->get('/profile', 'Home::profile_details');
$routes->get('/search_result', 'Home::fetch_result');
$routes->post('/search_result', 'Home::fetch_result');
$routes->post('/update-profile', 'Home::updateProfile');
