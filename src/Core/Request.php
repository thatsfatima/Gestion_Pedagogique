<?php
namespace Apps\Core;

class Request {
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function getPost($key) {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
}

?>