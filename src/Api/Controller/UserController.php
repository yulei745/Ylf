<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/9
 * Time: 13:45
 */

namespace Ylf\Api\Controller;


use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\SerializerInterface;
use Tobscure\JsonApi\Resource;
use Tobscure\JsonApi\Collection;
use Ylf\Api\UrlGenerator;

class UserController extends AbstractSerializeController
{

    public $serializer = \Ylf\Api\Serializers\TestSerializer::class;

    /**
     * @var UrlGenerator
     */
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * @param ServerRequestInterface $request
     * @param Document $document
     * @return mixed
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        // TODO: Implement data() method.
        $document->addPaginationLinks(
            $this->url->toRoute('user'),
            $request->getQueryParams(),
            0,
            10,
            0
        );

        return [144,2,3];
    }

    /**
     * Create a PHP JSON-API Element for output in the document.
     *
     * @param mixed $data
     * @param SerializerInterface $serializer
     * @return \Tobscure\JsonApi\ElementInterface
     */
    protected function createElement($data, SerializerInterface $serializer)
    {
        // TODO: Implement createElement() method.
        return new Resource($data, $serializer);
    }

}