<?php
use webrium\core\Route;

Route::get('admin','controllers@adminController->home');

Route::get('admin/category','controllers@categoryController->list');
