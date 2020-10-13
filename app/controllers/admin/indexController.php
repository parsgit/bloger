<?php
namespace app\controllers\admin;

use app\models\admin\Post;
use app\models\admin\Settings;

class indexController
{


  public function index()
  {
    $index = Settings::config('index');
    $posts = Post::getAll();

    return Post::view('index',['index'=>$index,'posts'=>$posts]);
  }

}
