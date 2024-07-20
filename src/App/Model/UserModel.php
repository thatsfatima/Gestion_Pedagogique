<?php
namespace Apps\App\Model;

use Apps\Core\Model\Model;
use Apps\App\App;

class UserModel extends Model {
   
    protected string $table = "user";

    public function __construct() {
        $this->database = App::getDatabase();
    }

    public function getEntity() {
        return UserEntity::class;
    }

    public function connect($login, $password) {
        $sql = "SELECT * FROM ".$this->table." u JOIN role r ON r.id = u.id_role WHERE login = ? AND password = SHA2(?, 256)";
        return $this->query($sql, [$login, $password], "Apps\App\Entity\UserEntity", true);
    }
}
?>