<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 11:30
 */

require 'vendor/autoload.php';

use Ylf\Foundation\Application;


$app = new Application(__DIR__);



var_dump($app['app']);