<?php
namespace app\models;
use app\core\UserModel;
class User extends UserModel{
  public const STATUS_ACTIVE=1;
  public const STATUS_INACTIVE=0;
  public const STATUS_DELETED=2;

  public string $firstname='';
  public string $lastname='';
  public string $email='';
  public int $status =self::STATUS_ACTIVE;
  public string $password='';
  public string $confirmPassword='';

  public static function tableName():string{
    return "users";
  }

  public static function primaryKey():string{
    return "id";
  }

  public function getDisplayName():string{
    return $this->firstname.' '.$this->lastname;
  }
  public function save(){
    $this->password=password_hash($this->password,PASSWORD_DEFAULT);
    return parent::save();
  }

  public function rules():array{
    return [
      "firstname" => [self::RULE_REQUIRED],
      "lastname" => [self::RULE_REQUIRED],
      "email"   => [self::RULE_EMAIL,self::RULE_REQUIRED,[
        self::RULE_UNIQUE,
        'class' => self::class
        ]],
      "password" => [self::RULE_REQUIRED,[self::RULE_MIN, 'min' => 8],[self::RULE_MAX, 'max' => 24]],
      "confirmPassword" => [self::RULE_REQUIRED,[self::RULE_MATCH , 'match' => 'password']]
    ];
  }

  public function attribute():array{
    return ['firstname','lastname','email','password','status'];
  }
  public function labels():array{
    return[
      'firstname' => 'First name',
      'lastname' => 'Last name',
      'email' => 'Email',
      'password' => 'Password',
      'confirmPassword' => 'Password Confirm'
    ];
  }
}
 ?>
