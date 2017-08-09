<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 15:40
 */

namespace Ylf\Api\Middleware;

use Exception;

use Ylf\Api\ErrorHandler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class HandleErrors implements MiddlewareInterface
{
    protected $errorHandler;

    public function __construct($debug, ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
        $this->errorHandler->debug = $debug;
    }

    /**
     * Process an incoming request and/or response.
     *
     * Accepts a server-side request and a response instance, and does
     * something with them.
     *
     * If the response is not complete and/or further processing would not
     * interfere with the work done in the middleware, or if the middleware
     * wants to delegate to another process, it can use the `$next` callable
     * if present:
     *
     * <code>
     * return $next($request, $response);
     * </code>
     *
     * Middleware MUST return a response, or the result of $next (which should
     * return a response).
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $out)
    {
        try {
            return $out($request, $response);
        } catch (Exception $e) {
            return $this->errorHandler->handle($e);
        }
    }
}