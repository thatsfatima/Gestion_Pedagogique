<?php
namespace Apps\Core\Controller;

interface ControllerInterface {
    public function renderView($view, $data = []);
    public function redirect($url);
    public function toJson();
    public function fromJson();
}
?>