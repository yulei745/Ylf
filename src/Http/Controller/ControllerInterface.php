<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 10:13
 */

namespace Ylf\Http\Controller;

use Psr\Http\Message\ServerRequestInterface;

interface ControllerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request);
}
