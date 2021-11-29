<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function index()
    {
        return UserPost::all();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $newPost = new UserPost();
        $newPost->name = $request->name;
        $newPost->description = $request->description;
        $newPost->Save();
    }


    public function show(UserPost $userPost)
    {
        //
    }


    public function edit(UserPost $userPost)
    {
        //
    }

    public function update(Request $request, UserPost $userPost)
    {
        //
    }

    public function destroy(UserPost $userPost)
    {
        //
    }
}
