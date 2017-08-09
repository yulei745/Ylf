<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 15:21
 */

namespace Ylf\Http\Middleware;

use Exception;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Zend\Stratigility\MiddlewareInterface;
use Zend\Diactoros\Response\HtmlResponse;

use Franzl\Middleware\Whoops\ErrorMiddleware as WhoopsMiddleware;

class HandleErrors implements MiddlewareInterface
{

    protected $logger;
    protected $debug;
    protected $templateDir;

    /**
     * HandleErrors constructor.
     * @param LoggerInterface $logger
     * @param bool $debug
     */
    public function __construct($templateDir, LoggerInterface $logger, $debug = false)
    {
        $this->logger = $logger;
        $this->debug = $debug;
        $this->templateDir = $templateDir;
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
            return $this->formatException($e, $request, $response, $out);
        }
    }


    /**
     * @param Exception $error
     * @param Request $request
     * @param Response $response
     * @param callable|null $out
     * @return \Zend\Diactoros\Response\HtmlResponse
     */
    protected function formatException(Exception $error, Request $request, Response $response, callable $out = null)
    {
        $status = 500;
        $errorCode = $error->getCode();

        // If it seems to be a valid HTTP status code, we pass on the
        // exception's status.
        if (is_int($errorCode) && $errorCode >= 400 && $errorCode < 600) {
            $status = $errorCode;
        }

        if ($this->debug && ! in_array($errorCode, [403, 404])) {
            $whoops = new WhoopsMiddleware;

            return $whoops($error, $request, $response, $out);
        }

        // Log the exception (with trace)
        $this->logger->debug($error);

        $errorPage = $this->getErrorPage($status);

        return new HtmlResponse($errorPage, $status);
    }

    /**
     * @param string $status
     * @return string
     */
    protected function getErrorPage($status)
    {
        if (! file_exists($errorPage = $this->templateDir."/$status.html")) {
            $errorPage = $this->templateDir.'/500.html';
        }

        return file_get_contents($errorPage);
    }
}