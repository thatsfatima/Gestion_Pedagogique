<?php
namespace Apps\App\Entity;

use Apps\Core\Entity\Entity;

class ClientEntity extends Entity{
    public $id;
    public $nom;
    public $prenom;
    public $telephone;
    public $email;
    public $login;
    public $password;
    public $photo;
    public $montantDette;
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