<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$app->get('/', function () use ($app) {
    return view('main');
});
$app->get('/migration', 'MigrationController@index');

$app->post('/migration', 'MigrationController@saveMigration');
$app->post('/migration/columns', 'MigrationController@saveColumns');
$app->get('/migration/id/{in}', 'MigrationController@tableSync');
$app->delete('/migration/remove/{id}', 'MigrationController@removeColumn');
