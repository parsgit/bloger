<?php
namespace app\models;

use webrium\mysql\DB;
use Rakit\Validation\Validator;


class Post{

  public static function save(){

    $id          = input('id',false);
    $title       = input('title');
    $title_post  = str_replace(' ','-',$title);
    $content     = input('content');
    $description = input('description');
    $tags        = input('tags');
    $category_id = input('category');
    $swichers    = input('swichers');


    $validator = new Validator;
    // make it
    $validation = $validator->make(input(), [
      'title'              => 'required|max:60',
      'content'            => 'required',
      'description'        => 'required|max:320',
      'tags'               => 'required',
    ]);
    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
      $errors = $validation->errors();
      return['ok'=>false,'message'=>self::makeError($errors->firstOfAll())];
    }

    $params = [
      'title'        => $title,
      'title_post'   => $title_post,
      'content'      => $content,
      'description'  => $description,
      'publish'      => $swichers['publish'],
      'author_name'  => $swichers['author_name'],
      'allow_comment'=> $swichers['allow_comment'],
      'allow_like'   => $swichers['like'],
      'category_id'  => $category_id,
      'tags'         => $tags
    ];


    if ($id==false) {
      DB::table('posts')->insert($params);
      $id = DB::lastInsertId();
    }
    else {
      DB::table('posts')->where('id',$id)->update($params);
    }

    self::saveTags($id,$tags);

    return ['ok'=>true];
  }

  public static function getById($id){
    $post = DB::table('posts')->where('id',$id)->first();
    return $post;
  }


  public static function saveTags($post_id,$tags_string){
    DB::table('tags')->where('post_id',$post_id)->delete();
    $tags = explode(',',$tags_string);

    foreach ($tags as $key => $tag) {
      $tag_name = $tag;
      $tag = str_replace(' ','-',$tag);
      DB::table('tags')->insert(['post_id'=>$post_id,'tag'=>$tag,'tag_name'=>$tag_name]);
    }
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

}
