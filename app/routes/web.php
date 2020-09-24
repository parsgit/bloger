<?php
use webrium\core\Route;
use webrium\core\Url;
use app\models\Post;

$arr   = Url::current_array();
$post  = Post::findByTitle(urldecode(end($arr)));

if ($post) {
  if ($post->category_id>0) {
    $query = "$post->category_name/$post->title_post";
  }
  else {
    $query = "$post->title_post";
  }

  $post_url =  url($query);
  $curent   = current_url();

  if ($post_url == $curent) {
    Post::setPost($post);
    Route::call('controllers@postController->page');
    die;
  }
}


Route::get('','controllers@indexController->index');
Route::get('file/image/content/*','controllers@fileController->downloadFile');
Route::get('profile/image/*','controllers@fileController->showProfileImage');

// change captcha
Route::post('captcha/new','controllers@userController->captcha');


Route::get('login','controllers@userController->loginPage');
Route::post('login','controllers@userController->loginUser');
