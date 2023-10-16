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
        // if (method_exists($this, 'publishes')) {
        //     $this->package('rap2hpoutre/laravel-log-viewer', 'laravel-log-viewer', __DIR__ . '/../../');
        // }
        if (method_exists($this, 'package')) {
            $this->package('logvieweradarsh/Log-Viewer-Laravel', 'Log-Viewer-Laravel', __DIR__ . '/../../');
        }

        if (method_exists($this, 'loadViewsFrom')) {
            $this->loadViewsFrom(__DIR__.'/../../views', 'Log-Viewer-Laravel');
        }
        
        if (method_exists($this, 'publishes')) {
            $this->publishes([
                   __DIR__.'/../../views' => base_path('/resources/views/vendor/Log-Viewer-Laravel'),
            ], 'views');
            $this->publishes([
                __DIR__.'/../../config/logviewer.php' => $this->config_path('logviewer.php'),
            ]);
            $this->publishes([
                    __DIR__.'/../../controllers' => base_path('/app/Http/Controllers/logviewer'),
            ]);
            $this->publishes([
                    __DIR__.'/../../Viewerlogic' => base_path('/app/Http/Rap2hpoutre/LaravelLogViewer'),
            ], 'Rap2hpoutre/LaravelLogViewer');

        }
    }
    // app\Http\Controllers\logviewer

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