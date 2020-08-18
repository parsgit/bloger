<?php
use webrium\core\Route;

Route::get('admin','controllers@adminController->home');

Route::get('admin/category','controllers@categoryController->list');

Route::get('admin/upload','controllers@fileController->uploadPage');
Route::post('admin/upload','controllers@fileController->uploadFile');
Route::post('admin/file/list','controllers@fileController->getList');
Route::post('admin/file/remove','controllers@fileController->removeFile');
// Route::post('admin/file/edit','controllers@fileController->uploadFile');

Route::post('admin/category/add','controllers@categoryController->add');
Route::post('admin/category/remove','controllers@categoryController->remove');
Route::post('admin/category/edit','controllers@categoryController->edit');
