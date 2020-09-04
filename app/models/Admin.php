<?php
namespace app\models;

use webrium\core\Session;
use webrium\core\Url;
use app\models\User;

class Admin{

  public static function isAdmin(){
    return self::is('administrator');
  }

  public static function isAuyhor(){
    return self::is('author');
  }

  public static function isEditro(){
    return self::is('editro');
  }

  public static function is($type){
    $user = User::get();

    if (User::isLogin() && $user!=false && $user->type==$type) {
      return true;
    }

    return false;
  }

  public static function isAdminRoute(){
    if (Url::is('admin') || Url::is('admin/') || Url::is('admin/*')) {
      return true;
    }
    return false;
  }

  public static function access($role){
    $user = User::get();

    if (in_array($user->type,$role)) {
      return true;
    }

    return false;
  }

  public static function allowPasswordEditingWithoutOldPassword($myuser){
    if(! self::isAdmin() || (self::isAdmin() && $myuser->type == 'administrator') ){
      return true;
    }
    return false;
  }


}
