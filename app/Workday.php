<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Workday extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'date'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        //'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function monthBalance($month = null)
    {
        if(empty($month))
            $month = 'this month';

        $month = new Carbon("first day of {$month}");

        $positiveMonthBalance = Carbon::createFromTime(0, 0, 0);
        $negativeMonthBalance = Carbon::createFromTime(0, 0, 0);
        $zeroBase = Carbon::createFromTime(0, 0, 0);

        $workdays = self::daysInMonth($month);

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

    public static function groupedByMonth($format = 'F')
    {
        return self::orderBy('date', 'DESC')
            // TODO: use joins on it
            ->where('user_id', '=', Auth::user()->id)
            ->get()
            ->groupBy(function ($workday) use ($format) {
                return $workday->date->format($format);
            });
    }

    public static function daysInMonth(Carbon $month) {
        return self::where(function ($query) use ($month) {
            $query->where('date', '>=', clone $month);
            $query->where('date', '<=', $month->modify('last day of this month'));
            //TODO: change it for inner join
        })
            ->where('user_id', '=', Auth::user()->id)
            ->get();
    }

    protected static function isTimeSet($time)
    {
        return (bool) ((int) (new Carbon($time))->format('His'));
    }

    public function getBalanceAttribute($balance)
    {
        // TODO: improve this method
        $balance -= $this->workload
            ->diffInMinutes(Carbon::createFromTime(0, 0, 0));

        if( true === (bool) $this->arrival1
            && true === (bool) $this->leaving1
        ) {
            $balance += $this->arrival1->diffInMinutes($this->leaving1);
        }

        if( true === (bool) $this->arrival2
            && true === (bool) $this->leaving2
        ) {
            $balance += $this->arrival2->diffInMinutes($this->leaving2);
        }

        if( true === (bool) $this->arrival3
            && true === (bool) $this->leaving3
        ) {
            $balance += $this->arrival3->diffInMinutes($this->leaving3);
        }

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
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date);
    }

    public function getArrival1Attribute($time)
    {
        if(false === self::isTimeSet($time))
            return false;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    public function getLeaving1Attribute($time)
    {
        if(false === self::isTimeSet($time))
            return false;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    public function getArrival2Attribute($time)
    {
        if(false === self::isTimeSet($time))
            return false;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    public function getLeaving2Attribute($time)
    {
        if(false === self::isTimeSet($time))
            return false;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    public function getArrival3Attribute($time)
    {
        if(false === self::isTimeSet($time))
            return false;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    public function getLeaving3Attribute($time)
    {
        if(false === self::isTimeSet($time))
            return false;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    public function getWorkloadAttribute($time)
    {
        return Carbon::createFromFormat('H:i:s', $time);
    }
}