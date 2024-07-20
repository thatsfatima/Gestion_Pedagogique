<?php
namespace Apps\App\Model;

use Apps\Core\Model\Model;
use Apps\App\App;

class UserModel extends Model {
   
    protected string $table = "User";

    public function __construct() {
        $this->database = App::getDatabase();
    }

    public function getEntity() {
        return UserEntity::class;
    }

    public function connect() {
        $this->database->connect();
        
    }
}
?>