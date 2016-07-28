<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' =>'/attribute'], function (Router $router) {
    $router->bind('attribute', function ($id) {
        return app(\Modules\Attribute\Repositories\AttributeRepository::class)->find($id);
    });
    $router->get('attributes', [
        'as' => 'admin.attribute.attribute.index',
        'uses' => 'AttributeController@index',
        'middleware' => 'can:attribute.attributes.index',
    ]);
    $router->get('attributes/create', [
        'as' => 'admin.attribute.attribute.create',
        'uses' => 'AttributeController@create',
        'middleware' => 'can:attribute.attributes.create',
    ]);
    $router->post('attributes', [
        'as' => 'admin.attribute.attribute.store',
        'uses' => 'AttributeController@store',
        'middleware' => 'can:attribute.attributes.create',
    ]);
    $router->get('attributes/{attribute}/edit', [
        'as' => 'admin.attribute.attribute.edit',
        'uses' => 'AttributeController@edit',
        'middleware' => 'can:attribute.attributes.edit',
    ]);
    $router->put('attributes/{attribute}', [
        'as' => 'admin.attribute.attribute.update',
        'uses' => 'AttributeController@update',
        'middleware' => 'can:attribute.attributes.edit',
    ]);
    $router->delete('attributes/{attribute}', [
        'as' => 'admin.attribute.attribute.destroy',
        'uses' => 'AttributeController@destroy',
        'middleware' => 'can:attribute.attributes.destroy',
    ]);
});
