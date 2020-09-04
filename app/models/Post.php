<?php
namespace app\models;

use webrium\mysql\DB;

class Post{

  public static function save(){

    $id = input('id',false);

    $title = input('title');
    $title_post = str_replace(' ','-',$title);

    $content = input('content');
    $description = input('description');
    $tags = input('tags');

    $swichers = input('swichers');

    $params = [
      'title'=>$title,
      'title_post'=>$title_post,
      'content'=>$content,
      'description'=>$description,
      'publish'=>$swichers['publish'],
      'author_name'=>$swichers['author_name'],
      'allow_comment'=>$swichers['allow_comment'],
      'allow_like'=>$swichers['like'],
      'tags'=>$tags
    ];

    if ($id==false) {
      DB::table('posts')->insert($params);
    }
    else {
      DB::table('posts')->where('id',$id)->update($params);
    }


    return ['ok'=>true];
  }

  public static function getById($id){
    $post = DB::table('posts')->where('id',$id)->first();
    return $post;
  }



}
