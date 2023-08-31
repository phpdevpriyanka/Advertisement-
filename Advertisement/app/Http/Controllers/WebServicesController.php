<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebServicesController extends Controller
{
    public function register(Request $request)
    { {
            $response = array('status' => 0, 'message' => 'error', 'result' => 'error');
            if ($request->method() == 'POST') {
                if (empty($request->name)) {
                    return response()->json(array('status' => 0, 'message' => 'Name should not be blank', 'result' => 'error'));
                }
                if (empty($request->email)) {
                    return response()->json(array('status' => 0, 'message' => 'Email Id should not be blank', 'result' => 'error'));
                }
                if (empty($request->password)) {
                    return response()->json(array('status' => 0, 'message' => 'password should not be blank', 'result' => 'error'));
                }
                if (empty($request->user_type_id)) {
                    return response()->json(array('status' => 0, 'message' => 'user_type_id should not be blank', 'result' => 'error'));
                }
                if (!empty($request->email)) {
                    $email_exists = DB::table('users')->where('email', $request->email);
                    if ($email_exists->exists()) {
                        return response()->json(array('status' => 0, 'message' => 'Email Id already registered', 'result' => 'error'));
                    }
                }
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make(123456789);
                $user->user_type_id = $request->user_type_id;
                if ($user->save()) {
                    $response = array('status' => 1, 'message' => 'User Register successfully', 'result' => 'success');
                }
            } else {
                $response = array('status' => 0, 'message' => 'Method should be post', 'result' => 'error');
            }
            return response()->json($response);
        }
    }

    public function login(Request $request)
    {
        $response = array('status' => 0, 'message' => 'error', 'result' => 'error');
        if ($request->method() == 'POST') {
            $users = User::where('email', $request->email)->first();
            if ($users->exists()) {
                $users = $users->first();
                if (Hash::check($request->password, $users->password)) {
                    if ($users->update()) {
                        $data = array(
                            'name' => $users->name,
                            'email' => $users->email,
                            'password' => $users->password,
                        );
                        return response()->json(array('status' => 1, 'message' => 'success', 'result' => $data));
                    }
                } else {
                    $response = array('status' => 0, 'message' => 'Invalid password or username', 'result' => 'error');
                }
            } else {
                $response = array('status' => 0, 'message' => 'User doesnot exists', 'result' => 'error');
            }
        } else {
            $response = array('status' => 0, 'message' => 'Invalid method', 'result' => 'error');
        }
        return response()->json($response);
    }
}
