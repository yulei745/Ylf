<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/9/5
 * Time: 14:24
 */

$routes->get('/user/{id:\d+}', 'user', $route->toController('Ylf\Api\Controller\UserController'));