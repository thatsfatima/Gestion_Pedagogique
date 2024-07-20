<?php
namespace Apps\App\Controllers;

use Apps\App\Model\UserModel;
use Apps\Core\Controller\Controller;
use Apps\Core\Security\SecurityDatabase;
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
            $logged = $this->userModel->connect($login, $password);
            var_dump($logged);
            $logged = serialize($logged);
            if (!empty($logged)) {
                $this->renderView("acceuil", $logged);
            }
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