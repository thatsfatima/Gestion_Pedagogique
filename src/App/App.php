<?php

namespace Apps\App;

use Apps\Core\Database\MysqlDatabase;
use Dotenv\Dotenv;
use Apps\Core\Session;
use Apps\App\Controllers\ExoController;

require_once "../config/config.php";

class App
{
    private static $instance;
    private static $database;

    private function __construct() 
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getDatabase()
    {
        if (self::$database === null) {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8";
            self::$database =new MysqlDatabase($dsn, DB_USER, DB_PASS);
        }
        return self::$database;
    }

    public function getModel($model)
    {
        $modelClass = "Apps\\App\\Model\\" .ucfirst($model);
        $new = new $modelClass() ;
        $new->setDatabase(self::getDatabase());
        return  $new;
    }

    public function notFound() {
        require_once ROOT . "/views/404.html.php";
    }

    public function forbidden() {
        require_once ROOT . "/views/403.html.php";
    }
}
