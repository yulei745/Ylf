<?php

namespace Ylf\Front;

use Ylf\Http\AbstractServer;
use Ylf\Foundation\Application;
use Ylf\Http\Middleware\DispatchRoute;
use Ylf\Http\RouteCollection;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Stratigility\MiddlewarePipe;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 13:24
 */
class Server extends AbstractServer
{

    /**
     * @param Application $app
     * @return MiddlewareInterface
     */
    protected function getMiddleware(Application $app)
    {
        $pipe = new MiddlewarePipe();

        $pipe->setResponsePrototype(new Response());

        $path = '/';

        $errorDir = __DIR__.'/../../error';

        $pipe->pipe($path, $app->make('Ylf\Http\Middleware\StartSession'));
        $pipe->pipe($path, $app->makeWith('Ylf\Http\Middleware\DispatchRoute', ['routes' => $app->make('ylf.front.routes')]));

        $pipe->pipe($path, function () use ($errorDir) {
            return new HtmlResponse(file_get_contents($errorDir . '/503.html', 503));
        });

        return $pipe;
    }
}