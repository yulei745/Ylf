<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 16:36
 */

namespace Ylf\Front;

use Ylf\Foundation\AbstractServiceProvider;
use Ylf\Http\Controller\ControllerInterface;
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

    /**
     * @param RouteCollection $routes
     */
    protected function populateRoutes(RouteCollection $routes)
    {
        $route = $this->app->make(RouteHandlerFactory::class);
        $config = $this->app->make('ylf.config');
        if(!empty($config['routes'])) {
            foreach ($config['routes'] as $k => $v) {
                list($controller, $name) = explode('@', $v[1]);
                $routes->get($v[0], $name, $route->toController("Ylf\Front\Controller\\{$controller}"));
            }
        }
    }
}