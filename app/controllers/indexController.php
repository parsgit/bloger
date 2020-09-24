<?php
namespace app\controllers;

use app\models\Post;
use app\models\Settings;

class indexController
{


  public function index()
  {
    $index = Settings::config('index');
    return Post::view('index',['index'=>$index]);
  }

}
