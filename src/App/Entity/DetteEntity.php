<?php
namespace Apps\App\Entity;

use Apps\Core\Entity\Entity;

class DetteEntity extends Entity{
    public $id;
    public $clientId;
    public $nom;
    public $telephone;
    public $dateDette;
    public $montant;
    public $montantVerse;
    public $montantRestant;
    
    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    } 
}
?>