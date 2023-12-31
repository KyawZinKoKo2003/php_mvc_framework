<?php
namespace app\core\db;
use app\core\Model;
use app\core\Application;
abstract class DbModel extends Model{
 abstract public static function tableName(): string;
 abstract public static function primaryKey():string;
  public function save(){
    $tableName = $this->tableName();
    $attributes = $this->attribute();
    $params=array_map(fn($attr) => ":$attr",$attributes);
    $statement=self::prepare("INSERT INTO $tableName(".implode(',',$attributes).") VALUES(".implode(',',$params).")");
    foreach($attributes as $attribute){
      $statement->bindValue(":$attribute",$this->{$attribute});
    }
    $statement->execute();
    return true;
}

  public static function findOne($where){
    $tableName=static::tableName();
    $attribute=array_keys($where);

    $sql=implode(" AND ",array_map(fn($attr)=>"$attr=:$attr",$attribute));
    $statement=self::prepare("SELECT * FROM $tableName WHERE $sql ");

    foreach($where as $key=>$item){
      $statement->bindValue(":$key",$item);

    };
    $statement->execute();
    return $statement->fetchObject(static::class);
  }
  public static function prepare($sql){
  return Application::$app->database->pdo->prepare($sql);
  }
}

 ?>
