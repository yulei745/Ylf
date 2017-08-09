<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 14:43
 */

namespace Ylf\Api;

use Tobscure\JsonApi\Document;
use Zend\Diactoros\Response\JsonResponse;

class JsonApiResponse extends JsonResponse
{
    /**
     * JsonApiResponse constructor.
     * @param Document $document
     * @param int $status
     * @param array $headers
     * @param int $encodingOptions
     */
    public function __construct(Document $document, $status = 200, array $headers = [], $encodingOptions = 15)
    {
        $headers['content-type'] = 'application/vnd.api+json';

        parent::__construct($document->jsonSerialize(), $status, $headers, $encodingOptions);
    }

}