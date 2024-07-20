<?php
namespace Apps\App\Controllers;

use Apps\App\Model\ArticleModel;
use Apps\Core\Controller\Controller;
use Apps\Core\Session;
use Apps\App\App;

class ArticleController extends Controller {
    private $articleModel;

    public function __construct() {
        $this->articleModel = App::getInstance()->getModel("articleModel");
        parent::__construct();
    }


    public function detail() {
        $this->articleModel->getDb();
        $idDette = $_POST['idDette'];
        $article = $this->articleModel->belongToMany($idDette);
        $this->session->start();
        $this->session->set("article", $article);
        $this->renderView("listeArticles", $article);
    }
}

?>