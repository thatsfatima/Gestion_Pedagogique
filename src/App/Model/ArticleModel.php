<?php
namespace Apps\App\Model;

use Apps\Core\Model\Model;
use Apps\App\Entity\ArticleEntity;

class ArticleModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function getDb() {
        return ArticleModel::$database;
    }

    public function belongToMany($idDette) {
        $sql = "SELECT a.Ref AS ref, a.libelle AS libelle, ad.qte AS quantite, a.prixUnitaire AS prixUnitaire, (a.prixUnitaire * ad.qte) AS montant FROM ArticleDette ad JOIN Article a ON a.id = ad.article_id WHERE ad.dette_id = ? ORDER BY a.libelle";
        return $this->getDb()->prepare($sql, [$idDette], "Apps\App\Entity\ArticleEntity");
    }
    
    public function findByRef($ref)
    {
        $sql = "SELECT id, libelle, prixUnitaire, qteStock FROM Article WHERE Ref = :ref";
        $result = $this->getDb()->prepare($sql, ['ref' => $ref], "Apps\App\Entity\ArticleEntity", true);
        if ($result) {
            return new ArticleEntity($result);
        }
        return null;
    }
}
?>