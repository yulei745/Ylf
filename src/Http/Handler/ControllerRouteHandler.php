<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 10:12
 */

namespace Ylf\Http\Handler;

use Ylf\Http\Controller\ControllerInterface;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ControllerRouteHandler
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @param Container $container
     * @param string $controller
     */
    public function __construct(Container $container, $controller)
    {
        $this->container = $container;
        $this->controller = $controller;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $routeParams
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, array $routeParams)
    {
        $controller = $this->resolveController($this->controller);

        $request = $request->withQueryParams(array_merge($request->getQueryParams(), $routeParams));

        return $controller->handle($request);
    }

    /**
     * @param string $class
     * @return ControllerInterface
     */
    protected function resolveController($class)
    {
        $controller = $this->container->make($class);

        if (! ($controller instanceof ControllerInterface)) {
            throw new InvalidArgumentException(
                'Controller must be an instance of '.ControllerInterface::class
            );
        }

        return $controller;
    }
}