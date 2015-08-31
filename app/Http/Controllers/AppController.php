<?php

namespace App\Http\Controllers;

use App\Workday;

class AppController extends Controller
{
    public function main()
    {
        return view('main', [
            'workdays' => Workday::orderBy('date', 'DESC')->get(),
            'month_balance' => Workday::monthBalance()->format('H:i'),
        ]);
    }
}