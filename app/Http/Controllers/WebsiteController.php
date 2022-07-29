<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WebsiteController extends Controller
{

    public function userSubscription(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');
        $websiteId = $request->input('website_id');

        $website = Website::findOrFail($websiteId);
        $user = User::findOrFail($userId);

        $website->users()->attach($userId, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => $user->name . " successfully subscribed to ". $website->title . " website",
                "query_time" => Carbon::now(),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    public function validator(Request $request, int $id = null): Validator
    {
        $data = $request->all();
        $rules = [
            'title' => 'required|max:255',
        ];

        return \Illuminate\Support\Facades\Validator::make($data, $rules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();

        try {
            $website = Website::create($validatedData);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Website Successfully Created",
                    "query_time" => Carbon::now(),
                ]
            ];

            if (!$website) {
                return Response::json('Error occurred');
            }

            $response['data'] = $website;

            return Response::json($response, ResponseAlias::HTTP_CREATED);

        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Error occurred to create website",
                    "query_time" => Carbon::now(),
                ]
            ];

            return Response::json($response, ResponseAlias::HTTP_CREATED);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $website)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Website $website
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Website $website): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();
        $website->fill($validatedData);
        $website->save();
        $response = [
            '_response_status' => [
                "data" => $website,
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Website successfully updated",
                "query_time" => Carbon::now(),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website)
    {
        //
    }
}
