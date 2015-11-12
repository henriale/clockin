<?php

namespace App\Http\Controllers;

use App\Workday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class WorkdayController extends Controller
{
    public function store()
    {
        $date = Carbon::createFromFormat('d/m/Y', Request::input('date'));

        $workday = new Workday();
        $workday->date = Request::input('date');
        $workday->arrival1 = Request::input('in1');
        $workday->leaving1 = Request::input('out1');
        $workday->arrival2 = Request::input('in2');
        $workday->leaving2 = Request::input('out2');
        $workday->arrival3 = Request::input('in3');
        $workday->leaving3 = Request::input('out3');
        $workday->user_id = Auth::user()->id;
        $workday->workload = $date->isWeekend() ? '00:00' : '08:00';
        $workday->save();

        return redirect('/')->with([
            'messages' => [[
                'type' => 'success',
                'text' => 'Workday time successfully registered!'
            ]]
        ]);
    }

    public function update($id)
    {

    }

    public function destroy($id)
    {
        $responseMessage = [
            'id' => $id,
            'success' => false,
        ];

        if( ! $workday = Workday::find($id))
            return response()->json($responseMessage);

        $workday->delete();
        $responseMessage['success'] = true;

        return response()->json($responseMessage);
    }

    public function setWorkingDayCache()
    {
        $cacheKey = Auth::user()->id;
        $data = Request::input('data');

        Cache::forever($cacheKey, $data);
    }

    public function getWorkingDayCache()
    {
        $cacheKey = Auth::user()->id;

        $defaultData = json_encode(['date' => Carbon::now()->format('d/m/Y')]);

        return Cache::get($cacheKey, $defaultData);
    }
}