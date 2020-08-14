<?php
namespace app\controllers;

use app\models\Panel;

class adminController
{

  public function home(){
    return Panel::view('test');
  }

}
