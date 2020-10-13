<?php
namespace app\models\admin;

use webrium\core\Hash;
use webrium\core\Session;
use webrium\mysql\DB;


use Rakit\Validation\Validator;

class User{

  private static $user = null;

  public static function setLogin($id){
    Session::set(['id'=>$id,'login'=>true]);
  }

  public static function getId(){
    return Session::get('id');
  }

  public static function isLogin(){
    return Session::get('login');
  }

  public static function get($force=false){

    if (self::$user==null || $force) {
      $id = self::getId();
      self::$user = DB::table('users')->where('id',$id)->first();
    }

    return self::$user;
  }

  public static function getById($id){
    return DB::table('users')->where('id',$id)->first();
  }

  public static function getAll(){
    $list = DB::table('users');
    return $list->get();
  }

  public static function remove($id){
    $countAdmin = DB::table('users')->where('type','administrator')->count();
    $user = DB::table('users')->where('id',$id)->first();

    if ($countAdmin == 1 && $user->type=='administrator') {
      return['ok'=>false,'message'=>'At least one admin is required and cannot be removed'];
    }

    DB::table('users')->where('id',$id)->delete();
    return ['ok'=>true];
  }

  public static function checkLogin()
  {
    $validator = new Validator;

    // make it
    $validation = $validator->make(input(), [
      'username'              => 'required|min:3',
      'password'              => 'required|min:6',
      'captcha'               => 'required',
    ]);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
      $errors = $validation->errors();
      return['ok'=>false,'message'=>self::makeError($errors->firstOfAll())];
    }

    $username = input('username');
    $password = input('password');
    $captcha  = input('captcha');

    if (strtolower($captcha)  != Session::get('captcha')) {
      return ['ok'=>false,'message'=>'Captcha entered is incorrect'];
    }

    $getUser = DB::table('users')->where('username',$username)->first();

    if ($getUser != false && Hash::check($password,$getUser->password)) {
      self::setLogin($getUser->id);
      return['ok'=>true];
    }

    return ['ok'=>false,'message'=>'Username or password is incorrect'];
  }

  /**
   * add new user
   */
  public static function add(){

    $validator = new Validator;

    // make it
    $validation = $validator->make(input(), [
      'type'                  => 'required',
      'name'                  => 'required|min:3',
      'username'              => 'required|min:3',
      'email'                 => 'required|email',
      'password'              => 'required|min:6',
      'confirm_password'      => 'required|same:password',

    ]);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
      $errors = $validation->errors();
      return['ok'=>false,'message'=>self::makeError($errors->firstOfAll())];
    }


    $name = input('name');
    $email = input('email');
    $username = input('username');
    $password = input('password');
    $type = input('type');

    $user = DB::table('users')->where('username',$username)->first();

    if ($user!=false) {
      return['ok'=>false,'message'=>'User already exists'];
    }

    DB::table('users')->insert([
      'name'=>$name,
      'email'=>$email,
      'username'=>$username,
      'password'=>Hash::make($password),
      'type'=>$type
    ]);

    return['ok'=>true];
  }

  /**
  * make error string
  * @param  array $errors $errors->firstOfAll()
  * @return string        error messages
  */
  public static function makeError($errors)
  {
    $msg='';
    foreach ($errors as $key => $error) {
      $msg .= "$error<br>";
    }

    return $msg;
  }

  /**
   * edit user
   * @return array
   */
  public static function profileEdit(){

    $name = input('name');
    $username = input('username');
    $email = input('email');
    $image = input('image');
    $type = input('type',false);
    $user_id = input('user_id');

    $user = DB::table('users')->where('id',$user_id)->first();

    if ($username != $user->username) {
      $user = DB::table('users')->where('username',$username)->first();

      if ($user!=false) {
        return['ok'=>false,'message'=>'Username already exists Please select another username'];
      }
    }

    $validator = new Validator;

    // make it
    $validation = $validator->make(input(), [
      'name'                  => 'required|min:3',
      'username'              => 'required|min:3',
      'email'                 => 'required|email',
    ]);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
      $errors = $validation->errors();
      return['ok'=>false,'message'=>self::makeError($errors->firstOfAll())];
    }

    if ($user_id != User::get()->id && !Admin::isAdmin()) {
      return['ok'=>false,'message'=>'You do not have permission to edit other users'];
    }

    $insertParams=[
      'username'=>$username,
      'name'=>$name,
      'email'=>$email,
      'image'=>$image
    ];

    if ($type!=false && Admin::isAdmin()) {
      $insertParams['type']=$type;
    }

    DB::table('users')->where('id',$user_id)->update($insertParams);

    return['ok'=>true];
  }

  public static function profileEditPassword()
  {
    $old_password = input('old_password');
    $password = input('password');
    $confirm_password = input('confirm_password');
    $user_id = input('user_id');


    $validator = new Validator;

    $role =  [
      'password'              => 'required|min:6',
      'confirm_password'      => 'required|same:password',
    ];

    if (!Admin::isAdmin()) {
      $role['old_password'] ='required|min:6';
    }

    // make it
    $validation = $validator->make(input(),$role);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
      $errors = $validation->errors();
      return['ok'=>false,'message'=>self::makeError($errors->firstOfAll())];
    }

    if (!Admin::isAdmin() && Hash::check($old_password,self::get()->password)==false) {
      return['ok'=>false,'message'=>'The old password is incorrect'];
    }

    $user = DB::table('users')->where('id',$user_id)->first();

    if ($user_id != User::get()->id && !Admin::isAdmin()) {
      return['ok'=>false,'message'=>'You do not have permission to edit other users'];
    }

    DB::table('users')->where('id',$user_id)->update([
      'password'=>Hash::make($password)
    ]);

    return['ok'=>true];
  }

  /**
  * change sesstion for the logout user
  * redirect user to the login page after logout
  */
  public static function logout(){
    Session::set(['login'=>false]);
    return redirect(url('login'));
  }


}
