<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/9
 * Time: 13:36
 */

namespace Ylf\Api\Controller;


use Illuminate\Contracts\Container\Container;

use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Parameters;
use Tobscure\JsonApi\SerializerInterface;
use Ylf\Api\JsonApiResponse;
use Ylf\Http\Controller\ControllerInterface;


abstract class AbstractSerializeController implements ControllerInterface
{

    /**
     * The name of the serializer class to output results with.
     *
     * @var string
     */
    public $serializer;


    /**
     * @var Container
     */
    protected static $container;


    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        // TODO: Implement handle() method.

        $document = new Document;

        $data = $this->data($request, $document);

        $serializer = static::$container->make($this->serializer);

        $element = $this->createElement($data, $serializer)
            ->fields($this->extractFields($request));

        $document->setData($element);

        return new JsonApiResponse($document);
    }

    /**
     * @param ServerRequestInterface $request
     * @param Document $document
     * @return mixed
     */
    abstract protected function data(ServerRequestInterface $request, Document $document);

    /**
     * Create a PHP JSON-API Element for output in the document.
     *
     * @param mixed $data
     * @param SerializerInterface $serializer
     * @return \Tobscure\JsonApi\ElementInterface
     */
    abstract protected function createElement($data, SerializerInterface $serializer);


    /**
     * @return Container
     */
    public static function getContainer()
    {
        return static::$container;
    }

    /**
     * @param Container $container
     */
    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Parameters
     */
    protected function buildParameters(ServerRequestInterface $request)
    {
        return new Parameters($request->getQueryParams());
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    protected function extractFields(ServerRequestInterface $request)
    {
        return $this->buildParameters($request)->getFields();
    }
}