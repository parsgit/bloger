<?php
namespace app\controllers;

use app\models\Panel;
use app\models\Categorys;

class postController
{

  public function postAdd(){

    $categorys = Categorys::getAll();

    return Panel::view('post-add',[
      'categorys'=>$categorys,
      'title'=>'Add Post'
    ]);
  }



}
