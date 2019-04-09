<?php

namespace Encore\Admin\Config;

use Encore\Admin\Admin;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;


class Config
{
    /**
     * Load configure into laravel from database.
     *
     * @return void
     */
    public static function load()
    {
        foreach (ConfigModel::all(['name', 'value']) as $config) {
            config([$config['name'] => $config['value']]);
        }
    }

    /**
     * Bootstrap this package.
     *
     * @return void
     */
    public static function boot()
    {
        self::registerRoutes();

        //Admin::extend('config', __CLASS__);
    }

    /**
     * Register routes for laravel-admin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        $router = app('router');

        $router->resource(
            config('admin.extensions.config.name', 'config'),
            config('admin.extensions.config.controller', 'Encore\Admin\Config\ConfigController')
        );
        //dump($router);
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        Menu::create([
            'title'     => 'Config',
            'icon'      => 'fa-toggle-on',
            'uri'       => 'config',
        ]);
        $permission = new Permission();
        $permission->name = 'Admin Config';
        $permission->display_name = 'ext.config';
        $permission->description = 'config*';
        $permission->save();

    }
}
