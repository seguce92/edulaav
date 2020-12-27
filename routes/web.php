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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::group(['prefix' => 'api', 'middleware' => ['auth', 'verified']], function () {

    Route::group(['namespace' => 'Api\Media', 'prefix' => 'media'], function () {
        Route::group(['prefix' => 'filemanager'], function () {
            Route::get('/', 'FilemanagerController@index')->name('filemanager.index');
            Route::post('/', 'FilemanagerController@createDirectory')->name('filemanager.make');
            Route::post('/delete', 'FilemanagerController@removeDirectory')->name('filemanager.delete');
            Route::post('submit', 'FilemanagerController@storeFile')->name('submit');
        });
    });

    Route::group(['namespace' => 'Api\Core', 'prefix' => 'core'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::get('/{user}', 'UserController@show');
            Route::post('/', 'UserController@store');
            Route::match(['put', 'patch'], '/{user}', 'UserController@update');
            Route::post('/status/{user}', 'UserController@destroy');
        });

        Route::group(['prefix' => 'teachers'], function () {
            Route::get('/', 'TeacherController@index');
            Route::get('/{teacher}', 'TeacherController@show');
            Route::post('/', 'TeacherController@store');
            Route::match(['put', 'patch'], '/{teacher}', 'TeacherController@update');
            Route::post('/status/{user}', 'TeacherController@destroy');
        });

        Route::group(['prefix' => 'students'], function () {
            Route::get('/', 'StudentController@index');
            Route::get('/{studen}', 'StudentController@show');
            Route::post('/', 'StudentController@store');
            Route::match(['put', 'patch'], '/{student}', 'StudentController@update');
            Route::post('/status/{user}', 'StudentController@destroy');
        });
    });

    Route::group(['namespace' => 'Api\Academic', 'prefix' => 'academic'], function () {
        Route::group(['prefix' => 'grades'], function () {
            Route::get('/', 'GradeController@index');
            Route::get('/{grade}', 'GradeController@show');
            Route::post('/', 'GradeController@store');
            Route::match(['put', 'patch'], '/{grade}', 'GradeController@update');
            Route::delete('/{grade}', 'GradeController@destroy');
        });
        Route::group(['prefix' => 'parallels'], function () {
            Route::get('/', 'ParallelController@index');
            Route::get('/{parallel}', 'ParallelController@show');
            Route::post('/', 'ParallelController@store');
            Route::match(['put', 'patch'], '/{parallel}', 'ParallelController@update');
            Route::delete('/{parallel}', 'ParallelController@destroy');
        });
        Route::group(['prefix' => 'subjects'], function () {
            Route::get('/', 'SubjectController@index');
            Route::get('/{subject}', 'SubjectController@show');
            Route::post('/', 'SubjectController@store');
            Route::match(['put', 'patch'], '/{subject}', 'SubjectController@update');
            Route::delete('/{subject}', 'SubjectController@destroy');
        });
        Route::group(['prefix' => 'designations'], function () {
            Route::post('/index', 'DesignationController@index');
            Route::post('/get-data', 'DesignationController@getData');
            Route::get('/{designation}', 'DesignationController@show');
            Route::post('/', 'DesignationController@store');
            Route::match(['put', 'patch'], '/{designation}', 'DesignationController@update');
            Route::delete('/{designation}', 'DesignationController@destroy');
        });

        Route::group(['prefix' => 'rooms'], function () {
            Route::post('/index', 'RoomController@index');
            Route::post('/get-data', 'RoomController@getData');
            Route::get('/get-students/{id}', 'RoomController@getStudents');
            Route::post('/students/store', 'RoomController@storeStudent');
            Route::get('/students/{id}', 'RoomController@students');
            Route::delete('/students/delete/{id}', 'RoomController@deleteStudent');
            Route::get('/{room}', 'RoomController@show');
            Route::post('/', 'RoomController@store');
            Route::match(['put', 'patch'], '/{room}', 'RoomController@update');
            Route::delete('/{room}', 'RoomController@destroy');
        });

        Route::group(['prefix' => 'documents'], function () {
            Route::get('/get-grades', 'DocumentController@getGrades');
            Route::get('/', 'DocumentController@index');
            Route::get('/{document}', 'DocumentController@show');
            Route::post('/', 'DocumentController@store');
            Route::match(['put', 'patch'], '/{document}', 'DocumentController@update');
            Route::delete('/{document}', 'DocumentController@destroy');
        });
    });

    Route::group(['namespace' => 'Api\Learn', 'prefix' => 'learn'], function () {
        Route::group(['prefix' => 'rooms'], function () {
            Route::get('/', 'RoomController@index');
            Route::get('/{room}', 'RoomController@show');
            Route::post('/', 'RoomController@store');
            Route::match(['put', 'patch'], '/{room}', 'RoomController@update');
            Route::delete('/{room}', 'RoomController@destroy');

            Route::get('lists/students', 'StudentController@index');
        });
    });

    Route::group(['namespace' => 'Api\Lms', 'prefix' => 'lms'], function () {
        Route::group(['prefix' => 'topics'], function () {
            Route::get('/index/{designation}', 'TopicController@index');
            Route::get('/list/{designation}', 'TopicController@list');
            Route::get('/{topic}', 'TopicController@show');
            Route::post('/', 'TopicController@store');
            Route::match(['put', 'patch'], '/{topic}', 'TopicController@update');
            Route::delete('/{topic}', 'TopicController@destroy');
        });

        Route::group(['prefix' => 'tasks'], function () {
            Route::get('/{task}', 'TaskController@show');
            Route::post('/', 'TaskController@store');
            Route::match(['put', 'patch'], '/{task}', 'TaskController@update');
            Route::delete('/{task}', 'TaskController@destroy');
        });
    });

    Route::group(['namespace' => 'Api\Board', 'prefix' => 'board'], function () {
        Route::group(['prefix' => 'rooms'], function () {
            Route::get('/', 'RoomController@index');
            Route::get('/{room}', 'RoomController@index');
        });

        Route::group(['prefix' => 'tasks'], function () {
            Route::get('/{room}/{task}', 'TaskController@index');
            Route::get('{task}', 'TaskController@show');
            Route::post('/', 'TaskController@store');
            Route::match(['put', 'patch'], '/{task}', 'TaskController@update');
            Route::delete('/{task}', 'TaskController@destroy');
        });
    });
});

Route::get('home', function () {
    if ( \Auth::user()->role == 'teacher' )
        return redirect('/learn/home');
    else if (\Auth::user()->role == 'student')
        return redirect('/board/home');
    else
        return redirect('/admin/home');
});

Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/{any}', 'HomeController@index')->where('any', '.*');
});

Route::group(['prefix' => '/learn', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/{any}', 'HomeController@learn')->where('any', '.*');
});

Route::group(['prefix' => '/board', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/{any}', 'HomeController@panel')->where('any', '.*');
});