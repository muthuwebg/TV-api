<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Plan;
use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class Payment extends Controller
{
    public function index(Request $request)
    {

    	$data = [];
    	$data['plans'] = Plan::where('name_short', strtoupper($request['product']))->get();

    	return response()->json([
            'data' => $data,
        ], 200);
    }

    public function generateOrder(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'planId'     => 'required',
            'paymentStatus'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
            'error' => 'The Given Input is not Correct.'
            ], 400);
         }

    	$data = [];
    	
		$expiry = Carbon::now();
        $expiry->addDays($order->plan_id == 1 ? 1 : 2);
        $expiry = $newExpiry->format('Y-m-d');
		
		Order::create([
            'user_id' => $request->auth->id,
            'plan_id' => $request->get("planId"),
            'expiry_date' => $expiry,
            'is_active' => 1,
        ]);

		$data['orderStatus'] = true;
		$data['payment'] = "success";

    	return response()->json([
            'data' => $data,
        ], 200);
    }
}
