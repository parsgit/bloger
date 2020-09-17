<?php
namespace app\models;

use webrium\mysql\DB;

class Settings{

  public static function saveConfigs($configs){
    // echo json_encode($configs);
    // die;
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


        // echo json_encode($config['type']??'custom')."\n";

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
      return self::configObject(DB::table('configs')->where('name',$name)->get());
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

  public static function configObject($list){
    $std = new \stdClass;

    foreach ($list as $key => $config) {
      $name = $config->name;
      $std->$name = $config->value;
    }
    return $std;
  }

  public static function save(){

    // save configs value
    self::saveConfigs(input('configs',[]));
  }

  public static function removeConfig($name)
  {
    DB::table('configs')->where('name',$name)->delete();
  }

}
