<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/9
 * Time: 12:58
 */
namespace Ylf\Api\Handler;

use Exception;
use Ylf\Http\Exception\RouteNotFoundException;
use Tobscure\JsonApi\Exception\Handler\ExceptionHandlerInterface;
use Tobscure\JsonApi\Exception\Handler\ResponseBag;

class RouteNotFoundExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function manages(Exception $e)
    {
        return $e instanceof RouteNotFoundException;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Exception $e)
    {
        $status = 404;
        $error = [
            'status' => (string) $status,
            'message' => 'route_not_found'
        ];

        return new ResponseBag($status, [$error]);
    }
}
