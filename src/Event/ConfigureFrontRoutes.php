<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/25
 * Time: 14:20
 */

namespace Ylf\Event;

use Ylf\Http\RouteCollection;
use Ylf\Http\Handler\RouteHandlerFactory;

class ConfigureFrontRoutes
{
    /**
     * @var RouteCollection
     */
    public $routes;

    /**
     * @var RouteHandlerFactory
     */
    protected $route;

    /**
     * ConfigureFrontRoutes constructor.
     * @param RouteCollection $routes
     * @param RouteHandlerFactory $route
     */
    public function __construct(RouteCollection $routes, RouteHandlerFactory $route)
    {
        $this->routes = $routes;
        $this->route = $route;
    }

    /**
     * @param string $url
     * @param string $name
     * @param string $controller
     */
    public function get($url, $name, $controller)
    {
        echo 'asdf';exit;
    }

}