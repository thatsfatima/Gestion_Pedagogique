<?php
namespace Apps\App\Controllers;

use Apps\App\App;
use Apps\Core\Controller\Controller;

class ErrorController extends Controller {
    public static function Error_404() {
        
        App::getInstance()->notFound();
    }
}

?>