<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/7
 * Time: 12:27
 */

namespace Ylf\Front\Controller;


use Psr\Http\Message\ServerRequestInterface;
use Ylf\Http\Controller\ControllerInterface;

use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response;

class UserController implements ControllerInterface
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        // TODO: Implement handle() method.
        $this->response->getBody()->write('asdfsadf'.array_get($request->getQueryParams(),'id'));
        return $this->response;
    }
}