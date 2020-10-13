<?php
namespace app\controllers\admin;

use app\models\admin\Panel;

class adminController
{

  public function home(){
    return Panel::view('test');
  }

}
