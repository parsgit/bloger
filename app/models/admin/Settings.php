<?php
namespace app\models\admin;

use webrium\mysql\DB;

class Settings{

  public static function saveConfigs($configs){

    $in = [];
    foreach ($configs as $key => $config) {
      $is = DB::table('configs')->where('name',$config['name'])->first();

      if ($is) {
        DB::table('configs')->where('id',$is->id)->update([
          'name'=>$config['name'],
          'value'=>$config['value']
        ]);
      }
      else{

        $params = [
          'name'=>$config['name'],
          'value'=>$config['value'],
          'type'=>$config['type']??'custom'
        ];

        DB::table('configs')->insert($params);
      }
    }
  }

  public static function config($name=false,$value=false){
    if ($name==false && $value==false) {
      return self::configObject(self::getAllConfigArray());
    }
    else if($name!=false && $value==false){
      $config =  DB::table('configs')->where('name',$name)->first();

      if ($config && $config->type='items') {
        return json_decode($config->value);
      }

      return $config;
    }
    else{
      DB::table('configs')->insert([
        'name'=>$name,
        'value'=>$value
      ]);

      return true;
    }
  }

  public static function getAllConfigArray()
  {
    return DB::table('configs')->get();
  }

  public static function save(){

    // save configs value
    self::saveConfigs(input('configs',[]));
  }

  public static function removeConfig($name)
  {
    DB::table('configs')->where('name',$name)->delete();
  }

  public static function saveItems()
  {
    self::saveConfigs([[
      'type'=>'items',
      'name'=>input('config_name'),
      'value'=>json_encode(input('params',[]))
    ]]);
  }

  public static function configObject($list){
    $std = new \stdClass;

    foreach ($list as $key => $config) {
      $name = $config->name;
      $std->$name = $config->value;
    }
    return $std;
  }

  public static function getConfigById($id)
  {
     $config = DB::table('configs')->where('id',$id)->first();

     if ( $config->type=='items') {
       $config->value = json_decode($config->value);
     }

     return $config;
  }

}
