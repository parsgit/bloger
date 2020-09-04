<?php
namespace app\models;

use webrium\mysql\DB;

class Categorys{

  public static function save($params){
    DB::table('categorys')->insert($params);
  }

  public static function getAll(){
    return DB::table('categorys')->where('active',true)->get();
  }

  public static function findById($id){
    return DB::table('categorys')->where('id',$id)->where('active',true)->firts();
  }

  public static function findByName($name){
    return DB::table('categorys')->where('name',$name)->where('active',true)->firts();
  }

  public static function update($id,$params){
    DB::table('categorys')->where('id',$id)->update($params);
  }

  public static function removeById($id){
    DB::table('categorys')->where('id',$id)->delete();
  }

}
