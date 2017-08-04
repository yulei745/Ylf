<?php

namespace Ylf\Front\Controller;

use Ylf\Http\Controller\ControllerInterface;

use Illuminate\View\Factory;

use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response;

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 10:59
 */
class IndexController implements ControllerInterface
{

    /**
     * @param Request $request
     * @return \Zend\Diactoros\Response
     */
    public function handle(Request $request)
    {
        // TODO: Implement handle() method.

        $view = view('app');

        $response = new Response;
        $response->getBody()->write($view);

        return $response;
    }

}