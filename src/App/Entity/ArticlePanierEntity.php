<?php
namespace Apps\App\Entity;

use Apps\Core\Entity\Entity;

class ArticlePanierEntity{
    private  $article_id;
    private  $dette_id;
    private $qte;
    private $prix;
    private $montant;
  
   public function __construct($article,$qte,$prix)
   {
      $this->article = $article;
      $this->qte = $qte;
      $this->prix = $prix;
      $this->montant = $prix*$qte;
   }
  
  }

?>