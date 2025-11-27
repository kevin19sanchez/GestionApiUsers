<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return response()->json(
            User::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $createuser = new User;
        $createuser->name = $request->name;
        $createuser->email = $request->email;
        $createuser->password = Hash::make($request->password);

        $createuser->save();

        return response()->json($createuser, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        $updateuser = User::findOrFail($id);
        $updateuser->name = $request->filled('name') ? $request->name : $updateuser->name;
        $updateuser->email = $request->filled('email') ? $request->email : $updateuser->email;

        if ($request->filled('password')) {
            $updateuser->password = Hash::make($request->password);
        }

        $updateuser->save();

        return response()->json($updateuser);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userdelete = User::findOrFail($id);
        $userdelete->delete();
        return response()->json(null, 204);
    }
}
