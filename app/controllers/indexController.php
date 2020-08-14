<?php
namespace app\controllers;

class indexController
{


  public function index()
  {
    return view('layout/base' , ['_page'=>'welcome','name'=>'ben'] );
  }

}
