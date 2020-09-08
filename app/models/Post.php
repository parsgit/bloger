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
    $post = DB::table('posts')->where('id',$id);
    self::checkRole($post);
    $post=$post->first();
    return $post;
  }

  public static function getAll($page=1){

    $posts = DB::table('posts')->select(['posts.*','categorys.name as category_name'])->orderBy('id','desc');

    self::join($posts);

    $ps=self::paginate($posts,10,$page);

    self::checkRole($posts);
    $posts = $posts->get();

    self::makeUrl($posts);

    $std = new \stdClass;
    $std->posts = $posts;
    $std->next  =  $ps['next'];
    $std->prev  =  $ps['prev'];

    if($std->next!==false)
    $std->next_page_url  = curent_url()."?page=$std->next";

    if($std->prev!==false)
    $std->prev_page_url  =  curent_url()."?page=$std->prev";


    return $std;
  }

  public static function paginate(&$data,$take,$page){

    if ($page<1) {
      return;
    }

    $next =clone $data;
    $previous =clone $data;

    $data->take($take)->skip($take*($page-1));

    $next = $next->take($take)->skip($take*$page)->first();
    if ($next) {
      $next = $page + 1;
    }

    $prev = false;

    if (($page-2) > -1) {
      $prev = $previous->take($take)->skip($take*($page-2))->get();
    }

    if ($prev) {
      $prev = $page - 1;
    }

    return ['next'=>$next,'prev'=>$prev];
  }

  public static function join(&$item)
  {
    $item->leftJoin('categorys', 'categorys.id=posts.category_id');
  }

  public static function makeUrl(&$posts)
  {

    $url = url();

    foreach ($posts as $key => $post) {

      $tags = DB::table('tags')->select(['tag','tag_name'])->where('post_id',$post->id)->get();

      $post->tagsUrl=$tags;

      if ($post->category_id==0) {
        $post->query = "$post->title_post";
      }
      else {
        $post->query = "$post->category_name/$post->title_post";
      }

      $post->url = "$url$post->query";
    }
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

  public static function remove($id)
  {
    $post = DB::table('posts')->where('id',$id);

    self::checkRole($post);

    $post->delete();

    return true;
  }

  public static function checkRole(&$list)
  {
    if (Admin::isAuyhor()) {
      $list->where('user_id',User::getId());
    }
  }

}
