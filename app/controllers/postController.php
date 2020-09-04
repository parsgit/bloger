<?php
namespace app\controllers;

use app\models\Panel;
use app\models\Post;
use app\models\Categorys;

class postController
{

  public function postManage($id=false){

    $post = false;

    if ($id!=false) {
      $post = Post::getById($id);
    }

    $categorys = Categorys::getAll();

    return Panel::view('post-manage',[
      'categorys'=>$categorys,
      'title'=>($post?'Edit':'New' ).' Post',
      'post'=>$post
    ]);
  }

  public function postEditPage(){
    return $this->postManage(input('id'));
  }

  //
  public function postAdd(){

    return Post::save();
  }

  public function posts(){

    $info = Post::getAll(input('page',1));

    // return $info;

    return Panel::view('post-list',[
      'title'=>'Post List',
      'info'=>$info
    ]);
  }


}
