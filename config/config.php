<?php 
define('ROOT', '/var/www/html/Gestion_Pedagogique');

require ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define("WEBROOT", $_ENV["WEBROOT"]);
define("VIEWS", ROOT."/views/");
require_once ROOT."/routes/web.php";
?>