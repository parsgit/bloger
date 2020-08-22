<?php
use webrium\core\Route;


Route::get('','controllers@indexController->index');
Route::get('file/image/content/*','controllers@fileController->downloadFile');
Route::get('profile/image/*','controllers@fileController->showProfileImage');


Route::get('login','controllers@userController->loginPage');
Route::post('login','controllers@userController->loginUser');
