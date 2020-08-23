<?php
namespace app\controllers;

use app\models\Panel;
use app\models\Categorys;
use app\models\Files;
use webrium\core\File;
use webrium\core\Url;
use webrium\core\Directory;

class fileController
{

  function uploadPage(){

    $categorys = Categorys::getAll();

    return Panel::view('upload',['categorys'=>$categorys]);
  }

  function uploadFile(){

    $res = Files::upload(['pdf','png','jpg','mp4','mp3','ico','wmv','zip','rar','tar']);

    $errors = $res['file']->getErrors();

    $params = ['ok'=>$res['ok'],'errors'=>$errors];

    if ($res['ok']) {
      $params['name']=$res['name'];
    }


    return $params;
  }

  function getList()
  {
    $category = input('category','public');
    $storage = input('storage','public');

    $list = Files::getList($category,$storage);

    return['ok'=>true,'list'=>$list];
  }

  public function downloadFile()
  {
    $url = curent_url();
    $pos = strpos($url,'content');
    $name = substr($url,$pos+8);

    $name = urldecode($name);

    return  File::download(Directory::path('storage_app')."/content/$name");
  }

  public function showProfileImage()
  {
    $url = curent_url();
    $pos = strpos($url,'image');
    $name = substr($url,$pos+6);

    $path = Directory::path('storage_app')."/profile/image/$name";
    // return json_encode(File::exists($path));

    return File::showImage($path);
  }

  public function removeFile()
  {
    Files::remove(input('id'));
    return['ok'=>true];
  }

  public function editFile()
  {
    Files::editName(input('id'),input('name'));
    return['ok'=>true];
  }

}
