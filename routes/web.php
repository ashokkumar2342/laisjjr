<?php

// Route::get('/', function () {
//     return redirect()->route('admin.login');
 
// });
Route::get('/', function () {
    return redirect()->route('template.index');
 	// return view('admin.auth.login');
});

Route::get('index', 'Admin\TemplateController@index')->name('template.index');
Route::get('search', 'Admin\TemplateController@search')->name('template.search');
Route::post('search-result', 'Admin\TemplateController@searchResult')->name('template.search.result');






