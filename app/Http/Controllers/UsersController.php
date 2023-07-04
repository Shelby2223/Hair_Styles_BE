<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
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
   
    public function getByIsUser()
    {
        $users = DB::table('users')->where('is_user', 1)->get();

        return response()->json($users);
    }
    public function deleteUser($user_id)
    {
       
        $user_id = User::where('user_id', $user_id)->first();

        if (!$user_id) {
            return response()->json(['status' => 'error', 'msg' => 'Product not found'], 404);
        }

        $user_id->delete();

        return response()->json(['status' => 'ok', 'msg' => 'Delete successful']);
    }

}
