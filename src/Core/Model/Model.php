<?php
namespace Apps\Core\Model;

use Apps\Core\Database\MysqlDatabase;
use \PDO;

 abstract class Model{

    protected string $table;
    protected $database;

    public function __construct($database){
      $this->database = $database;
    }

    public function getDb() {
        return $this->database;
    }

    public function all(){
    
      return $this->database->query("select * from $this->table", $this->getEntity());
    }

    public function find(){

    }
    public function findByPhone($telephone){
      
    }
    public function query(string $sql,array $data, $class, bool $single = false) {
        if ($single) {
            return $this->database->prepare($sql, $data, $class, $single);
        } else {
            return $this->database->query($sql, $class, $single);
        }
    }

    public function setDatabase($database){
      $this->database = $database;
    }

    public abstract function getEntity();



    public static function update($id, $data) {
      // Logique pour mettre à jour une entité
  }

  public function hasMany($relatedModel) {
      // Logique pour relation hasMany
  }

  public function belongsTo($relatedModel) {
      // Logique pour relation belongsTo
  }

  public function hasOne($relatedModel) {
      // Logique pour relation hasOne
  }

  public function belongsToMany($relatedModel) {
      // Logique pour relation belongsToMany
  }

  public function transaction($callback) {
      return $this->database->transaction($callback);
  }
}
 

















 // abstract class Model{
//     protected $table;
//     protected $database;

//     public function __construct(MysqlDatabase $database) {
//         $this->database = $database;
//     }
   
//     public function all(){
//         return $this->database->query("SELECT * FROM $this->table",get_called_class());
//     }
//     public function find(){}
//     public function query(){}
//     public function save(){}
//     public function delete(){}
//     public static function update(){}
//     public static function setDatabase($database){}
// }