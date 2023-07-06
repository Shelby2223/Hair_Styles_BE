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

    // duyệt BarBer Shop
    public function getBaberShop()
    {

        $shop = shops::join('users', 'shops.user_id', '=', 'users.user_id')
        ->where('is_shop', 0)       
        ->select('shops.*', 'shops.shop_name', 'shops.shop_image','shops.shop_name','users.user_address')
        ->get();
        return response()->json($shop);
    }
    public function BecomeShop($shop_id)
    {
        // Lấy thông tin của shop dựa trên shop_id
        $shop = shops::find($shop_id);
    
        // Kiểm tra xem shop có tồn tại hay không
        if (!$shop) {
            return response()->json(['message' => 'Shop không tồn tại'], 404);
        }
    
        // Cập nhật trường is_shop của shop thành 1
        $shop->is_shop = 1;
        $shop->save();
    
        return response()->json(['message' => 'Cập nhật is_shop thành công'], 200);
    }
}
