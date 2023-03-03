<?php

//the WordPress routes
use Cornatul\Wordpress\Http\Controllers\WordpressController;

Route::group(['middleware' => ['web','auth'],'prefix' => 'wordpress', 'as' => 'wordpress.'], static function ()
{
    Route::get('/', [WordpressController::class, 'index'])->name('index');
    Route::get('/create', [WordpressController::class, 'create'])->name('site.create');
    Route::post('/store', [WordpressController::class, 'store'])->name('site.store');
    Route::get('/delete/{id}', [WordpressController::class, 'delete'])->name('site.delete');
    Route::get('/delete/{id}', [WordpressController::class, 'delete'])->name('site.delete');
    Route::get('/publish/{articleID}', [WordpressController::class, 'publish'])->name('article.publish');

});
