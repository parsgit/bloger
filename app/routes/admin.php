<?php
use webrium\core\Route;
use app\models\admin\Admin;
use app\models\admin\User;
use app\models\admin\Panel;


if (Admin::isAdminRoute()) {

  if (! User::isLogin()) {
    redirect(url('login'));
  }

  Route::get('admin','admin/adminController->home');
  Route::get('admin/posts','admin/postController->posts');

// die;
  Route::get('admin/post/add','admin/postController->postManage');
  Route::post('admin/post/add','admin/postController->postAdd');

  Route::get('admin/post/edit','admin/postController->postEditPage');
  Route::post('admin/post/remove','admin/postController->postRemove');



  Route::get('admin/user/profile','admin/userController->profilePage');
  Route::post('admin/user/edit','admin/userController->profileEdit');
  Route::post('admin/user/edit/password','admin/userController->profileEditPassword');


  Route::get('admin/upload','admin/fileController->uploadPage');
  Route::post('admin/upload','admin/fileController->uploadFile');
  Route::post('admin/file/list','admin/fileController->getList');
  Route::post('admin/file/remove','admin/fileController->removeFile');
  Route::post('admin/file/edit','admin/fileController->editFile');


  if (Admin::access(['administrator'])) {

    //===== CATEGORY =====

    // page
    Route::get('admin/category','admin/categoryController->list');
    // add
    Route::post('admin/category/add','admin/categoryController->add');
    //remove
    Route::post('admin/category/remove','admin/categoryController->remove');
    // edit
    Route::post('admin/category/edit','admin/categoryController->edit');


    //===== USERS =====

    // page
    Route::get('admin/users','admin/userController->users');
    // add
    Route::post('admin/user/add','admin/userController->add');
    // remove
    Route::post('admin/user/remove','admin/userController->remove');


    //===== SETTINGS =====

    // setting page
    Route::get('admin/settings','admin/settingsController->index');
    // save settings value
    Route::post('admin/settings/save','admin/settingsController->save');

    Route::post('admin/settings/config/remove','admin/settingsController->removeConfig');
    // index page
    Route::get('admin/settings/items-page','admin/settingsController->itemsPage');
    Route::post('admin/settings/items/save','admin/settingsController->saveItems');


  }

  Route::get('admin/logout','admin/userController->logout');

  Route::notFound('admin/userController->e404');
}
