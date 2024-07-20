<?php
namespace Apps\App\Controllers;

use Apps\App\App;
use Apps\Core\Controller\Controller;
use Apps\Core\Validators\Validator;
use Apps\Core\Files;
use Apps\App\Model\ClientModel;
use Apps\Core\Session;

class ClientController extends Controller{
    private ClientModel $clientModel;

    public function __construct() {
        $this->clientModel = App::getInstance()->getModel("ClientModel");
        parent::__construct();
    }

    public function home() {
        //$this->clientModel->getDb();
        $this->renderView("home");
    }

    public function add() {
        $this->clientModel->getDb();
        //$this->session->start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'prenom' => $_POST['prenom'],
                'nom' => $_POST['nom'],
                'email' => $_POST['email'],
                'tel' => $_POST['tel'],
                'photo' => $_FILES['photo']['name'],
            ];
    
            $rules = [
                'nom' => 'required|min:2|max:50',
                'prenom' => 'required|min:3|max:50',
                'email' => 'required|email',
                'tel' => 'required|min:9|max:9|tel',
                'photo' => 'required|photo',
            ];
    
            $this->validator->validate($data, $rules);
            $errors = $this->validator->errors();
    
            if ($this->clientModel->checkTel($_POST['tel'])) {
                $errors['telephone'] = $this->clientModel->checkTel($_POST['tel']);
            }
            if ($this->clientModel->checkEmail($_POST['email'])) {
                $errors['email2'] = $this->clientModel->checkEmail($_POST['email']);
            }
            // var_dump($errors);
            // die();
            if (empty($errors)) {
                $client = $this->clientModel->data($_POST, $_FILES["photo"]);
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $this->file->load($_FILES['photo']);
                }
                if ($client) {
                    $this->session->set("success", "Le client a bien été ajouté.");
                } else {
                    $this->session->set("error", "Erreur lors de l'ajout du client.");
                }
            } else {
                $this->session->set("errors", $errors);
                $this->session->set("fields", $_POST);
                $this->renderView("acceuil", ['errors' => $errors, 'fields' => $_POST]);
                return;
            }
        }
    
        $this->renderView("acceuil");
    }

    public function search() {
        $this->clientModel->getDb();
        //$this->session->start();
        $data = ['telSuivi' => $_POST['telSuivi']];
        $rules = ['telSuivi' => 'required|min:9|max:9|tel',];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validator->validate($data, $rules);
            $errors = $this->validator->errors();
            $client = $this->clientModel->searchByTel($_POST['telSuivi']);
            $this->renderView("acceuil",[
                'client'=>$client,
                'errors' => $errors
            ]);
            //var_dump($errors);
            if (empty($errors)) {
                if ($client) {
                    $this->session->set("fields", $_POST);
                } else {
                    $errors["telSuivi"] = "Aucun client trouvé avec ce numéro de téléphone.";
                    //$this->renderView("acceuil", $this->session->get("errorTel"));
                }
            }
        }
    }
}

?>