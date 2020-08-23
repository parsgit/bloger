<?php
namespace app\controllers;

use app\models\Panel;
use app\models\User;
use app\models\Categorys;

use webrium\core\Session;

use Gregwar\Captcha\CaptchaBuilder;

class userController
{

  /**
   * show users list and add new user
   * @return view
   */
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

  /**
   * delete a user
   * @return array
   */
  public function remove()
  {
    $res = User::remove(input('id'));
    return $res;
  }

  /**
   * Show the login page to the clients
   * @return view
   */
  function loginPage(){

    $cbuilder = new CaptchaBuilder;
    $cbuilder->build();
    $captcha = $cbuilder->getPhrase();
    Session::set(['captcha'=>strtolower($captcha)]);

    return Panel::content('login',['cbuilder'=>$cbuilder]);
  }

  /**
   * Show profile page
   * @return view
   */
  function profilePage(){
    return Panel::view('profile-manage');
  }

  /**
   * login user
   * @return array
   */
  function loginUser(){
    $res = User::checkLogin();
    return $res;
  }

  /**
   * logout admin
   */
  function logout(){
    return User::logout();
  }

  function profileEdit(){
    return User::profileEdit();
  }

  function profileEditPassword(){
    return User::profileEditPassword();
  }

  /**
   * paned page not found view
   * @return view
   */
  function e404()
  {
    return Panel::view('404',[
      'title'=>'404'
    ]);
  }
}
