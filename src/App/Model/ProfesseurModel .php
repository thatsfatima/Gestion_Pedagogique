<?php
namespace Apps\App\Model;

use Apps\App\App;
use Apps\Core\Model\Model;
use Apps\App\Entity\ClientEntity;

class ClientModel extends Model{
    protected string $table = "Client";

    public function __construct() {
        $this->database = App::getDatabase();
    }

    public function getEntity() {
        return ProfesseurEntity::class;
    }
    
    public function getDb() {
        return CoursModel::$database;
    }
}

?>