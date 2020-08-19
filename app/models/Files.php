<?php
namespace app\models;

use webrium\core\Upload;
use webrium\core\File;
use webrium\core\Directory;
use webrium\mysql\DB;


class Files{

  public static function upload($limit_ext=false)
  {
    $storage_type = input('storage','public');
    $category = input('category','content');

    $file = new Upload('file');

    $info = $file->getInfo();

    $get = DB::table('files')->where('name',$info['file_name'])->where('location',$storage_type)->where('category',$category)->first();

    if ($get!=false) {
      $file->addError('exists','The file already exists');
      return['ok'=>false,'file'=>$file];
    }


    if ($limit_ext!=false) {
      $file->limit_ext($limit_ext);
    }


    if ($storage_type=='public') {
      $file->path(Directory::path('public')."/$category");
    }
    elseif ($storage_type=='storage') {
      $file->toStorage($category);
    }


    $file->save();

    if ($file->status()) {

      DB::table('files')->insert([
        'name'=>$file->getFileName(),
        'category'=>$category,
        'location'=>$storage_type,
        'type'=>$file->getType(),
        'ext'=>$file->getExt()
      ]);

      return['ok'=>true,'file'=>$file];
    }
    else {
      return['ok'=>false,'file'=>$file];
    }

  }

  public static function getList($category,$location)
  {
    return DB::table('files')->where('category',$category)->where('location',$location)->orderBy('id','desc')->get();
  }

  public static function remove($id)
  {
    $file = DB::table('files')->where('id',$id)->first();

    if ($file) {
      $path = self::getPath($file->location,$file->category,$file->name);

      if (File::exists($path)) {
        File::delete($path);
      }

      DB::table('files')->where('id',$id)->delete();
    }
  }

  public static function editName($id,$name)
  {
      $file = DB::table('files')->where('id',$id)->first();

      DB::table('files')->where('id',$id)->update([
        'name'=>$name
      ]);

      \rename(self::getPath($file->location,$file->category,$file->name),self::getPath($file->location,$file->category,$name));
  }

  public static function getPath($location,$category,$name)
  {
    if ($location=='public') {
      $path = Directory::path('public')."/$category/$name";
    }
    elseif ($location=='storage') {
      $path = Directory::path('storage_app')."/$category/$name";
    }
    return $path;
  }
}
