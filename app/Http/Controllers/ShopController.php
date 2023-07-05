<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return response()->json($shops);
    }

    public function show($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        return response()->json($shop);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'shop_name' => 'required',
            'shop_phone' => 'required',
            'user_id' => 'required',
        ]);

        $shop = Shop::create($validatedData);
        return response()->json($shop, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_name' => 'required',
            'shop_phone' => 'required',
            'user_id' => 'required',
        ]);

        $shop = Shop::findOrFail($id);
        $shop->update($validatedData);
        return response()->json($shop);
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return response()->json('Shop deleted successfully');
    }
}
