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
use Ylf\Http\Handler\RouteHandlerFactory;

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
        $route = $this->app->make(RouteHandlerFactory::class);
        
        $routes->get('/', 'index', $route->toController(Controller\IndexController::class));
    }
}