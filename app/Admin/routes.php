<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    //题库管理
    $router->resource('TiKu/EmsQuestype', 'TiKu\EmsQuestypeController');
    $router->resource('TiKu/EmsDeclaration', 'TiKu\EmsDeclarationController');
    $router->resource('TiKu/EmsMajor', 'TiKu\EmsMajorController');
    $router->resource('TiKu/EmsQuestion', 'TiKu\EmsQuestionController');
    $router->resource('TiKu/EmsFile', 'TiKu\EmsFileController');
    //考试管理
    $router->resource('KaoShi/EmsBasic', 'KaoShi\EmsBasicController');
    $router->resource('KaoShi/EmsSubject', 'KaoShi\EmsSubjectController');
    $router->resource('KaoShi/EmsExam', 'KaoShi\EmsExamController');
    $router->resource('KaoShi/AdminUser', 'KaoShi\AdminUserController');
    $router->resource('KaoShi/EmsCategory', 'KaoShi\EmsCategoryController');

    //考生考试
    $router->resource('KaoShi/EmsExamsession', 'KaoShi\EmsExamsessionController');
    $router->resource('KaoShi/EmsExamhistory', 'KaoShi\EmsExamhistoryController');

    $router->get('KaoSheng/examFun', 'KaoSheng\EmsKaoShiSubmit@examFun');
    $router->resource('KaoSheng/EmsBasic', 'KaoSheng\EmsBasicController');
    $router->resource('KaoSheng/EmsHistory', 'KaoSheng\EmsHistoryController');
    $router->resource('KaoSheng/EmsKaoShi/{id}', 'KaoSheng\EmsKaoShiByUser');

    //API
    Route::get('/api/questype', 'TikuController@questype');
    Route::get('/api/declaration', 'TikuController@declaration');
    Route::get('/api/major', 'TikuController@major');
    Route::get('/api/questype1', 'TikuController@questype1');
    Route::get('/api/declaration1', 'TikuController@declaration1');
    Route::get('/api/major1', 'TikuController@major1');
});
