<?php
namespace Apps\App\Controllers;

use Apps\App\App;
use Apps\Core\Controller\Controller;
use Apps\Core\Validators\Validator;
use Apps\Core\Files;
use Apps\App\Model\ProfesseurModel;
use Apps\Core\Session;

class ProfesseurController extends Controller{
    private professeurModel $professeurModel;

    public function __construct() {
        $this->professeurModel = App::getInstance()->getModel("ProfesseurModel");
        parent::__construct();
    }

    public function home() {
        //$this->professeurModel->getDb();
        $this->renderView("home");
    }

    public function add() {
        $this->professeurModel->getDb();
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
    
            if ($this->professeurModel->checkTel($_POST['tel'])) {
                $errors['telephone'] = $this->professeurModel->checkTel($_POST['tel']);
            }
            if ($this->professeurModel->checkEmail($_POST['email'])) {
                $errors['email2'] = $this->professeurModel->checkEmail($_POST['email']);
            }
            // var_dump($errors);
            // die();
            if (empty($errors)) {
                $professeur = $this->professeurModel->data($_POST, $_FILES["photo"]);
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $this->file->load($_FILES['photo']);
                }
                if ($professeur) {
                    $this->session->set("success", "Le Professeur a bien été ajouté.");
                } else {
                    $this->session->set("error", "Erreur lors de l'ajout du Professeur.");
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
        $this->professeurModel->getDb();
        //$this->session->start();
        $data = ['telSuivi' => $_POST['telSuivi']];
        $rules = ['telSuivi' => 'required|min:9|max:9|tel',];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validator->validate($data, $rules);
            $errors = $this->validator->errors();
            $professeur = $this->professeurModel->searchByTel($_POST['telSuivi']);
            $this->renderView("acceuil",[
                'Professeur'=>$professeur,
                'errors' => $errors
            ]);
            //var_dump($errors);
            if (empty($errors)) {
                if ($professeur) {
                    $this->session->set("fields", $_POST);
                } else {
                    $errors["telSuivi"] = "Aucun Professeur trouvé avec ce numéro de téléphone.";
                    //$this->renderView("acceuil", $this->session->get("errorTel"));
                }
            }
        }
    }
}

?>