<?php

Route::get('me', 'User\MeController@getMe');

Route::get('articles', 'Article\ArticleController@index');
Route::get('articles/{id}', 'Article\ArticleController@findArticle');

Route::get('users', 'User\UserController@index');
Route::get('user/{id}', 'User\UserController@findId');
Route::get('users/{id}/articles', 'Article\ArticleCOntroller@getForUser');

Route::group(['middleware' => ['auth:api']], function (){
    Route::post('logout', 'Auth\LoginController@logout');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    Route::post('article', 'Article\ArticleController@store');
    Route::put('article/{id}', 'Article\ArticleController@update');
    Route::get('articles/{id}/byUser', 'Article\ArticleController@userOwnsArticle');
    Route::delete('article/{id}', 'Article\ArticleController@destroy');

    Route::post('articles/{id}/like', 'Article\ArticleController@like');
    Route::get('articles/{id}/liked', 'Article\ArticleController@checkIfUserHasLiked');

    Route::post('users/{id}/follow', 'User\UserController@follow');
    Route::get('users/{id}/followed', 'User\UserController@checkIfUserHasFollowed');
});

Route::group(['middleware' => ['guest:api']], function (){
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
