<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 13:47
 */

namespace Ylf\Api;

use Ylf\Foundation\Application;
use Ylf\Http\AbstractServer;
use Ylf\Http\Middleware\HandleErrors;

use Zend\Diactoros\Response;
use Zend\Stratigility\MiddlewarePipe;

use Tobscure\JsonApi\Document;

class Server extends AbstractServer
{

    /**
     * @param Application $app
     * @return MiddlewarePipe
     */
    protected function getMiddleware(Application $app)
    {
        $pipe = new MiddlewarePipe();
        $pipe->setResponsePrototype(new Response());

        $path = parse_url($app->url('api'), PHP_URL_PATH);

        $pipe->pipe($path, $app->makeWith('Ylf\Api\Middleware\HandleErrors', ['debug'=>$app->inDebugMode()]));

        $pipe->pipe($path, $app->makeWith('Ylf\Http\Middleware\DispatchRoute', ['routes' => $app->make('ylf.api.routes')]));

        $pipe->pipe($path, function () {
            $document = new Document;
            $document->setErrors([
                [
                    'code' => 503,
                    'message' => 'Service Unavailable'
                ]
            ]);

            return new JsonApiResponse($document, 503);
        });
        return $pipe;
    }
}