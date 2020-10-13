<?php
use webrium\core\Route;
use webrium\core\Url;

use app\models\admin\Post;

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
    Route::call('admin/postController->page');
    die;
  }
}


Route::get('','admin/indexController->index');
Route::get('file/image/content/*','admin/fileController->downloadFile');
Route::get('profile/image/*','admin/fileController->showProfileImage');

// change captcha
Route::post('captcha/new','admin/userController->captcha');


Route::get('login','admin/userController->loginPage');
Route::post('login','admin/userController->loginUser');
