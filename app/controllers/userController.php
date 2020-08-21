<?php
namespace app\controllers;

use app\models\Panel;
use app\models\User;
use app\models\Categorys;

use webrium\core\Session;

use Gregwar\Captcha\CaptchaBuilder;

class userController
{

  public function users(){

    $users = User::getAll();
    return Panel::view('user-manage',[
      'title'=>'Users',
      'list'=>$users
    ]);
  }

  public function add()
  {
    $res = User::add();
    return $res;
  }

  public function remove()
  {
    $res = User::remove(input('id'));
    return $res;
  }

  function loginPage(){

    $cbuilder = new CaptchaBuilder;
    $cbuilder->build();
    $captcha = $cbuilder->getPhrase();
    Session::set(['captcha'=>strtolower($captcha)]);

    return Panel::content('login',['cbuilder'=>$cbuilder]);
  }


  function loginUser(){
    $res = User::checkLogin();

    return $res;
  }


  function logout(){
    Session::set(['login'=>false]);
    return redirect(url('login'));
  }

  function e404()
  {
    return Panel::view('404',[
      'title'=>'404'
    ]);
  }
}
