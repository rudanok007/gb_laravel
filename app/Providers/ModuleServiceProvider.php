<?php

namespace App\Providers;


use Config;
use File;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->modules()->each(function ($data) {
            $this->loadRoutes($data);
            $this->loadViews($data);
            $this->loadConfig($data);
        });
    }

    public function register()
    {
        $this->modules()->each(function ($data) {
            $moduleServiceProvider = $data['serviceProvider'];

            $this->app->register($moduleServiceProvider);
        });
    }

    protected function modules()
    {
        return collect(config('modules'))->map(function ($module) {
            $namespace = 'Modules\\' . $module;
            $serviceProviderClass = $namespace . '\\Providers\\ModuleServiceProvider';
//            return dd(new $serviceProviderClass);
            return [
                'name'            => $module,
                'serviceProvider' => new $serviceProviderClass($this->app),
                'namespace'       => $namespace,
            ];
        });
    }

    protected function loadRoutes($data)
    {
        $router = app(Router::class);
        $router->group([
            'namespace'  => $data['namespace'] . '\\Http\\Controllers',
            'middleware' => 'web',
        ], function ($router) use ($data) {
            $file = modules_path($data['name'], 'Http/routes.php');
            if (file_exists($file)) {
                require $file;
            }
        });
    }

    /**
     * @param $data
     */
    protected function loadViews($data)
    {
        view()->addNamespace(strtolower($data['name']), modules_path($data['name'], 'resources/views/'));
    }

    /**
     * @param $data
     */
    protected function loadConfig($data)
    {
        $namespace = strtolower($data['name']);

        $configs = File::glob(modules_path($data['name'], 'config/*.php'));
        collect($configs)->each(function ($filename) use ($namespace) {
            $config = require $filename;

            Config::set($namespace . '.' . basename($filename, '.php'), $config);
        });
    }

}
