<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'files' => 'required',
            'tags'=> 'required|min:1',
        ]);
  
        $post = Post::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ]);

        $tag = Tag::find($request->tags);
        $post->tags()->sync($tag);

        if($request->hasFile('files')){
            $files = $request->file('files');

            foreach ($files as $file) {

                
               
                $name = time()."-". $file->getClientOriginalName();
                  
                $path = $file->store('videos', ['disk' => 'public']);
                
                $post->videos()->create([
                    'post_id'=> $post->id,
                    'path'=> $path,
                    'name' => $name,
                ]);

            }
        }
        return response()->json('The post successfully added');
    }

    public function getPosts() {
        $data = [];
        $data['posts'] = Post::with('tags','videos','user')->get()->toArray();
        $data['user'] = auth()->user();
       
       
        return response()->json($data);

    }

    public function show($id)
    {   
        $data = [];
        $data['post'] = Post::with('tags','videos','comments','comments.user','comments.replies','user','comments.replies.user','likes','likes.user')->findorFail($id);   
       
        $data['user'] = auth()->user();
        $data['likes_count'] = $data['post']->likes->count();
        return response()->json($data);
    }

    public function edit($id)
    {
        $post = Post::with('tags','videos','comments')->findorFail($id);
        return response()->json($post);
    }

    public function update($id, Request $request)
    {      
        $post = Post::findorFail($id);
        $post->update([
            'name' => $request->name]);
        if($request->tags)
            $post->tags()->sync($request->tags);

        if($request->hasFile('files')){
                 
            foreach($post->videos as $video)
            {
              
                Storage::disk('public')->delete($video->path);
                $video->delete();
              
            }
          
            $files = $request->file('files');
           
            foreach ($files as $file) {
               
                $name = time()."-". $file->getClientOriginalName();               
                $path = $file->store('videos', ['disk' => 'public']);

                $post->videos()->create([
                    'post_id'=> $post->id,
                    'path'=> $path,
                    'name' => $name,
                ]);

            }
        }
       
        return response()->json('The post successfully updated');
    }

    public function delete($id)
    {
        $post = Post::findorFail($id);
        $post->delete();

        return response()->json('The post successfully deleted');
    }
}
