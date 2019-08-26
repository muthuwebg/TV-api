<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $emailCheck = Test::where('email', $request['email'])->get();
        $data['emailCheck'] = false;
        $data['isLoggedIn'] = false;
        if (count($emailCheck) <= 0) {
            $data['emailCheck'] = true;
            Test::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'is_active' => 1,
            ]);
            $validUser = Test::where('email', $request['email'])->get();
            $data["user"] = $validUser[0];
            $data['isLoggedIn'] = true;
        }
        
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = [];
        $data['isLoggedIn'] = false;
        $data['emailMatch'] = false;
        $validUser = Test::where('email', $request['email'])->get();
        if (count($validUser) > 0) {
            $data['emailMatch'] = true;
            $data["user"] = $validUser[0];
            if (Hash::check($request['password'], $validUser[0]['password'])) {
                $data['isLoggedIn'] = true;
            }
        }
        return response()->json([
            'success'=>true,
            'data'=>$data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
