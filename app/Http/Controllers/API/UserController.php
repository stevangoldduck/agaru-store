<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserTopUpHistory;
use App\Order;

class UserController extends Controller
{
    protected $successStatus = 200;

    public function profile(Request $request)
    {
        $user = User::where('api_token',$request->api_token)->first();

        return response()->json($user, $this->successStatus);
    }

    public function topUpHistory(Request $request)
    {
        $user = User::where('api_token',$request->api_token)->first();
        if(empty($user))
            return response()->json(['message' => 'Unauthorised'], 401);

        $userTopUpHistory = UserTopUpHistory::where('user_id',$user->id)->get();

        return response()->json($userTopUpHistory, $this->successStatus);
    }

    public function topup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'api_token' => 'required',
        ],
        [
            'api_token' => 'Token expired or invalid, please re-login'
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), $this->successStatus);

        $user = User::where('api_token',$request->api_token)->first();
        $user->balance = $user->balance + $request->amount;
        $user->save();

        $data = [];
        $data['success'] = true;
        $data['message'] = 'Rp. '.$request->amount.' added to your account';

        UserTopUpHistory::create(['user_id' => $user->id, 'amount' => $request->amount]);


        return response()->json($data, $this->successStatus);
    }

    public function getCart(Request $request)
    {
        $user = User::where('api_token',$request->api_token)->first();
        if(empty($user))
            return response()->json(['message' => 'Unauthorised'], 401);

        $order = Order::where('user_id',$user->id)->where('status','cart')->with(['details'])->first();
        return response()->json($order, 200);
    }
}
