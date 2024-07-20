<?php 

namespace Apps\Core\Database;
use PDO;
use PDOException;

final class MysqlDatabase {
    private $pdo;

    public function __construct($dsn, $user, $password) {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $password, $options);
            // echo "Connexion à la base de données réussie";
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }

    }

   
    public function prepare(string $sql,array $data, string $className, bool $single = false)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        if ($single) {
            return $stmt->fetch();
        }
        return $stmt->fetchAll();
    }

    public function query(string $sql, string $className, bool $single = false)
    {
        $stmt = $this->pdo->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        if ($single) {
            return $stmt->fetch( );
        }
        return $stmt->fetchAll( );
    
    }


    public function transaction($callback) {
        try {
            $this->beginTransaction();
            $result = $callback($this);
            $this->commit();
            return $result;
        } catch (\Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    protected function beginTransaction() {
        // Début de la transaction
    }

    protected function commit() {
        // Validation de la transaction
    }

    protected function rollBack() {
        // Annulation de la transaction
    }

}
