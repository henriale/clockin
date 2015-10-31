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
        /** @var Workday $workday */
        return [
            'date'      => $workday->date,
            'arrival1'  => $workday->arrival1,
            'leaving1'  => $workday->leaving1,
            'arrival2'  => $workday->arrival2,
            'leaving2'  => $workday->leaving2,
            'arrival3'  => $workday->arrival3,
            'leaving3'  => $workday->leaving3,
            'workload'  => $workday->workload,
            'balance'   => $workday->balance,
        ];
    }
}
