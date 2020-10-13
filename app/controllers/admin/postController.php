<?php
namespace app\controllers\admin;

use app\models\admin\Panel;
use app\models\admin\Post;
use app\models\admin\Categorys;

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

    return Panel::view('post-list',[
      'title'=>'Post List',
      'info'=>$info
    ]);
  }

  public function postRemove()
  {
    $id = input('id');
    Post::remove($id);
    return['ok'=>true];
  }

  public function page()
  {
    return Post::view('post');
  }

}
