<?php
namespace app\controllers;

use app\models\Panel;

class categoryController
{

  public function list(){
    return Panel::view('category-list');
  }

}
