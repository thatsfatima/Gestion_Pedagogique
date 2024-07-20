<?php
namespace Apps\App\Model;

use Apps\Core\Model\Model;

class PaiementModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function getDb() {
        return PaiementModel::$database;
    }

    public function belongsTo($detteId) {
        $sql = "SELECT u.nom AS nom, u.prenom AS prenom, u.telephone AS telephone, d.montant AS montantDette, d.montantVerse AS montantVerse, d.montantRestant AS montantRestant FROM Dette d JOIN User u ON u.id = d.client_id WHERE d.id = ?";
        return $this->getDb()->prepare($sql, [$detteId], "Apps\App\Entity\ClientEntity", true);
    }

    public function hasMany($detteId) {
        $sql = "SELECT d.id AS idDette, p.montant AS montant,  DATE_FORMAT(p.date, '%d / %m / %Y') AS datePaiement FROM Paiement p JOIN Dette d ON d.id =p.dette_id WHERE p.dette_id = ?";
        return $this->getDb()->prepare($sql, [$detteId], "Apps\App\Entity\PaiementEntity");
    }

    public function transaction($detteId, $montant) {
         try {
            PaiementModel::$database->getPDO()->beginTransaction();

            $sql = "INSERT INTO Paiement (dette_id, montant, date) VALUES (?,?, NOW())";
            PaiementModel::query($sql, [$detteId, $montant], "Apps\App\Model\PaiementModel", true);  

            $sql = "SELECT montantVerse, montantRestant FROM Dette WHERE id = ?";
            $paiement = PaiementModel::query($sql, [$detteId], "Apps\App\Model\DetteModel", true);
            $montantVerse = $paiement->montantVerse + $montant;
            $montantRestant = $paiement->montantRestant - $montant;

            $sql = "UPDATE Dette SET montantVerse = ?, montantRestant = ? WHERE id = ?";
            PaiementModel::query($sql, [$montantVerse, $montantRestant, $detteId], "Apps\App\Model\DetteModel", true);

            $sql = "UPDATE Client SET montantVerse = montantVerse +?, montantRestant = montantRestant -? WHERE id_user = (SELECT client_id FROM Dette WHERE id = ?)";
            PaiementModel::query($sql, [$montant, $montant, $detteId], "Apps\App\Model\ClientModel", true);

            PaiementModel::$database->getPDO()->commit();
            return true;
        } catch (PDOException $e) {
            PaiementModel::$database->getPDO()->rollBack();
            return false;
        } 
    }
}

?>