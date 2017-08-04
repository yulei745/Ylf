<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 11:30
 */

require 'vendor/autoload.php';

$server = new Ylf\Front\Server(__DIR__);
$server->listen();

