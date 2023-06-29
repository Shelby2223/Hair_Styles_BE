<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        return response()->json($users_id);
    }
}
