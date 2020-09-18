<?php
use webrium\core\Route;
use app\models\Admin;
use app\models\User;
use app\models\Panel;


if (Admin::isAdminRoute()) {

  if (! User::isLogin()) {
    redirect(url('login'));
  }

  Route::get('admin','adminController->home');

  Route::get('admin/posts','postController->posts');

  Route::get('admin/post/add','postController->postManage');
  Route::post('admin/post/add','postController->postAdd');

  Route::get('admin/post/edit','postController->postEditPage');
  Route::post('admin/post/remove','postController->postRemove');



  Route::get('admin/user/profile','userController->profilePage');
  Route::post('admin/user/edit','userController->profileEdit');
  Route::post('admin/user/edit/password','userController->profileEditPassword');


  Route::get('admin/upload','fileController->uploadPage');
  Route::post('admin/upload','fileController->uploadFile');
  Route::post('admin/file/list','fileController->getList');
  Route::post('admin/file/remove','fileController->removeFile');
  Route::post('admin/file/edit','fileController->editFile');


  if (Admin::access(['administrator'])) {

    //===== CATEGORY =====

    // page
    Route::get('admin/category','categoryController->list');
    // add
    Route::post('admin/category/add','categoryController->add');
    //remove
    Route::post('admin/category/remove','categoryController->remove');
    // edit
    Route::post('admin/category/edit','categoryController->edit');


    //===== USERS =====

    // page
    Route::get('admin/users','userController->users');
    // add
    Route::post('admin/user/add','userController->add');
    // remove
    Route::post('admin/user/remove','userController->remove');


    //===== SETTINGS =====

    // setting page
    Route::get('admin/settings','settingsController->index');
    // save settings value
    Route::post('admin/settings/save','settingsController->save');

    Route::post('admin/settings/config/remove','settingsController->removeConfig');
    // index page
    Route::get('admin/settings/items-page','settingsController->itemsPage');
    Route::post('admin/settings/items/save','settingsController->saveItems');


  }

  Route::get('admin/logout','userController->logout');

  Route::notFound('userController->e404');
}
