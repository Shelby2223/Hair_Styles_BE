<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TamController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }


    public function getUsersId($users_id)
    {
        $users = User::findOrFail($users_id);
        return response()->json($users);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_name' => 'required',
            'user_phone' => 'required',
            'user_email' => 'required',
            'user_address' => 'required',
            'user_password' => 'required',
        ]);

        $users = User::findOrFail($id);
        $users->update($validatedData);
        return response()->json($users);
    }

    
    public function getIsUser()
    {
        $users = User::where('is_user', 1)->get();
        return response()->json($users);
    }
}
