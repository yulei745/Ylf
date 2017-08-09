<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/8
 * Time: 13:46
 */

require 'vendor/autoload.php';

$server = new Ylf\Api\Server(__DIR__);
$server->listen();