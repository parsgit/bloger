<?php
namespace app\models;

use webrium\mysql\DB;

class Settings{

  public static function saveConfigs($configs){

    foreach ($configs as $key => $config) {
      $is = DB::table('configs')->where('name',$config['name'])->first();

      if ($is) {
        DB::table('configs')->where('id',$is->id)->update([
          'name'=>$config['name'],
          'value'=>$config['value']
        ]);
      }
      else{
        DB::table('configs')->insert([
          'name'=>$config['name'],
          'value'=>$config['value']
        ]);
      }
    }
  }

  public static function config($name=false,$value=false){
    if ($name==false && $value==false) {
      return self::configObject(DB::table('configs')->get());
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

}
