<?php

namespace App\Http\Controllers;

use App\Workday;
use Illuminate\Support\Facades\Request;

class WorkdayController extends Controller
{
    
    public function store()
    {
        $workday = new Workday();
        $workday->date = Request::input('date');
        $workday->in1 = Request::input('in1');
        $workday->out1 = Request::input('out1');
        $workday->in2 = Request::input('in2');
        $workday->out2 = Request::input('out2');
        $workday->in3 = Request::input('in3');
        $workday->out3 = Request::input('out3');
        $workday->balance = -480;
        $workday->save();

        return redirect()->back()->with([
            'message' => [
                'type' => 'success',
                'text' => 'Registro salvo com sucesso!',
            ]
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
}