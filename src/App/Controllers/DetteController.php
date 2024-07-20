<?php
namespace Apps\App\Controllers;

use Apps\Core\Controller\Controller;
use Apps\Core\Session;
use Apps\App\App;
use Apps\App\Model\DetteModel;
use Apps\Core\Data;

class DetteController extends Controller {
    private $detteModel;
    private $articleModel;

    public function __construct() {
        $this->detteModel = App::getInstance()->getModel("DetteModel");
        $this->articleModel = App::getInstance()->getModel("ArticleModel");
        parent::__construct();
    }

    public function index() {
        $this->detteModel->getDb();
        $index = $_POST["Statut"] ?? "Restant";
        $this->session->start();
        if (isset($_POST['filtreDate'])) {
            $date = $_POST['filtreDate'];
            $dettes = $this->detteModel->findByDate($index, $date);
        }
        if (isset($_POST['idClient'])) {
            $this->session->set("idClient", $_POST["idClient"]);
        }
        $clientId = $this->session->get("idClient");
        $dettes = $this->detteModel->belongsTo($index, $clientId);
        $current = 1;
        if (isset($_POST['current'])) {
            $current = intval($_POST['current']) > 0 ? intval($_POST['current']) : 1;
        }
        $this->session->set("current", $current);
        $this->data = new Data($dettes);
        $dettes = $this->data->show(1, $current)['data'];
        // var_dump($dettes);
        // die();
        $this->session->set("dette", $dettes);
        $this->session->set("nbpages", $this->data->show(1, $current)['pagination']['nbpages']);
        $this->renderView('listeDettes',$dettes);
    }
    
    public function store() {
        if (isset($_POST['idClient'])) {
            $this->session->set("idClient", $_POST["idClient"]);
        }
        $this->renderView("formDette");
    }

    public function addDette() {
        $data = [
            'client_id' => $_POST['client_id'],
            'montant' => $_POST['montant']
        ];

        $this->detteModel->transaction(function($db) use ($data) {
            $detteId = $this->detteModel->save($data);

            foreach ($_POST['articles'] as $article) {
                $articleData = [
                    'id_Article' => $article['id'],
                    'id_Dette' => $detteId,
                    'prix_unitaire' => $article['prix_unitaire'],
                    'quantite' => $article['quantite'],
                    'montant' => $article['prix_unitaire'] * $article['quantite']
                ];
                $this->detteModel->saveArticle($articleData);
            }
        });

        $this->renderView("list_dette", []);
    }

    public function getArticleByRef(){
        $ref = $_POST['ref'];
        $article = $this->articleModel->findByRef($ref);
        var_dump($article);
        $this->renderView("formDette", ['article' => $article]);
    }

    public function storeArticle(){
        $this->session->start();
        $dataArticle = $this->session->get('dataArticle')?? [];
        $dataArticle[] = [
            'id_article' => $_POST['id_article'],
            'libelle' => $_POST['libelle'],
            'prixUnitaire' => $_POST['prixUnitaire'],
            'qte' => $_POST['qte']
        ];
        $montant = 0;
        foreach ($dataArticle as $article) {
            $montant += $article['prixUnitaire'] * $article['qte'];
        }
        var_dump($dataArticle);
        $this->session->set('montant', $montant);
        // array_push($dataArticle, $this->getArticleByRef());
        $this->session->set('dataArticle', $dataArticle);
        $this->renderView("formDette", ['dataArticle' => $dataArticle]);
    }
}
?>