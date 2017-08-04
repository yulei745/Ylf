<?php

namespace Ylf\Http;

use Ylf\Foundation\Application;
use Ylf\Foundation\AbstractServer as BaseAbstractServer;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Server;
use Zend\Stratigility\MiddlewareInterface;
use Zend\Stratigility\NoopFinalHandler;

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 13:15
 */
abstract class AbstractServer extends BaseAbstractServer
{
    public function listen()
    {
        Server::createServer(
            $this,
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        )->listen(new NoopFinalHandler());
    }

    /**
     * Use as PSR-7 middleware.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $out
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        $app = $this->getApp();

        $middleware = $this->getMiddleware($app);

        return $middleware($request, $response, $out);
    }

    /**
     * @param Application $app
     * @return MiddlewareInterface
     */
    abstract protected function getMiddleware(Application $app);

}