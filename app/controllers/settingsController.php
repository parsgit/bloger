<?php
namespace app\controllers;

use app\models\Panel;
use app\models\User;
use app\models\Categorys;
use app\models\Admin;
use app\models\Settings;

use webrium\core\Session;

use Gregwar\Captcha\CaptchaBuilder;

class settingsController
{

  public function index()
  {
    $config = Settings::config();
    return Panel::view('settings',['config'=>$config]);
  }

  public function save(){
    Settings::save();
    return['ok'=>true];
  }
}
