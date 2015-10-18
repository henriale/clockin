<?php

namespace App\Http\Controllers;

use App\Workday;

class AppController extends Controller
{
    public function main()
    {
        $monthlyWorkingTime = Workday::groupedByMonth('F');
        $monthlyBalances = [];

        foreach ($monthlyWorkingTime as $monthName => $month) {
            $monthlyBalances[$monthName] = Workday::monthBalance($monthName);
        }

        return view('main', [
            'months' => $monthlyWorkingTime,
            'monthlyBalances' => $monthlyBalances
        ]);
    }
}