<?php
namespace Apps\Core\Controller;

use Apps\Core\Session;
use Apps\Core\Validators\Validator;
use Apps\Core\Files;
use Apps\Core\Request;
use Apps\Core\Controller\ControllerInterface;

class Controller implements ControllerInterface {
    protected Session $session;
    protected Validator $validator;
    protected Files $file;
    protected $request;

    public function __construct() {
        $this->validator = new Validator();
        $this->session = new Session();
        $this->file = new Files();
        $this->request = new Request();
    }

    public function renderView($view, $data = []) {
        extract($data);
        include "../views/$view.html.php";
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }

    public function toJson(){
        return json_encode($this->file->jsonSerialize());
    }

    public function fromJson(){
        $data = $this->file->jsonSerialize();
        $this->file->setData($data);
        $this->file->save();
        return $this->file;
    }
}
?>
