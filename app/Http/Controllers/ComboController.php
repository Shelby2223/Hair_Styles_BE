<?php

namespace App\Http\Controllers;

use App\Models\combos;
use Illuminate\Http\Request;
use App\Models\shops;

class ComboController extends Controller
{
    public function index()
    {
        $combos= combos::all();
        return response()->json($combos);
    }
    public function get_combos_shop_id($shop_id)
    {
        $combos= combos::findOrFail($shop_id);
        return response()->json($combos);
    }

    public function show($combo_id)
    {
        $combo = combos::findOrFail($combo_id);
        return response()->json($combo_id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'combo_name' => 'required',
            'combo_image' => 'required',
            'combo_description' => 'required',
            "combo_price" => 'required',
            "shop_id" =>'required'
        ]);

        $combo = combos::create($validatedData);
        return response()->json($combo, 201);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'combo_name' => 'required',
            'combo_image' => 'required',
            'combo_description' => 'required',
            "combo_price" => 'required',
            "shop_id" =>'required'
        ]);

        $combo = combos::findOrFail($id);
        $combo->update($validatedData);
        return response()->json($combo);
    }

    public function destroy($id)
    {
        $combo = combos::findOrFail($id);
        $combo->delete();
        return response()->json('Shop deleted successfully');
    }
}
