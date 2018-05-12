<?php
require_once 'vendor/autoload.php';

// The router class is the main entry point for interaction.
$router = new if0xx\HuaweiHilinkApi\Router;

// if specified without http or https, assumes http://
$router->setAddress('192.168.8.1');

// Username and password.
// Username is always admin as far as I can tell, default password is admin as well.
$router->login('admin', 'admin');

var_dump($router->getInbox());
//var_dump($router->getNetwork());


