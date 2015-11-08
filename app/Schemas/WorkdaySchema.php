<?php namespace App\Schemas;

use \App\Workday;
use \Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * @package Neomerx\LimoncelloShot
 */
class WorkdaySchema extends SchemaProvider
{
    /**
     * @inheritdoc
     */
    protected $resourceType = 'workdays';

    /**
     * @inheritdoc
     */
    protected $selfSubUrl = '/workdays/';

    /**
     * @inheritdoc
     */
    public function getId($workday)
    {
        /** @var Workday $workday */
        return $workday->id;
    }

    /**
     * @inheritdoc
     */
    public function getAttributes($workday)
    {
        $balance = $workday->balance->sign . $workday->balance->value->format('H:i');
        /** @var Workday $workday */
        return [
            'date'      => $workday->date->format('Y-m-d'),
            'arrival1'  => $workday->arrival1 === null ?: $workday->arrival1->format('H:i'),
            'leaving1'  => $workday->leaving1 === null ?: $workday->leaving1->format('H:i'),
            'arrival2'  => $workday->arrival2 === null ?: $workday->arrival2->format('H:i'),
            'leaving2'  => $workday->leaving2 === null ?: $workday->leaving2->format('H:i'),
            'arrival3'  => $workday->arrival3 === null ?: $workday->arrival3->format('H:i'),
            'leaving3'  => $workday->leaving3 === null ?: $workday->leaving3->format('H:i'),
            'workload'  => $workday->workload === null ?: $workday->workload->format('H:i'),
            'balance'   => $balance,
        ];
    }
}
