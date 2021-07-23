<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
App::setLocale('ptbr');
Route::get('/', 'LandingController@index')->name('home');
Route::get('/login', 'LandingController@index')->name('login');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/jobs', 'LandingController@jobsList');

$router->group(['middleware' => ['auth']], function() {
    Route::get('/profile', 'LandingController@profile');
    Route::get('/subscriptions', 'LandingController@candidateSubscriptions');
    Route::post('/save-profile', 'LandingController@saveProfile');
    Route::post('/adm/banners-list', 'AdmController@bannersList');
});

$router->group(['middleware' => ['auth','is.admin','role:admin']], function() {
    Route::get('/home', 'HomeController@index')->name('home-adm');

    Route::post('/adm/save-banners', 'AdmController@saveBanners')->name('save-banners');
    Route::post('/adm/update-banner', 'AdmController@updateBanner')->name('update-banner');

    Route::get('/adm/config', 'AdmController@config')->name('config');
    Route::get('/adm/fields', 'AdmController@fieldsList')->name('fields-list');
    Route::get('/adm/units', 'AdmController@unitsList')->name('units-list');
    Route::get('/adm/jobs', 'AdmController@jobsList')->name('jobs-list');
    Route::get('/adm/tags', 'AdmController@tagsList')->name('tags-list');
    Route::get('/adm/candidates', 'AdmController@candidatesList')->name('candidates-list');

    Route::get('/adm/fields/create', 'AdmController@fieldsCreate')->name('fields-create');
    Route::get('/adm/units/create', 'AdmController@unitsCreate')->name('units-create');
    Route::get('/adm/jobs/create', 'AdmController@jobsCreate')->name('jobs-create');
    Route::get('/adm/tags/create', 'AdmController@tagsCreate')->name('tags-create');
    Route::get('/adm/candidates/create', 'AdmController@candidatesCreate')->name('candidates-create');

    Route::get('/adm/fields/edit/{id}', 'AdmController@fieldsEdit')->name('fields-edit');
    Route::get('/adm/units/edit/{id}', 'AdmController@unitsEdit')->name('units-edit');
    Route::get('/adm/jobs/edit/{id}', 'AdmController@jobsEdit')->name('jobs-edit');
    Route::get('/adm/tags/edit/{id}', 'AdmController@tagsEdit')->name('tags-edit');
    Route::get('/adm/candidates/edit/{id}', 'AdmController@candidatesEdit')->name('candidates-edit');

    Route::post('/adm/fields/destroy', 'AdmController@fieldsDestroy')->name('fields-destroy');
    Route::post('/adm/units/destroy', 'AdmController@unitsDestroy')->name('units-destroy');
    Route::post('/adm/jobs/destroy', 'AdmController@jobsDestroy')->name('jobs-destroy');
    Route::post('/adm/tags/destroy', 'AdmController@tagsDestroy')->name('tags-destroy');
    Route::post('/adm/candidates/destroy', 'AdmController@candidatesDestroy')->name('candidates-destroy');

    Route::get('/adm/fields/save', 'AdmController@fieldsSave')->name('fields-save');
    Route::get('/adm/units/save', 'AdmController@unitsSave')->name('units-save');
    Route::get('/adm/jobs/save', 'AdmController@jobsSave')->name('jobs-save');
    Route::get('/adm/tags/save', 'AdmController@tagsSave')->name('tags-save');
    Route::get('/adm/candidates/save', 'AdmController@candidatesSave')->name('candidates-save');
});