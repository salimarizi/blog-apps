<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Role;
use ResponseHelper;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ResponseHelper::success(Role::all());
        } catch (Exception $e) {
            return ResponseHelper::failed($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return ResponseHelper::failed("Data Not found", 404);
            } else {
                return ResponseHelper::success($role);
            }
        } catch (Exception $e) {
            return ResponseHelper::failed($e->getMessage(), 500);
        }
    }
}
