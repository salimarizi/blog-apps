<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use ResponseHelper;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ResponseHelper::success(Post::all());
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
                PostRequest::rules("POST")
            );

            if ($validator->fails()) {
                return ResponseHelper::failed(
                    $validator->errors()->all(),
                    400
                );
            } else {
                DB::beginTransaction();
                $post = Post::create($request->all());

                DB::commit();
                return ResponseHelper::success($post);
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
            $post = Post::find($id);
            if (!$post) {
                return ResponseHelper::failed("Data Not found", 404);
            } else {
                $post->creator = $post->creator;
                return ResponseHelper::success($post);
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
            $post = Post::find($id);
            if (!$post) {
                return ResponseHelper::failed("Data Not found", 404);
            }

            $validator = Validator::make(
                $request->all(),
                PostRequest::rules("PATCH")
            );

            if ($validator->fails()) {
                return ResponseHelper::failed($validator->errors()->all(), 400);
            } else {
                DB::beginTransaction();
                $post = Post::find($id)->update($request->all());

                DB::commit();
                return ResponseHelper::success(Post::find($id));
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
            $post = Post::find($id);
            if (!$post) {
                return ResponseHelper::failed("Data Not found", 404);
            }
            DB::beginTransaction();

            Post::find($id)->delete();

            DB::commit();
            return ResponseHelper::success("Successfully delete data");
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed($e, 500);
        }
    }
}
