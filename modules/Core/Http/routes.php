<?php
Route::group([
    'middleware' => 'guest',
], function () {

    Route::get('/about', [
        'as'   => 'about',
        'uses' => 'AboutController@index',
    ]);

});
