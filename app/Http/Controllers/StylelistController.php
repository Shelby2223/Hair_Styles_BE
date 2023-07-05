<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop_Service;
use App\Models\stylists;

class StylistController extends Controller
{
    public function index() 
    {
        $stylists = stylists::all();
        return response()->json($stylists);
    }

    public function show($service_id)
    {
        $service = Shop_Service::findOrFail($service_id);
        return response()->json($service);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_price' => 'required',
            'service_image' => 'required',
            'shop_id' => 'required',
        ]);

        $service = Shop_Service::create($validatedData);
        return response()->json($service, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required',
            'service_price' => 'required',
            'service_image' => 'required'
        ]);

        $service = Shop_Service::findOrFail($id);
        $service->update($validatedData);
        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = Shop_Service::findOrFail($id);
        $service->delete();
        return response()->json('Service deleted successfully');
    }
}
