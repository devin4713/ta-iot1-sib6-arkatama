<?php

namespace App\Http\Controllers;
use App\Models\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function edgecomp () {
        $localServerUrl = 'http://192.168.112.193:9000/api/sensor/latest4';

        $response = Http::timeout(2)->get($localServerUrl);
        $sensorData = $response->json();
        return $sensorData;
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
        // $sensor = SensorData::orderBy('created_at', 'desc')->first();
        // return response()->json($sensor);
        return SensorData::orderBy('created_at', 'desc')->first();
    }
}
