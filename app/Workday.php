<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param null $month written month
     * @return array
     */
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

        $sign = $positiveMonthBalance > $negativeMonthBalance ? '+' : '-';
        $sign = $positiveMonthBalance == $negativeMonthBalance ? null : $sign;
        
        return [
            'sign' => $sign,
            'value' => $zeroBase->addMinutes($monthMinutes)
        ];
    }

    /**
     * return workdays grouped by month
     *
     * @param string $format date representation for month
     * @return mixed
     */
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

    /**
     * return all days of specified month
     *
     * @param Carbon $month
     * @return mixed
     */
    public static function daysInMonth(Carbon $month) {
        return self::where(function ($query) use ($month) {
            $query->where('date', '>=', clone $month);
            $query->where('date', '<=', $month->modify('last day of this month'));
            //TODO: change it for inner join
        })
            ->where('user_id', '=', Auth::user()->id)
            ->get();
    }

    /**
     * Check if time is set
     *
     * @param $time
     * @return bool
     */
    protected static function isTimeSet($time)
    {
        if (null === $time)
            return false;

        return (bool) ((int) (new Carbon($time))->format('His'));
    }

    /**
     * Validate format of a single field
     *
     * @param $field
     * @param $time
     */
    protected function validateTime($field, &$time)
    {
        $validation = Validator::make(
            [$field => $time],
            [$field => ['regex:/(([0-9]){2}:([0-9]){2})/', 'size:5']],
            [
                'regex' => 'The :attribute time format is invalid.',
                'size' => 'The :attribute time format is invalid.'
            ]
        );

        $time = "$time:00";

        if ($validation->fails())
            throw new ValidationException($validation);
    }

    /**
     * @param $balance
     * @return object
     */
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

    /**
     * @param $date
     */
    public function setDateAttribute($date)
    {
        if ( ! ($date instanceof Carbon))
            $date = Carbon::createFromFormat('d/m/Y', $date);

        $this->attributes['date'] = $date;
    }

    /**
     * @param $date
     * @return static
     */
    public function getDateAttribute($date)
    {
        if ( ! ($date instanceof Carbon))
            $date = Carbon::createFromFormat('Y-m-d', $date);

        return $date;
    }

    /**
     * @param $time
     * @return null|static
     */
    public function getArrival1Attribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        if (false === self::isTimeSet($time))
            return null;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setArrival1Attribute($time)
    {
        $this->validateTime('arrival1', $time);

        $this->attributes['arrival1'] = $time;
    }


    /**
     * @param $time
     * @return null|static
     */
    public function getLeaving1Attribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        if (false === self::isTimeSet($time))
            return null;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setLeaving1Attribute($time)
    {
        $this->validateTime('leaving1', $time);

        $this->attributes['leaving1'] = $time;
    }


    /**
     * @param $time
     * @return null|static
     */
    public function getArrival2Attribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        if (false === self::isTimeSet($time))
            return null;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setArrival2Attribute($time)
    {
        $this->validateTime('arrival2', $time);

        $this->attributes['arrival2'] = $time;
    }


    /**
     * @param $time
     * @return null|static
     */
    public function getLeaving2Attribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        if (false === self::isTimeSet($time))
            return null;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setLeaving2Attribute($time)
    {
        $this->validateTime('leaving2', $time);

        $this->attributes['leaving2'] = $time;
    }


    /**
     * @param $time
     * @return null|static
     */
    public function getArrival3Attribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        if (false === self::isTimeSet($time))
            return null;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setArrival3Attribute($time)
    {
        $this->validateTime('arrival3', $time);

        $this->attributes['arrival3'] = $time;
    }


    /**
     * @param $time
     * @return null|static
     */
    public function getLeaving3Attribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        if (false === self::isTimeSet($time))
            return null;

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setLeaving3Attribute($time)
    {
        $this->validateTime('leaving3', $time);

        $this->attributes['leaving3'] = $time;
    }


    /**
     * @param $time
     * @return static
     */
    public function getWorkloadAttribute($time)
    {
        if ($time instanceof Carbon)
            $time = $time->format('H:i:s');

        return Carbon::createFromFormat('H:i:s', $time);
    }

    /**
     * @param $time
     */
    public function setWorkloadAttribute($time)
    {
        $this->validateTime('workload', $time);

        $this->attributes['workload'] = $time;
    }

}