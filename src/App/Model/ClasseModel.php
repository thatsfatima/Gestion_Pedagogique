<?php
namespace Apps\App\Model;

use Apps\App\App;
use Apps\Core\Model\Model;
use Apps\App\Entity\ClasseEntity;

class ClasseModel extends Model{
    protected string $table = "Classe";

    public function __construct() {
        $this->database = App::getDatabase();
    }

    public function getEntity() {
        return ClasseEntity::class;
    }

    public function getDb() {
        return ClasseModel::$database;
    }

}
?>