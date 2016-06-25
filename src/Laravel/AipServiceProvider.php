<?php

namespace Buzzylab\Aip\Laravel;

use Buzzylab\Aip\Arabic;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AipServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->registerBladeDirectives();
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->singleton('arabic', function ($app) {
            return new Arabic();
        });
    }


    protected function registerBladeDirectives()
    {
        // Charset
        Blade::directive('charset', function($value)
        {
            return "<?php echo Arabic::getCharset($value); ?>";
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return ['arabic'];
    }
}