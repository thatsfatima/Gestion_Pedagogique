<?php
namespace Apps\App\Entity;

use Apps\Core\Entity\Entity;

class UserEntity extends Entity{
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $login;
    private $email;
    private $password;
    private $id_role;
    private $libelle;
}

?>