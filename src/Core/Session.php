<?php
namespace Apps\Core;

class Session {
  
    public function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function close() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }


    public function isset($key) {
        return isset($_SESSION[$key]);
    }
}
