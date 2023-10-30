# logviewerlaravel
[![Total Downloads](https://img.shields.io/packagist/dt/logviewerlaravel/log-viewer-laravel.svg?style=flat-square)](https://packagist.org/packages/logviewerlaravel/log-viewer-laravel)
## TL;DR
Log Viewer for Laravel 5, 6, 7, 8 & 9. **Install with composer**.

## Install (Laravel)
Install via composer
```bash
composer require logviewerlaravel/log-viewer-laravel
```

Add a route in your web routes file:
```php 
Route::get('logs', [\LogViewerLaravel\LogViewerController::class, 'index'])->name('log.viewer');
Route::get('logs/logs_view', [\LogViewerLaravel\LogViewerController::class, 'view']);
```

Go to `http://yourwebsitename/logs` or some other route

## Advanced usage
### Customize view

Publish `log.blade.php` into `/resources/views/vendor/laravel-log-viewer/` for view customization:

```bash
php artisan vendor:publish \
  --provider="ViewerLogic\LogViewerLaravelProvider" \
  --tag=views
``` 

### Edit configuration
Publish `logviewer.php` configuration file into `/config/` for configuration customization:

```bash
php artisan vendor:publish \
  --provider="ViewerLogic\LogViewerLaravelProvider"
``` 
