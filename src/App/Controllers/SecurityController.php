<?php
namespace Apps\App\Controllers;

use Apps\App\Model\UserModel;
use Apps\Core\Controller\Controller;
use Apps\App\App;

class SecurityController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = App::getInstance()->getModel("UserModel");
        parent::__construct();
    }

    public function login() {
        if ($this->session->get("logged_in")) {
            $this->renderView("acceuil");
            return;
        }
        if ($this->request->isPost()) {
            $login = $this->request->getPost("login");
            $password = $this->request->getPost("password");
            $logged = UserModel->connect($login, $password);
            return;
        } else {
            $this->renderView("login");
            return;
        }
        $this->renderView("login");
    }
    
    public function logout() {
        $this->renderView("login");
        $this->session->destroy();
    }
}
?>