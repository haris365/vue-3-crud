<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Like;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->comment);
        Comment::create([

            'body'    => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);
    }

    public function replyStore(Request $request,$id)
    {
      
       Reply::create([
           'reply' => $request->reply,
           'post_id' => $id,
           'user_id' => auth()->user()->id,
           'comment_id' => $request->comment_id,
           
       ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function like(Request $request, $id)
    {
        
        $auth = auth()->user();
        
        $exist = Like::where('user_id',$auth->id)->where('post_id',$id)->first();
       
        if($exist)
        {
            
            $exist->delete(); 
            return response()->json('The unlike successfully added');
  

        }else{
            
            $post = Post::findOrFail($id);
         
            $like = new Like;
            $like->like = 1;
            $like->user_id = $auth->id;
    
            $post = $post->likes()->save($like);
            return response()->json('The like successfully added');

    

        }
       
       


    }
}
