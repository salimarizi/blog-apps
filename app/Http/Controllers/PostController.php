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
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $currentUser = $request->user();

            if (
                !(
                    $currentUser->tokenCan('crud:all_posts')
                    ||
                    $currentUser->tokenCan('crud:own_posts')
                )
            ) {
                ResponseHelper::failed("Don't have to access the data", 401);
            }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $currentUser = $request->user();
            $posts = $currentUser->tokenCan('crud:all_posts') ?
                Post::all()
                :
                Post::where('user_id', $currentUser->id)->get();

            return ResponseHelper::success($posts);
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
    public function show(Request $request, string $id)
    {
        try {
            $currentUser = $request->user();
            $post = $currentUser->tokenCan('crud:all_posts') ?
                Post::find($id)
                :
                Post::where('id', $id)
                ->where('user_id', $currentUser->id)
                ->get();

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
            $currentUser = $request->user();
            $post = $currentUser->tokenCan('crud:all_posts') ?
                    Post::find($id)
                    :
                    Post::where('id', $id)
                        ->where('user_id', $currentUser->id)
                        ->get();

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
    public function destroy(Request $request, string $id)
    {
        try {
            $currentUser = $request->user();
            $post = $currentUser->tokenCan('crud:all_posts') ?
                    Post::find($id)
                    :
                    Post::where('id', $id)
                        ->where('user_id', $currentUser->id)
                        ->get();

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
