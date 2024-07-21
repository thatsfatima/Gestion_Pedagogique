<?php
namespace Apps\App\Model;

use Apps\App\App;
use Apps\Core\Model\Model;
use Apps\App\Entity\SessionCoursEntity;

class SessionCoursModel extends Model{
    protected string $table = "SessionCours";

    public function __construct() {
        $this->database = App::getDatabase();
    }

    public function getEntity() {
        return SessionCoursEntity::class;
    }

    public function getDb() {
        return CoursModel::$database;
    }
}
?>