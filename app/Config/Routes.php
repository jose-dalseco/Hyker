<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rotas para UserController
$routes->group('users', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->post('/', 'UserController::create');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->put('(:num)', 'UserController::update/$1');
    $routes->delete('(:num)', 'UserController::delete/$1');
});

// Rotas para ProductController
$routes->group('products', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->post('/', 'ProductController::create');
    $routes->get('(:num)', 'ProductController::show/$1');
    $routes->put('(:num)', 'ProductController::update/$1');
    $routes->delete('(:num)', 'ProductController::delete/$1');
});

// Rotas para CategoryController
$routes->group('categories', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'CategoryController::index');
    $routes->post('/', 'CategoryController::create');
    $routes->get('(:num)', 'CategoryController::show/$1');
    $routes->put('(:num)', 'CategoryController::update/$1');
    $routes->delete('(:num)', 'CategoryController::delete/$1');
});

// Rotas para OrderController
$routes->group('orders', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'OrderController::index');
    $routes->post('/', 'OrderController::create');
    $routes->get('(:num)', 'OrderController::show/$1');
    $routes->put('(:num)', 'OrderController::update/$1');
    $routes->delete('(:num)', 'OrderController::delete/$1');
});

// Rotas para ReviewController
$routes->group('reviews', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'ReviewController::index');
    $routes->post('/', 'ReviewController::create');
    $routes->get('(:num)', 'ReviewController::show/$1');
    $routes->put('(:num)', 'ReviewController::update/$1');
    $routes->delete('(:num)', 'ReviewController::delete/$1');
});

// Rota para o carrinho de compras
$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/remove', 'CartController::remove');
$routes->post('cart/update', 'CartController::update');

// Rota para o checkout
$routes->get('checkout', 'CheckoutController::index');
$routes->post('checkout/process', 'CheckoutController::process');

// Rota para o histórico de pedidos do usuário
$routes->get('user/orders', 'UserController::orders');
