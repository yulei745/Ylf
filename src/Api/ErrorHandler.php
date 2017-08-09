<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 15:42
 */

namespace Ylf\Api;

use Exception;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\ErrorHandler as JsonApiErrorHandler;

class ErrorHandler
{
    /**
     * @var JsonApiErrorHandler
     */
    protected $errorHandler;

    public $debug;

    /**
     * @param JsonApiErrorHandler $errorHandler
     */
    public function __construct(JsonApiErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param Exception $e
     * @return JsonApiResponse
     */
    public function handle(Exception $e)
    {
        $response = $this->errorHandler->handle($e);

        $document = new Document;
        $document->setErrors($response->getErrors());

        return new JsonApiResponse($document, $response->getStatus());
    }
}