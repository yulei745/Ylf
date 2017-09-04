<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/10
 * Time: 12:18
 */

namespace Ylf\Api\Serializers;

use DateTime;
use Tobscure\JsonApi\AbstractSerializer as BaseAbstractSerializer;

abstract class AbstractSerializer extends BaseAbstractSerializer
{

    public function getAttributes($model, array $fields = null)
    {
        if (! is_object($model) && ! is_array($model)) {
            return [];
        }

        $attributes = $this->getDefaultAttributes($model);

        return $attributes;
    }

    abstract protected function getDefaultAttributes($model);

    /**
     * @param DateTime|null $date
     * @return string|null
     */
    protected function formatDate(DateTime $date = null, $type = DateTime::ATOM)
    {
        if ($date) {
            return $date->format($type);
        }
    }

}