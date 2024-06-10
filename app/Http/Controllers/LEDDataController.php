<?php

namespace App\Http\Controllers;
use App\Models\LEDData;
use Illuminate\Http\Request;

class LEDDataController extends Controller
{
    public function sendtoesp () {
        return LEDData::all();
    }

    public function showledtoweb () {
        $leddata = LEDData::all();
        return view('ledpage', ['leddata' => $leddata, 'title' => 'LED Control']);
    }

    public function storeledtodb (Request $request) {
        $request->validate([
            'led_name' => 'required|string|max:255',
            'pin' => 'required|integer',
        ]);

        $leddata = new LEDData();
        $leddata->led_name = $request->led_name;
        $leddata->pin = $request->pin;
        $leddata->status = 0;
        $leddata->save();

        return response()->json(['message' => 'LED created successfully', 'data' => $leddata], 201);
    }

    public function updateledtodb (Request $request, $id) {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $leddata = LEDData::findOrFail($id);
        $leddata->status = $request->status;
        $leddata->save();

        return response()->json(['message' => 'LED status updated successfully', 'data' => $leddata], 200);
    }

    public function destroyfromdb ($id)
    {
        $leddata = LEDData::findOrFail($id);
        $leddata->delete();

        return response()->json(['message' => 'LED deleted successfully'], 200);
    }
}
