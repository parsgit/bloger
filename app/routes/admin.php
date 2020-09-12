<?php
use webrium\core\Route;
use app\models\Admin;
use app\models\User;
use app\models\Panel;


if (Admin::isAdminRoute()) {

  if (! User::isLogin()) {
    redirect(url('login'));
  }

  Route::get('admin','controllers@adminController->home');

  Route::get('admin/posts','controllers@postController->posts');

  Route::get('admin/post/add','controllers@postController->postManage');
  Route::post('admin/post/add','controllers@postController->postAdd');

  Route::get('admin/post/edit','controllers@postController->postEditPage');
  Route::post('admin/post/remove','controllers@postController->postRemove');



  Route::get('admin/user/profile','controllers@userController->profilePage');
  Route::post('admin/user/edit','controllers@userController->profileEdit');
  Route::post('admin/user/edit/password','controllers@userController->profileEditPassword');


  Route::get('admin/upload','controllers@fileController->uploadPage');
  Route::post('admin/upload','controllers@fileController->uploadFile');
  Route::post('admin/file/list','controllers@fileController->getList');
  Route::post('admin/file/remove','controllers@fileController->removeFile');
  Route::post('admin/file/edit','controllers@fileController->editFile');


  if (Admin::access(['administrator'])) {

    //===== CATEGORY =====

    // page
    Route::get('admin/category','controllers@categoryController->list');
    // add
    Route::post('admin/category/add','controllers@categoryController->add');
    //remove
    Route::post('admin/category/remove','controllers@categoryController->remove');
    // edit
    Route::post('admin/category/edit','controllers@categoryController->edit');


    //===== USERS =====

    // page
    Route::get('admin/users','controllers@userController->users');
    // add
    Route::post('admin/user/add','controllers@userController->add');
    // remove
    Route::post('admin/user/remove','controllers@userController->remove');


    //===== SETTINGS =====

    // setting page
    Route::get('admin/settings','controllers@settingsController->index');
    // save settings value
    Route::post('admin/settings/save','controllers@settingsController->save');

  }

  Route::get('admin/logout','controllers@userController->logout');

  Route::notFound('controllers@userController->e404');
}
