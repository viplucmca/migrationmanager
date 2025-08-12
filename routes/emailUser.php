<?php
Route::prefix('email_users')->group(function() {
    //Email manager
    Route::get('/', 'Auth\AdminEmailController@showLoginForm')->name('email_users.login');
    Route::get('/login', 'Auth\AdminEmailController@showLoginForm')->name('email_users.login');
    Route::post('/login', 'Auth\AdminEmailController@login')->name('email_users.login');
    Route::post('/logout', 'Auth\AdminEmailController@logout')->name('email_users.logout');
    Route::get('/dashboard', 'EmailUser\DashboardController@dashboard')->name('email_users.dashboard');


    Route::get('/loadinbox/{email_user_id}', 'EmailUser\EmailListController@loadinbox')->name('email_users.loadinbox');
    Route::get('/loadsent/{email_user_id}', 'EmailUser\EmailListController@loadsent')->name('email_users.loadsent');
    Route::get('/inbox/{email_user_id}', 'EmailUser\EmailListController@inbox')->name('email_users.inbox');
    Route::get('/sent/{email_user_id}', 'EmailUser\EmailListController@sent')->name('email_users.sent');
    Route::post('/assiginboxemail', 'EmailUser\EmailListController@assiginboxemail')->name('email_users.assiginboxemail');
    Route::post('/assigsentemail', 'EmailUser\EmailListController@assigsentemail')->name('email_users.assigsentemail');

    //Fetch selected client all matters at assign email to user popup
    Route::post('/listAllMattersWRTSelClient', 'EmailUser\EmailListController@listAllMattersWRTSelClient')->name('email_users.listAllMattersWRTSelClient');

});
?>
