<?php
namespace Apps\App\Model;

use Apps\App\App;
use Apps\Core\Model\Model;
use Apps\App\Entity\CoursEntity;

class CoursModel extends Model{
    protected string $table = "Cours";

    public function __construct() {
        $this->database = App::getDatabase();
    }

    public function getEntity() {
        return CoursEntity::class;
    }

    public function getDb() {
        return CoursModel::$database;
    }

}
?>