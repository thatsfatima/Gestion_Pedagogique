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

    public function checkTel($telephone) {
        $sql = "SELECT COUNT(*) FROM User WHERE telephone = :telephone";
        $stmt = CoursModel::$database->getPDO()->prepare($sql);
        $stmt->execute([':telephone' => $telephone]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            return "Ce numero existe déjà";
        }
        return false;
    }

    public function checkEmail($email) {
        $sql = "SELECT COUNT(*) FROM User WHERE email = :email";
        $stmt = CoursModel::$database->getPDO()->prepare($sql);
        $stmt->execute([':email' => $email]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            return "Cet email existe déjà";
        }
        return false;
    }

    public function data($fields, $file) {
        $this->nom = $fields["nom"];
        $this->prenom = $fields["prenom"];
        $this->telephone = $fields["tel"];
        $this->email = $fields["email"];
        $this->photo = $file["name"];
        return $this->save();
    }

    public function getDb() {
        return CoursModel::$database;
    }

    public function save() {
        //var_dump("save??");
         try {
            CoursModel::$database->getPDO()->beginTransaction();

            $sql = "INSERT INTO User (nom, prenom, telephone, email, login, role_id, password) VALUES (?,?,?,?,?,?,?)";
            $hashedPassword = crypt('Frontdeterre123!', '$2y$10$' . bin2hex(random_bytes(16)));
            CoursModel::query($sql, [$this->nom, $this->prenom, $this->telephone, $this->email, $this->telephone, "3", $hashedPassword], "Apps\App\Model\CoursModel", true);
            
            $userId = CoursModel::$database->getPDO()->lastInsertId();

            $sql = "INSERT INTO Cours (id_user,photo, montantDette, montantVerse, montantRestant) VALUES (?,?,?,?,?)";
            CoursModel::query($sql, [$userId, $this->photo, 0, 0, 0], "Apps\App\Model\CoursModel", true);

            CoursModel::$database->getPDO()->commit();
            return true;
        } catch (PDOException $e) {
            CoursModel::$database->getPDO()->rollBack();
            return false;
        } 
    }

    public function queries(string $sql,array $data, bool $single = false) {
        $query = CoursModel::query($sql, $data, $single);
    }

    public function searchByTel($telephone) {
        if (!$this->checkTel($telephone)) {
            return false;
        }
        $sql = "SELECT CONCAT(u.nom, ' ', u.prenom) AS nom, u.id, u.email, c.photo, c.montantDette, c.montantVerse, c.montantRestant FROM User u JOIN Cours c ON c.id_user = u.id WHERE u.telephone = ?";
        return CoursModel::query($sql, [$telephone], $this->getEntity(), true);
    }
}

?>