<?php
use webrium\core\Route;


Route::get('','controllers@indexController->index');
Route::get('file/image/content/*','controllers@fileController->downloadFile');
