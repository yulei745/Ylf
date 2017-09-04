<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/10
 * Time: 12:30
 */

namespace Ylf\Api\Serializers;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class TestSerializer extends AbstractSerializer
{
    protected $type = 'user';

    /**
     * @param $model
     * @return array
     */
    protected function getDefaultAttributes($model)
    {
//        $now = Carbon::now('utc')->toDateTimeString();

        // TODO: Implement getDefaultAttributes() method.

        return [
            'name' => 'aslkdfjlk',
            'body' => 'boaydkjf',
            'date' => $this->formatDate(new DateTime('now'), 'Y-m-d H:i:s')
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function getId($model)
    {
        return 1;
    }
}