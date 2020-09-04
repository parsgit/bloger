<?php
namespace app\controllers;

use app\models\Panel;
use app\models\User;
use app\models\Categorys;
use app\models\Admin;

use webrium\core\Session;

use Gregwar\Captcha\CaptchaBuilder;

class settingsController
{

  public function index()
  {
    return Panel::view('settings');
  }
}
