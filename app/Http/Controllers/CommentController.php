<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests;
use App\Http\Resources\Comment as CommentResource;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($photo_id, Request $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'photo_id' =>  $photo_id,
            'body' => $request->comment,
        ]);

        return new CommentResource($comment);
    }

    /**
     * Delete the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = Comment::find($id);

        //$this->authorize('view', $entry);

        $entry->delete();

        return response()->json([
            'success' => 'true',
        ]);
    }
}
