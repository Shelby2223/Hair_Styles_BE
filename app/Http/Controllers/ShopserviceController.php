<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\shops_services;
use App\Models\services;


class ShopserviceController extends Controller
{
    public function index()
    {
        $shopservice= shops_services::all();
        return response()->json($shopservice);
    }

    public function show($service_id)
    {
        $shopservice = shops_services::findOrFail($service_id);
        return response()->json( $shopservice);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'service_price' => 'required',
            'service_image' => 'required',
             'shop_id' => 'required',
        ]);

        $shopservice= shops_services::create($validatedData);
        return response()->json($shopservice, 201);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required',
            'service_price' => 'required',
            'service_image' => 'required'
        ]);

        $shopservice = shops_services::findOrFail($id);
        $shopservice->update($validatedData);
        return response()->json( $shopservice);
    }

    public function destroy($id)
    {
        $shopservice = shops_services::findOrFail($id);
        $shopservice->delete();
        return response()->json('Shop deleted successfully');
    }
 c

}
