<?php
namespace app\controllers\admin;

use app\models\admin\Panel;
use app\models\admin\User;
use app\models\admin\Categorys;
use app\models\admin\Admin;

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

  public function getNewCaptcha()
  {
    $cbuilder = new CaptchaBuilder;
    $cbuilder->build();
    $captcha = $cbuilder->getPhrase();
    Session::set(['captcha'=>strtolower($captcha)]);
    return $cbuilder->inline();
  }

  public function captcha()
  {
    return ['ok'=>true,'captcha'=>$this->getNewCaptcha()];
  }

  /**
   * Show the login page to the clients
   * @return view
   */
  function loginPage(){
    return Panel::content('login',['captcha'=>$this->getNewCaptcha()]);
  }

  /**
   * Show profile page
   * @return view
   */
  function profilePage(){

    $edit_user_id = input('user_id',false);

    if (Admin::isAdmin() && $edit_user_id!=false) {
      $myuser = User::getById($edit_user_id);
    }
    else {
      $myuser = User::get();
    }

    return Panel::view('profile-manage',
    [
      'myuser'=>$myuser,
      'isAdmin'=>Admin::isAdmin(),
    ]);
  }

  /**
   * login user
   * @return array
   */
  function loginUser(){
    $res = User::checkLogin();

    if (! $res['ok']) {
      $res['captcha']= $this->getNewCaptcha();
    }

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
