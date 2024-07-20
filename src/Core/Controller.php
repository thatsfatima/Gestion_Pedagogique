<?php
namespace Apps\Core;

use Apps\Core\Session;

class Controller {
    // protected Session $session;

    // public function __construct(Session $session) {
    //     $this->session = $session;
    // }

    public function renderView($view, $data = []) {
        extract($data);
        include dirname(__DIR__, 2) . "/views/layout.html.php";
        include dirname(__DIR__, 2) . "/views/$view.html.php";
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }

    // public function toJson(){}

    // public function fromJson(){}
}

