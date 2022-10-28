<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify;

use Illuminate\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/notify.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('notify.php')], 'config');
        }

        $this->mergeConfigFrom($source, 'notify');

        $this->registerBladeDirectives();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerNotify();
    }

    public function registerNotify()
    {
        $this->app->singleton('notify', function (Container $app) {
            return new Notify(NotifierFactory::make($app['config']['notify']), $app['session'], $app['config']);
        });

        $this->app->alias('notify', Notify::class);
    }

    public function registerBladeDirectives()
    {
        Blade::directive('notify_render', function () {
            return "<?php echo app('notify')->render(); ?>";
        });

        Blade::directive('notify_css', function () {
            return '<?php echo notify_css(); ?>';
        });

        Blade::directive('notify_js', function () {
            return '<?php echo notify_js(); ?>';
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'notify',
        ];
    }
}
