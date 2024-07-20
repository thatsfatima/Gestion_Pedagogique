<?php
namespace Apps\App\Controllers;

use Apps\App\Model\PaiementModel;
use Apps\Core\Controller\Controller;
use Apps\Core\Session;
use Apps\Core\Validators\Validator;
use Apps\App\App;

class PaiementController extends Controller {
    private $paiementModel;

    public function __construct() {
        $this->paiementModel = App::getInstance()->getModel("PaiementModel");
        parent::__construct();
    }

    public function listepaiment() {
        $this->paiementModel->getDb();
        $detteId = $_POST["idDette"];
        $paiements = $this->paiementModel->hasmany($detteId);
        $this->session->start();
        $this->session->set("paiement", $paiements);
        $this->renderView('listePaiements',$paiements);
    }

    public function paid() {
        $this->paiementModel->getDb();
        $detteId = $_POST["idDette"];
        $client = $this->paiementModel->belongsTo($detteId);
        $this->session->start();
        $this->session->set("dette", $detteId);
        $this->session->set("client", $client);
        /* var_dump($this->session->get("client"));
        die(); */
        $this->renderView("formPaiement");
    }


    public function payer() {
        $this->paiementModel->getDb();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $detteId = $_POST["idDette"];
            $montant = $_POST["montant"];
            $rules = ['montant' => 'required|montant|positif'];
            $this->session->start();
            $this->validator->validate($_POST, $rules);
            $errors = $this->validator->errors();
            if (!empty($errors)) {
                $this->session->set("errors", $errors);
                //var_dump($this->session->get("errors"));
                $this->renderView("formPaiement",$this->session->get("errors"));
                //$this->redirect("paiement/liste");
                return;
            }
            $this->paiementModel->transaction($detteId, $montant);
            $paiements = $this->paiementModel->hasMany($detteId);
            $this->session->set("paiement", $paiements);
            $this->renderView('listePaiements',$paiements);
        }
    }
}
?>