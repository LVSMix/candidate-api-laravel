<?php


namespace App\Http\Controllers;


use App\Models\Process;
use Illuminate\Support\Carbon;
use App\Result;
use Illuminate\Support\Facades\Log;


class ProcessController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function checkProcessAlive(){
        $result= new Result;
        $process = Process::where("resultado","=","EN PROCESO")->get();
        Log::debug('processs => '.$process);
        $result->resultado = true;
        if (count($process) == 0) {
            $result->resultado = false;
            return response()->json($result);
        }
        return response()->json($result);
    }

    public function executeProcess(){
        $result= new Result;
        $today = Carbon::today()->toDayDateTimeString();
        $process = new Process;
        $process->name = "PROCESO DE MIGRACION EN EJECUCION";
        $process->resultado = "EN PROCESO";
        $process->created_at = $today;
        $process->save();
        $result->resultado = "OK";
        return response()->json($result);
    }

}
