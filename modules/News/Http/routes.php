<?php

Route::group([
    'middleware' => 'guest',
], function () {

    Route::get('/news', [
        'as'   => 'news',
        'uses' => 'NewsController@index',
    ]);

    Route::get('/get_news/{id}', [
        'uses' => 'NewsController@getNews',
    ]);


});
