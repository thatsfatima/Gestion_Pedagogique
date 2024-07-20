<?php
namespace Apps\App\Entity;

use Apps\Core\Entity\Entity;

class PaiementEntity extends Entity{
    public $id;
    public $idDette;
    public $datePaiement;
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