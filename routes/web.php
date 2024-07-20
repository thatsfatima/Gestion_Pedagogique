<?php

use Apps\Core\Router;

Router::get("", "SecurityController", "login");
Router::get("login", "SecurityController", "login");
Router::post("add-client", "ClientController", "addClient");
Router::post("check-client", "ClientController", "searchClientByTel");
Router::post("list-paiement", "ListDetteController", "ListPayementByOneDette");
Router::post("list-dette", "ListDetteController", "showListDette");
Router::post("ajout-dette", "AjoutDetteController", "showAjoutDette");

$uri = trim($_SERVER['REQUEST_URI'], '/');
$uri = preg_replace('#/+#', '/', $uri);
$method = $_SERVER['REQUEST_METHOD'];
Router::create($uri, $method);
