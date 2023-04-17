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
if (isset($_COOKIE['lang'])){
    //print_R($_COOKIE);die;
    App::setLocale($_COOKIE['lang']);
}
Route::get('/', function (){
    return redirect('/login');
})->name('home');
Route::get('/portal', function () {
    return redirect()->away('https://www.lunelli.com.br');
});
//Route::get('/login', 'LandingController@index')->name('login');
Route::get('/login', 'LandingController@access')->name('login');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/jobs', 'LandingController@jobsList');
Route::get('/policy', 'LandingController@policy');
Route::post('/newsletter-subscribe', 'LandingController@newsletterSubscribe');
Route::get('/landing-data', 'LandingController@landingData');
Route::get('/view-mail/{id}', 'AdmController@viewMail')->name('view-mail');
Route::post('/busca-cep', 'LandingController@buscaCep')->name('busca-cep');
Route::get('/help', 'LandingController@help')->name('help');
Route::post('/send-help', 'LandingController@sendHelp')->name('send-help');
Route::get('/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password-forgot');

Route::get('/changeloc/{lang}', function ($lang) {
    setcookie("lang",$lang,0,'/');
    return redirect()->back();
});
Route::get('/resetlang', function () {
    Cookie::queue(Cookie::forget('lang'));
    return redirect()->back();
});

$router->group(['middleware' => ['auth']], function() {
    Route::get('/profile', 'LandingController@profile');
    Route::get('/subscriptions', 'LandingController@candidateSubscriptions');
    Route::get('/change-talent-bank/{id}', 'LandingController@changeTalentBank');
    Route::post('/apply-for-job', 'LandingController@applyForJob');
    Route::post('/cancel-application', 'LandingController@cancelApplication');
    Route::post('/save-profile', 'LandingController@saveProfile');
    Route::post('/adm/banners-list', 'AdmController@bannersList');
    Route::post('/adm/add-subscription-state', 'AdmController@addSubscriptionState');
    Route::post('/adm/update-subscription-note', 'AdmController@updateSubscriptionNote');
});

$router->group(['middleware' => ['auth','is.admin','can:access admin']], function() {
    Route::get('/home', 'HomeController@index')->name('home-adm');
    Route::get('/all-units', 'AdmController@getUnits')->name('all-units');
    Route::get('/all-fields', 'AdmController@getFields')->name('all-fields');

    Route::group(['middleware' => ['can:config']], function() {
        Route::get('/adm/config', 'AdmController@config')->name('config');
        Route::post('/adm/save-banners', 'AdmController@saveBanners')->name('save-banners');
        Route::post('/adm/update-banner', 'AdmController@updateBanner')->name('update-banner');
        Route::post('/adm/delete-banner', 'AdmController@deleteBanner')->name('delete-banner');
        Route::post('/adm/config-data', 'AdmController@configData')->name('config-data');
        Route::post('/adm/save-other-conf', 'AdmController@saveOtherConf')->name('save-other-conf');

        Route::get('/adm/help-contacts', 'AdmController@helpContactsList')->name('help-contacts');
        Route::post('/adm/help-contacts/create', 'AdmController@helpContactsCreate')->name('help-contacts-create');
        Route::post('/adm/help-contacts/toggle', 'AdmController@helpContactsToggle')->name('help-contacts-toggle');
        Route::post('/adm/help-contacts/destroy', 'AdmController@helpContactsDestroy')->name('help-contacts-destroy');
    });
    
    Route::post('/adm/add-tag', 'AdmController@addTag')->name('add-tag');

    Route::group(['middleware' => ['can:fields']], function() {
        Route::get('/adm/fields', 'AdmController@fieldsList')->name('fields-list');
        Route::get('/adm/fields/save', 'AdmController@fieldsSave')->name('fields-save');
        Route::get('/adm/fields/create', 'AdmController@fieldsCreate')->name('fields-create');
        Route::get('/adm/fields/edit/{id}', 'AdmController@fieldsEdit')->name('fields-edit');
        Route::post('/adm/fields/destroy', 'AdmController@fieldsDestroy')->name('fields-destroy');
    });

    Route::group(['middleware' => ['can:recruiting status']], function() {
        
        Route::get('/adm/summary', 'AdmController@summary')->name('summary');
        Route::get('/adm/states', 'AdmController@statesList')->name('states-list');
        Route::get('/adm/states/edit/{id}', 'AdmController@statesEdit')->name('states-edit');
        Route::get('/adm/states/create', 'AdmController@statesCreate')->name('states-create');
        Route::post('/adm/states/destroy', 'AdmController@statesDestroy')->name('states-destroy');
        Route::get('/adm/states/save', 'AdmController@statesSave')->name('states-save');

        Route::get('/adm/states-mails', 'AdmController@statesMailsList')->name('states-list');
        Route::get('/adm/states-mails/edit/{id}', 'AdmController@statesMailsEdit')->name('states-mails-edit');
        Route::get('/adm/states-mails/create', 'AdmController@statesMailsCreate')->name('states-mails-create');
        Route::post('/adm/states-mails/destroy', 'AdmController@statesMailsDestroy')->name('states-mails-destroy');
        Route::post('/adm/states-mails/save', 'AdmController@statesMailsSave')->name('states-mails-save');

    });

    Route::group(['middleware' => ['can:units']], function() {
        Route::get('/adm/units', 'AdmController@unitsList')->name('units-list');
        Route::get('/adm/units/create', 'AdmController@unitsCreate')->name('units-create');
        Route::get('/adm/units/edit/{id}', 'AdmController@unitsEdit')->name('units-edit');
        Route::post('/adm/units/destroy', 'AdmController@unitsDestroy')->name('units-destroy');
        Route::get('/adm/units/save', 'AdmController@unitsSave')->name('units-save');
    });

    Route::group(['middleware' => ['can:jobs']], function() {
        Route::get('/adm/jobs', 'AdmController@jobsList')->name('jobs-list');
        Route::get('/adm/jobs/create', 'AdmController@jobsCreate')->name('jobs-create');
        Route::get('/adm/jobs/edit/{id}', 'AdmController@jobsEdit')->name('jobs-edit');
        Route::post('/adm/jobs/destroy', 'AdmController@jobsDestroy')->name('jobs-destroy');
        Route::get('/adm/jobs/save', 'AdmController@jobsSave')->name('jobs-save');
        Route::post('/adm/jobs/save', 'AdmController@jobsSave')->name('jobs-save');
    });

    Route::group(['middleware' => ['can:jobs templates']], function() {
        Route::get('/adm/jobs-templates/save', 'AdmController@jobsTemplatesSave')->name('jobs-templates-save');
        Route::post('/adm/jobs-templates/save', 'AdmController@jobsTemplatesSave')->name('jobs-templates-save');
        Route::get('/adm/jobs-templates', 'AdmController@jobsTemplatesList')->name('jobs-templates-list');
        Route::get('/adm/jobs-templates/create', 'AdmController@jobsTemplatesCreate')->name('jobs-templates-create');
        Route::get('/adm/jobs-templates/edit/{id}', 'AdmController@jobsTemplatesEdit')->name('jobs-templates-edit');
        Route::post('/adm/jobs-templates/destroy', 'AdmController@jobsTemplatesDestroy')->name('jobs-templates-destroy');
    });

    Route::group(['middleware' => ['can:newsletter']], function() {
        Route::get('/adm/subscribers', 'AdmController@subscribersList')->name('subscribers-list');
        Route::post('/adm/subscribers/destroy', 'AdmController@subscribersDestroy')->name('subscribers-destroy');
    });
    
    Route::group(['middleware' => ['can:tags']], function() {
        Route::get('/adm/tags', 'AdmController@tagsList')->name('tags-list');
        Route::get('/adm/tags/create', 'AdmController@tagsCreate')->name('tags-create');
        Route::get('/adm/tags/edit/{id}', 'AdmController@tagsEdit')->name('tags-edit');
        Route::post('/adm/tags/destroy', 'AdmController@tagsDestroy')->name('tags-destroy');
        Route::get('/adm/tags/save', 'AdmController@tagsSave')->name('tags-save');
    });

    Route::group(['middleware' => ['can:tags']], function() {
        Route::get('/adm/tagsrh', 'AdmController@tagsrhList')->name('tagsrh-list');
        Route::get('/adm/tagsrh/create', 'AdmController@tagsrhCreate')->name('tagsrh-create');
        Route::get('/adm/tagsrh/edit/{id}', 'AdmController@tagsrhEdit')->name('tagsrh-edit');
        Route::post('/adm/tagsrh/destroy', 'AdmController@tagsrhDestroy')->name('tagsrh-destroy');
        Route::get('/adm/tagsrh/save', 'AdmController@tagsrhSave')->name('tagsrh-save');
        Route::get('/adm/candidates/available-tagsrh', 'AdmController@getAvailableTagsrh')->name('candidates-available-tagsrh');
    });


    Route::group(['middleware' => ['can:candidates']], function() {
        Route::get('/adm/candidates', 'AdmController@candidatesList')->name('candidates-list');
        Route::get('/adm/candidates/available-jobs', 'AdmController@getAvailableJobs')->name('candidates-available-jobs');
        Route::get('/adm/candidates/create', 'AdmController@candidatesCreate')->name('candidates-create');
        Route::get('/adm/candidates/edit/{id}', 'AdmController@candidatesEdit')->name('candidates-edit');
        Route::post('/adm/candidates/destroy', 'AdmController@candidatesDestroy')->name('candidates-destroy');
        Route::post('/adm/candidates/subscribe-candidates-to-job', 'AdmController@subscribeCandidatesToJob')->name('subscribe-candidates-to-job');
        Route::post('/adm/candidates/export-candidates', 'AdmController@exportCandidates')->name('export-candidates');
        Route::get('/adm/candidates/save', 'AdmController@candidatesSave')->name('candidates-save');
        Route::get('/adm/candidates/print/{id}', 'AdmController@candidatePrint')->name('candidates-print');
        Route::get('/adm/candidates/view/{id}', 'AdmController@candidateView')->name('candidates-view');
        Route::post('/adm/candidates/subscribe-tagrh', 'AdmController@candidateSetTagRh')->name('candidates-subscribe-tagrh');
        Route::get('/adm/candidates/load-data/{id}', 'AdmController@loadCandidateData')->name('candidate-load-data');
        Route::get('/adm/candidates/load-tagsrh/{id}', 'AdmController@loadCandidateTagsrh')->name('candidates-load-tagsrh');
    });

    Route::group(['middleware' => ['can:users']], function() {
        Route::get('/adm/users', 'AdmController@usersList')->name('users-list');
        Route::get('/adm/users/create', 'AdmController@usersCreate')->name('users-create');
        Route::get('/adm/users/edit/{id}', 'AdmController@usersEdit')->name('users-edit');
        Route::post('/adm/users/destroy', 'AdmController@usersDestroy')->name('users-destroy');
        Route::get('/adm/users/save', 'AdmController@usersSave')->name('users-save');
        Route::post('/adm/users/reset-pass', 'AdmController@resetPass')->name('reset-pass');
    });

    Route::group(['middleware' => ['can:users']], function() {
        Route::get('/adm/roles/create', 'AdmController@rolesCreate')->name('roles-create');
        Route::get('/adm/roles/edit/{id}', 'AdmController@rolesEdit')->name('roles-edit');
        Route::post('/adm/roles/destroy', 'AdmController@rolesDestroy')->name('roles-destroy');
        Route::get('/adm/roles/save', 'AdmController@rolesSave')->name('roles-save');
        Route::get('/adm/roles', 'AdmController@rolesList')->name('roles-list');
    });
    
    Route::group(['middleware' => ['can:recruiting']], function() {
        Route::get('/adm/recruiting', 'AdmController@recruiting')->name('recruiting');
        Route::post('/adm/recruiting-data', 'AdmController@recruitingData')->name('recruiting-data');
    });
});