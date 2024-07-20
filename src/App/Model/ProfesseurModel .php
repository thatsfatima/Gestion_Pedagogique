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
        return ClientEntity::class;
    }

    public function checkTel($telephone) {
        $sql = "SELECT COUNT(*) FROM User WHERE telephone = :telephone";
        $stmt = ClientModel::$database->getPDO()->prepare($sql);
        $stmt->execute([':telephone' => $telephone]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            return "Ce numero existe déjà";
        }
        return false;
    }

    public function checkEmail($email) {
        $sql = "SELECT COUNT(*) FROM User WHERE email = :email";
        $stmt = ClientModel::$database->getPDO()->prepare($sql);
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
        return ClientModel::$database;
    }

    public function save() {
        //var_dump("save??");
         try {
            ClientModel::$database->getPDO()->beginTransaction();

            $sql = "INSERT INTO User (nom, prenom, telephone, email, login, role_id, password) VALUES (?,?,?,?,?,?,?)";
            $hashedPassword = crypt('Frontdeterre123!', '$2y$10$' . bin2hex(random_bytes(16)));
            ClientModel::query($sql, [$this->nom, $this->prenom, $this->telephone, $this->email, $this->telephone, "3", $hashedPassword], "Apps\App\Model\ClientModel", true);
            
            $userId = ClientModel::$database->getPDO()->lastInsertId();

            $sql = "INSERT INTO Client (id_user,photo, montantDette, montantVerse, montantRestant) VALUES (?,?,?,?,?)";
            ClientModel::query($sql, [$userId, $this->photo, 0, 0, 0], "Apps\App\Model\ClientModel", true);

            ClientModel::$database->getPDO()->commit();
            return true;
        } catch (PDOException $e) {
            ClientModel::$database->getPDO()->rollBack();
            return false;
        } 
    }

    public function queries(string $sql,array $data, bool $single = false) {
        $query = ClientModel::query($sql, $data, $single);
    }

    public function searchByTel($telephone) {
        if (!$this->checkTel($telephone)) {
            return false;
        }
        $sql = "SELECT CONCAT(u.nom, ' ', u.prenom) AS nom, u.id, u.email, c.photo, c.montantDette, c.montantVerse, c.montantRestant FROM User u JOIN Client c ON c.id_user = u.id WHERE u.telephone = ?";
        return ClientModel::query($sql, [$telephone], $this->getEntity(), true);
    }
}

?>