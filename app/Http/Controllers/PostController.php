<?php

namespace App\Http\Controllers;

use App\Events\PostCreateEvent;
use App\Models\Post;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PostController extends Controller
{
    public function validator(Request $request): Validator
    {
        $data = $request->all();
        $rules = [
            'title' => 'required|max:255',
            'body' => 'required',
            'website_id' => 'required|int|exists:websites,id',
        ];

        return \Illuminate\Support\Facades\Validator::make($data, $rules);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();

        try {
            $post = Post::create($validatedData);
            event(new PostCreateEvent($post->website_id, $post->title, $post->body));
        }catch(\Exception $exception) {
            Log::debug($exception->getMessage());

            return response()->json(['message' => 'problem to create post'], 500);
        }

        $response = [
            '_response_status' => [
                "data" => $post,
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "post created successfully!",
                "query_time" => Carbon::now(),
            ]
        ];

        return response()->json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Post $post
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();
        $post->fill($validatedData);
        $post->save();
        $response = [
            '_response_status' => [
                "data" => $post,
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Post successfully updated",
                "query_time" => Carbon::now(),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


}
