<?php 

namespace ViewerLogic;

use Illuminate\Support\ServiceProvider;

class LogViewerLaravelProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this, 'package')) {
            $this->package('logvieweradarsh/log-viewer-laravel', 'log-viewer-laravel', __DIR__ . '/../../');
        }

        if (method_exists($this, 'loadViewsFrom')) {
            $this->loadViewsFrom(__DIR__.'/../views', 'log-viewer-laravel');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
    
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    private function config_path($path = '')
    {
        return function_exists('config_path') ? config_path($path) : app()->basePath() . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

}
