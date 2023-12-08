<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all() ;

        if($user){
            return response()->json([
                'users' => $user,
            ], 200);
        }else{
            return response()->json([
                'message' => 'No user found',
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( )
    {
       
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|min:11|max:11|unique:users,phone',
            'gender' => 'required',
            'password' => 'required',

        ]);

        if($validation->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors(),
            ], 422);
        }else{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'image' => $request->image,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'User created successfully',
            ], 201);
        }
            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);



        if($user){
            return response()->json([
                'user' => $user,
            ], 200);
        }else{
            return response()->json([
                'message' => 'No user found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
          

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',

        ]);

        if($validation->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = User::find($id);



        if($user){

            $user->update([
                'name' => $request->name,
                'gender' => strtolower($request->gender),
                'image' => $request->image,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'User updated successfully',
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'No user found',
            ], 404);
        }   

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if($user){
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
        }else{
            return response()->json([
                'message' => 'No user found',
            ], 404);
        }

    }
}
