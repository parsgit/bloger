<?php
use webrium\core\Route;

Route::get('admin','controllers@adminController->home');

Route::get('admin/category','controllers@categoryController->list');

Route::post('admin/category/add','controllers@categoryController->add');
Route::post('admin/category/remove','controllers@categoryController->remove');
Route::post('admin/category/edit','controllers@categoryController->edit');
