<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Member;
use App\Models\WaNotif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $member = Member::where('email', $credentials['email'])->first();
        if ($member) {
            if (Hash::check($credentials['password'], $member->password)) {
                $token = $member->createToken('token-name')->plainTextToken;
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'token' => $token,
                    'member' => $member,
                    'message' => 'Login success'
                ]);
            }else{
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Password not match'
                ], 401);
            }
        }else{
            return response()->json([
                'code' => 401,
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $password = Helper::passwordGenerator(8);
        $member = new Member();
        $member->username = $request->username;
        $member->email = $request->email;
        $member->password = Hash::make($password);
        $member->phone = $request->phone;
        $member->address = 'not set';
        $member->point = 0;
        $member->status = 'active';
        $member->save();

        /** request whatsapp api */
        $notifWa = WaNotif::where('type', 'register')->first();
        
        $message = Helper::replacer($notifWa->message, ['password' => $password , 'email' => $request->email , 'username' => $request->username , 'name' => $request->username]);
        $response = Helper::sendWhatsappMessage($request->phone,$message);
        

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Register success',
            'wa_response' => $response
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $member = Member::where('email', $request->email)->first();
        if ($member) {
            $member->password = Hash::make($request->password);
            $member->save();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Password updated'
            ]);
        }else{
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Email not found'
            ], 404);
        }
    }

    
}
