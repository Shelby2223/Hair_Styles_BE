<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\shops;

class ShopController extends Controller
{
    public function index()
    {
        $shops = shops::all();
        return response()->json($shops);
    }

    public function show($shop_id)
    {
        $shop = shops::findOrFail($shop_id);
        return response()->json($shop);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'shop_name' => 'required',
            'shop_phone' => 'required',
            'user_id' => 'required',
        ]);

        $shop = shops::create($validatedData);
        return response()->json($shop, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_name' => 'required',
            'shop_phone' => 'required',
            'user_id' => 'required',
        ]);

        $shop = shops::findOrFail($id);
        $shop->update($validatedData);
        return response()->json($shop);
    }

    public function destroy($id)
    {
        $shop = shops::findOrFail($id);
        $shop->delete();
        return response()->json('Shop deleted successfully');
    }
}
