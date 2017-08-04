<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 10:11
 */


namespace Ylf\Http\Handler;

use Illuminate\Contracts\Container\Container;

class RouteHandlerFactory
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $controller
     * @return ControllerRouteHandler
     */
    public function toController($controller)
    {
        return new ControllerRouteHandler($this->container, $controller);
    }
}
