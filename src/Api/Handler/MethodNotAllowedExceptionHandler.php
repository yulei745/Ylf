<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/9
 * Time: 13:07
 */

namespace Ylf\Api\Handler;


use Exception;
use Flarum\Http\Exception\MethodNotAllowedException;
use Tobscure\JsonApi\Exception\Handler\ExceptionHandlerInterface;
use Tobscure\JsonApi\Exception\Handler\ResponseBag;

class MethodNotAllowedExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function manages(Exception $e)
    {
        return $e instanceof MethodNotAllowedException;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Exception $e)
    {
        $status = 405;
        $error = [
            'status' => (string) $status,
            'message' => 'method_not_allowed'
        ];

        return new ResponseBag($status, [$error]);
    }
}