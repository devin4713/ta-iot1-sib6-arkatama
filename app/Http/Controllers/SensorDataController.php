<?php

namespace App\Http\Controllers;
use App\Models\SensorData;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function sentfromesp (Request $request) {
        $request->validate([
            'temp' => 'required|numeric',
            'humi' => 'required|numeric',
            'rain' => 'required|numeric',
            'gas' => 'required|numeric',
        ]);

        $sensordata = new SensorData();
        $sensordata->temp = $request->temp;
        $sensordata->humi = $request->humi;
        $sensordata->rain = $request->rain;
        $sensordata->gas = $request->gas;
        $sensordata->save();

        return response()->json(['message' => 'Sensor Data is Sent', 'data' => $sensordata], 201);
    }

    public function showsensortoweb () {
        $sensordata = SensorData::latest()->take(5)->get();
        return view('sensorpage', ['sensordata' => $sensordata, 'title' => 'Sensor Data']);
    }

    public function updatechart() {
        $sensordata = SensorData::latest()->take(5)->get();
        return response()->json($sensordata);
    }

    public function updatedashboard() {
        $sensor = SensorData::orderBy('created_at', 'desc')->first();
        return response()->json($sensor);
    }
}
