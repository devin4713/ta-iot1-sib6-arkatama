<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use App\Models\LEDData;

class DashboardController extends Controller
{
    public function index()
    {
        $sensor = SensorData::orderBy('created_at', 'desc')->first();

        $leds = LEDData::all();

        return view('dashboard', [
            'title' => 'Dashboard',
            'sensor' => $sensor,
            'leds' => $leds
        ]);
    }
}
