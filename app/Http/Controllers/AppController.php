<?php

namespace App\Http\Controllers;

use App\Workday;

class AppController extends Controller
{
    public function main()
    {
        return view('main', [
            'months' => Workday::groupedByMonthFormat('F'),
        ]);
    }
}