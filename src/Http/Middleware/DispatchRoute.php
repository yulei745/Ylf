<?php

namespace Ylf\Http\Middleware;

use Ylf\Http\RouteCollection;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use FastRoute\Dispatcher;

use Zend\Diactoros\Response\HtmlResponse;

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 14:23
 */
class DispatchRoute
{
    /*
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create the middleware instance.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;

    }

    /**
     * Dispatch the given request to our route collection.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     * @return Response
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $method = $request->getMethod();
        $uri = $request->getUri()->getPath() ?: '/';


        $routeInfo = $this->getDispatcher()->dispatch($method, $uri);


        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return new HtmlResponse('NOT_FOUND 404');

            case Dispatcher::METHOD_NOT_ALLOWED:
                return new HtmlResponse('METHOD_NOT_ALLOWED 503');

            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $parameters = $routeInfo[2];

                return $handler($request, $parameters);
        }
    }

    protected function getDispatcher()
    {
        if (! isset($this->dispatcher)) {
            $this->dispatcher = new Dispatcher\GroupCountBased($this->routes->getRouteData());
        }

        return $this->dispatcher;
    }
}