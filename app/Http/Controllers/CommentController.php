<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store the comment in the DB.
     *
     * @param  Request $request
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Apartment $apartment)
    {
        $comment = new Comment();

        $comment->comment = $request->input('comment');
        $comment->user_id = Auth::user()->id;
        $comment->apartment_id = $apartment->id;

        $comment->save();

        return back()->with('success', "The comment is successfully submitted.");
    }
}
