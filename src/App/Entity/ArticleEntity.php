<?php
namespace Apps\App\Entity;

use Apps\Core\Entity\Entity;

class ArticleEntity extends Entity{
    public $id;
    public $ref;
    public $libelle;
    public $prixUnitaire;
    public $qteStock;
    public $quantite;
    public $montant;
    
    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    
}
?>