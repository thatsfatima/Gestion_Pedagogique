<?php
namespace Apps\App\Model;

use Apps\Core\Model\Model;

class DetteModel extends Model {
    public function __construct() {
        parent::__construct();
    }


    public function getDb() {
        return DetteModel::$database;
    }

    public function BelongsTo($statut, $clientId) {
        $sql = "SELECT u.id AS clientId, CONCAT(u.nom,' ', u.prenom) AS nom, u.telephone AS telephone, DATE_FORMAT(d.date, '%d / %m / %Y') AS dateDette, d.id AS id, d.montant AS montant, d.montantVerse AS montantVerse, d.montantRestant AS montantRestant FROM Dette d JOIN User u ON u.id =d.client_id WHERE d.client_id = ? AND d.montantRestant > 0";
        if ($statut === "Solde") {
            $sql = "SELECT u.id AS clientId, CONCAT(u.nom,' ', u.prenom) AS nom, u.telephone AS telephone, DATE_FORMAT(d.date, '%d / %m / %Y') AS dateDette, d.id AS id, d.montant AS montant, d.montantVerse AS montantVerse, d.montantRestant AS montantRestant FROM Dette d JOIN User u ON u.id =d.client_id WHERE d.client_id = ? AND d.montantRestant = 0";
        }
        return $this->getDb()->prepare($sql, [$clientId], "Apps\App\Entity\DetteEntity");
    }

    public function save($montant, $clientId, $articles) {
        //var_dump("save??");
         try {
            DetteModel::$database->getPDO()->beginTransaction();

            $sql = "INSERT INTO Dette (montant, montantVerse, montantRestant, client_id) VALUES (?,0,0,?)";
            DetteModel::query($sql, [$montant, $clientId], "Apps\App\Model\DetteModel", true);
            
            $sql = "UPDATE Client SET montantDette = ?, montantVerse = ?, montantRestant = ? WHERE id_user = ?";
            DetteModel::query($sql, [$clientId,], "Apps\App\Model\ClientModel", true);

            $detteId = DetteModel::$database->getPDO()->lastInsertId();

            foreach ($articles as $article) {
                $sql = "SELECT id FROM Article WHERE Ref = ?";
                $articleId = DetteModel::query($sql, [$article->ref], "Apps\App\Model\ArticleModel", true);
                $sql = "INSERT INTO ArticleDette (article_id, dette_id, qte, montant) VALUES (?,?,?,?)";
                DetteModel::query($sql, [$articleId, $detteId, $article->qte, $article->montant], "Apps\App\Model\DetteModel", true);
                $sql = "UPDATE Article SET quantite = quantite -? WHERE id =?";
                DetteModel::query($sql, [$article->qte, $articleId], "Apps\App\Model\ArticleModel", true);
            }

            DetteModel::$database->getPDO()->commit();
            return true;
        } catch (PDOException $e) {
            DetteModel::$database->getPDO()->rollBack();
            return false;
        } 
    }
}
?>