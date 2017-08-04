<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 09:57
 */

namespace Ylf\Http\Exception;

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct($message = null, $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
