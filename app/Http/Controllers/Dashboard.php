<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Plan;
use App\Order;
use Illuminate\Support\Facades\Log;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user, Plan $plan)
    {
        $data = [];
        $data['plans'] = Plan::where('is_active', 1)->get();
        $data['subscribedCount'] = $request->auth->hasSubscribed();
        
        if ($data['subscribedCount'] > 0) {
            // $data['subscribedPlans'] = $request->auth->getSubscribedPlans($request->auth->id);
            $data['subscribedPlans'] = Order::join("users", "orders.user_id", '=', 'users.id')
                                ->join("plans", "orders.plan_id", '=', 'plans.id')
                                ->where("orders.is_active", 1)
                                ->where("orders.user_id", $request->auth->id)
                                ->select("plans.name", "plans.description", 'orders.expiry_date')
                                ->get();
        }
        Log::info('Showing user profile for user:');
        return response()->json([
            'data' => $data,
        ], 200);
        // $isSubscribed = $user->hasSubscribed();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        //
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
