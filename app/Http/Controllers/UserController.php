<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use ResponseHelper;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ResponseHelper::success(User::all());
        } catch (Exception $e) {
            return ResponseHelper::failed($e, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                UserRequest::rules("POST")
            );

            if ($validator->fails()) {
                return ResponseHelper::failed(
                    $validator->errors()->all(),
                    400
                );
            } else {
                DB::beginTransaction();
                $data = $request->all();
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return ResponseHelper::failed("Data Not found", 404);
            } else {
                $user->role = $user->role;
                return ResponseHelper::success($user);
            }
        } catch (Exception $e) {
            return ResponseHelper::failed($e, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return ResponseHelper::failed("Data Not found", 404);
            }

            $validator = Validator::make(
                $request->all(),
                UserRequest::rules("PATCH")
            );

            if ($validator->fails()) {
                return ResponseHelper::failed($validator->errors()->all(), 400);
            } else {
                DB::beginTransaction();
                $data = $request->all();

                if ($request->has('password')) {
                    $data['password'] = bcrypt($data['password']);
                }
                
                $user = User::find($id)->update($data);

                DB::commit();
                return ResponseHelper::success(User::find($id));
            }
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return ResponseHelper::failed("Data Not found", 404);
            }
            DB::beginTransaction();

            User::find($id)->delete();

            DB::commit();
            return ResponseHelper::success("Successfully delete data");
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed($e, 500);
        }
    }
}
