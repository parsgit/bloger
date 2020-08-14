<?php
namespace app\models;

class Panel{

  public static function view($name,$params=[]){
    $params['_page']='admin/panel';
    $params['_content'] = "admin/$name";
    return view("layout/base",$params);
  }
}
