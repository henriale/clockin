<?php

namespace App;

use Carbon\Carbon;
use Jenssegers\Mongodb\Model as Eloquent;

class Workday extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'workday';
    protected $primaryKey = '_id';

    protected $dates = ['date'];

    public function getBalanceAttribute($balance)
    {
        if( ! empty($this->in1) && ! empty($this->out1))
            $balance += $this->in1->diffInMinutes($this->out1);

        if( ! empty($this->in2) && ! empty($this->out2))
            $balance += $this->in2->diffInMinutes($this->out2);

        if( ! empty($this->in3) && ! empty($this->out3))
            $balance += $this->in3->diffInMinutes($this->out3);

        $sign = ($balance < 0) ? '-' : '+';
        $sign = ($balance == 0) ? null : $sign;

        $balance = Carbon::createFromTime(0, 0, 0)
            ->addMinutes(abs($balance));

        return (object) [
            'value' => $balance,
            'sign' => $sign
        ];
    }

    public function setDateAttribute($date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);
        $this->attributes['date'] = new \MongoDate($date->getTimestamp());
    }

    public function getDateAttribute(\MongoDate $date)
    {
        return $date->toDateTime();
    }

    public function getIn1Attribute($time)
    {
        if(empty($time))
            return false;
        return Carbon::createFromFormat('H:i', $time);
    }

    public function getOut1Attribute($time)
    {
        if(empty($time))
            return false;
        return Carbon::createFromFormat('H:i', $time);
    }

    public function getIn2Attribute($time)
    {
        if(empty($time))
            return false;
        return Carbon::createFromFormat('H:i', $time);
    }

    public function getOut2Attribute($time)
    {
        if(empty($time))
            return false;
        return Carbon::createFromFormat('H:i', $time);
    }

    public function getIn3Attribute($time)
    {
        if(empty($time))
            return false;
        return Carbon::createFromFormat('H:i', $time);
    }

    public function getOut3Attribute($time)
    {
        if(empty($time))
            return false;
        return Carbon::createFromFormat('H:i', $time);
    }

    public static function monthBalance($month=null)
    {
        if(empty($month))
            $month = new Carbon('first day of this month');
        else
            $month = new Carbon('first day of '.$month);
            
        $positiveMonthBalance = Carbon::createFromTime(0, 0, 0);
        $negativeMonthBalance = Carbon::createFromTime(0, 0, 0);
        $zeroBase = Carbon::createFromTime(0, 0, 0);

        $workdays = self::daysOfMonth($month);
        
        foreach($workdays as $workday) {
            $minutes = $zeroBase->diffInMinutes($workday->balance->value);

            if($workday->balance->sign == '+') {
                $positiveMonthBalance->addMinutes($minutes);
            }
            elseif($workday->balance->sign == '-') {
                $negativeMonthBalance->addMinutes($minutes);
            }
        }
        
        $monthMinutes = $positiveMonthBalance->diffInMinutes($negativeMonthBalance);

        return $zeroBase->addMinutes($monthMinutes);
    }
    
    public static function groupedByMonthFormat($format='F')
    {
        return self::orderBy('date', 'DESC')
            ->get()
            ->groupBy(function ($workday) use ($format) {
                return $workday->date->format($format);
            });   
    }
    
    public static function daysOfMonth($month) {
        return self::where(function ($query) use ($month) {
            $query->where('date', '>=', $month);
            $query->where('date', '<=', $month->modify('last day of this month'));
        })->get();
    }
}