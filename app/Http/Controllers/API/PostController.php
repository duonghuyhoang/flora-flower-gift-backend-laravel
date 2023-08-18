<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class Postcontroller extends Controller
{

    protected $post;

    public function __construct(\App\Models\Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->post->paginate(5);

        $postResource =  PostResource::collection($posts);

        return response()->json([
            'data' => $postResource
        ], Response::HTTP_OK);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $dataCreate = $request->validated();
        $post = $this->post->create($dataCreate);
    
        $postResource = new PostResource($post);
        return response()->json([
            'data' => $postResource
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->post->findOrFail($id);
    
        $postResource = new PostResource($post);
    
        return response()->json([
            'data' => $postResource
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = $this->post->findOrFail($id);
        $post->update($request->all());
    
        $postResource = new PostResource($post);
        return response()->json([
            'data' => $postResource
        ], Response::HTTP_OK);
    }
    
    public function destroy(string $id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();
    
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}