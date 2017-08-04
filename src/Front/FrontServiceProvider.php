<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 16:36
 */

namespace Ylf\Front;

use Ylf\Foundation\AbstractServiceProvider;
use Ylf\Http\RouteCollection;

class FrontServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->singleton('ylf.front.routes', function () {
            return new RouteCollection;
        });
    }

    public function boot()
    {
        $this->populateRoutes($this->app->make('ylf.front.routes'));
    }

    protected function populateRoutes(RouteCollection $routes)
    {
        $routes->get('/d', 'aa', function ($a, $b) {
            print_r($b);exit;
        });
    }
}