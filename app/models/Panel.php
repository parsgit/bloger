<?php
namespace app\models;

use app\models\Admin;
use app\models\User;

class Panel{

  public static function getMenus(){

    $menus=[];

    if (Admin::access(['administrator','author','editor'])){
      $menus[]=['name'=>'Posts','link'=>url('admin/posts'),'icon'=>'fas fa-file-alt','order'=>1];
      $menus[]=['name'=>'Files','link'=>url('admin/upload'),'icon'=>'fas fas fa-file','order'=>2];
    }

    if (Admin::access(['administrator'])){
      $menus[]=['name'=>'Categorys','link'=>url('admin/category'),'icon'=>'fas fa-stream','order'=>3];
      $menus[]=['name'=>'Users','link'=>url('admin/users'),'icon'=>'fas fas fa-user','order'=>4];
      $menus[]=['name'=>'Settings','link'=>url('admin/settings'),'icon'=>'fas fas fa-cogs','order'=>5];
    }

    $menus[]=['name'=>'Logout','link'=>url('admin/logout'),'icon'=>'fas fas fa-door-closed','order'=>6];

    usort($menus, function($a, $b)
    {
      return strcmp($a['order'], $b['order']);
    });

    return $menus;
  }

  public static function view($name,$params=[]){
    $params['_page']='admin/panel';
    $params['_content'] = "admin/$name";
    $params['_menus']= self::getMenus();
    $params['user']= User::get();

    return view("layout/base",$params);
  }

  public static function content($name,$params=[]){
    $params['_page']="admin/$name";
    return view("layout/base",$params);
  }


}
