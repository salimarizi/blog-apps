<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use ResponseHelper;

use App\Models\Role;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                UserRequest::registerRules()
            );

            if ($validator->fails()) {
                return ResponseHelper::failed(
                    $validator->errors()->all(),
                    400
                );
            } else {
                DB::beginTransaction();
                $data = $request->all();
                $data['role_id'] = Role::where('name', 'normal')->first()->id;
                $data['password'] = bcrypt($data['password']);
                $user = User::create($data);

                DB::commit();
                return ResponseHelper::success($user);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed($e, 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                UserRequest::loginRules()
            );

            if ($validator->fails()) {
                return ResponseHelper::failed(
                    $validator->errors()->all(),
                    400
                );
            } else {
                // TODO: Authenticate Email and Password
                $user = User::where('email', $request->email)->first();

                if (!Hash::check($request->password, $user->password)) {
                    return ResponseHelper::failed(
                        "Invalid credentials",
                        401
                    );
                }
                
                $user->role = $user->role;
                return ResponseHelper::success($user);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed($e, 500);
        }
    }
}
