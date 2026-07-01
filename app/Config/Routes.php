<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rotas do Totem de Pedidos
$routes->get('/pedidos', 'Home::index');
$routes->get('/pedidos/iniciar', 'Home::iniciarPedido');
$routes->post('/pedidos/configurar-totem', 'Home::configurarTotem');
$routes->get('/pedidos/carrinho', 'Pedidos::carrinho');
$routes->get('/pedidos/adicionar/(:num)', 'Pedidos::adicionarCarrinho/$1');
$routes->get('/pedidos/remover/(:num)', 'Pedidos::removerCarrinho/$1');
$routes->get('/pedidos/atualizar/(:num)/(:num)', 'Pedidos::atualizarQuantidade/$1/$2');
$routes->get('/pedidos/confirmar', 'Pedidos::confirmarPedido');
$routes->get('/pedidos/novo', 'Pedidos::novopedido');
