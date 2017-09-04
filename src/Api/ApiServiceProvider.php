<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 14:14
 */

namespace Ylf\Api;


use Ylf\Foundation\AbstractServiceProvider;
use Ylf\Http\RouteCollection;
use Ylf\Api\Controller\AbstractSerializeController;

use Tobscure\JsonApi\ErrorHandler;
use Tobscure\JsonApi\Exception\Handler\FallbackExceptionHandler;
use Tobscure\JsonApi\Exception\Handler\InvalidParameterExceptionHandler;


class ApiServiceProvider extends AbstractServiceProvider
{

    /**
     *  first register
     */
    public function register()
    {
        $this->app->singleton('ylf.api.routes', function () {
            return new RouteCollection;
        });

        $this->app->singleton(UrlGenerator::class, function () {
            return new UrlGenerator($this->app, $this->app->make('ylf.api.routes'));
        });

        $this->app->singleton(ErrorHandler::class, function () {
            $handler = new ErrorHandler;

//            $handler->registerHandler(new Handler\FloodingExceptionHandler);
//            $handler->registerHandler(new Handler\IlluminateValidationExceptionHandler);
//            $handler->registerHandler(new Handler\InvalidAccessTokenExceptionHandler);
//            $handler->registerHandler(new Handler\InvalidConfirmationTokenExceptionHandler);
            $handler->registerHandler(new Handler\MethodNotAllowedExceptionHandler);
//            $handler->registerHandler(new Handler\ModelNotFoundExceptionHandler);
//            $handler->registerHandler(new Handler\PermissionDeniedExceptionHandler);
            $handler->registerHandler(new Handler\RouteNotFoundExceptionHandler);
//            $handler->registerHandler(new Handler\TokenMismatchExceptionHandler);
//            $handler->registerHandler(new Handler\ValidationExceptionHandler);
            $handler->registerHandler(new InvalidParameterExceptionHandler);
            $handler->registerHandler(new FallbackExceptionHandler($this->app->inDebugMode()));

            return $handler;
        });
    }

    /**
     * send boot
     */
    public function boot()
    {
        $this->populateRoutes($this->app->make('ylf.api.routes'));

        AbstractSerializeController::setContainer($this->app);
    }


    /**
     * @return string
     */
    public function getRootesName() {
        return 'Api';
    }

}