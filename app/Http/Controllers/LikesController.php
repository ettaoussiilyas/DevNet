<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\StoreLikesRequest;
use App\Http\Requests\UpdateLikesRequest;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLikesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $likes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $likes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLikesRequest $request, Like $likes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $likes)
    {
        //
    }
}
