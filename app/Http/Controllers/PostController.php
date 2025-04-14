<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{



    public static function middleware(): array
    {
        return [
            
            // new Middleware('auth', only: ['store']),
            new Middleware('auth', except: ['index,show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


      
   $posts = Post::latest()->paginate(6); //Shortcut ways that can be used to fetch all posts from the database desc 
  
    //$posts = Post::orderBy('created_at','desc')->get(); // Fetch all posts from the database
     
        return view('posts.index',['posts'=>$posts]);
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
    public function store(Request $request)
    {

   
 
        //Validate 
  

        $fields=$request->validate([
        'title'=>['required','max:255'],
        'body'=>['required'],
        'image'=>['nullable','file','max:3000','mimes:png,jpg,webp']

        ]);

        //Store Images if Exists
          $path = null;
        if($request->hasFile('image')){
           $path = Storage::disk('public')->put('posts_images',
            $request->image);
        
        }
        else{
            $path = 'posts_images/default.jpg';
        }

     


        //Create a Post

    // Post::create(['user_id' => Auth::id(),...$fields]);
     
    $post = Auth::user()->posts()->create([
    'title' => $request->title,
    'body' => $request->body,
    'image' => $path,

    ]);


    //Send an Email

    Mail::to(Auth::user())->send(new WelcomeMail(Auth::user(),$post));



        //Redirect to Dashboard 
    return back()->with('success','Your post has been created');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

     //Authorizing Action

     Gate::authorize('modify',$post);

        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
      
        //Authorizing Action

        Gate::authorize('modify',$post);

        //Validate 
  

        $fields=$request->validate([
            'title'=>['required','max:255'],
            'body'=>['required'],
            'image'=>['nullable','file','max:3000','mimes:png,jpg,webp']
    
            ]);


              //Store Images if Exists
          $path =  $post->image ?? null;
          if($request->hasFile('image')){

            if($post->image){
                Storage::disk('public')->delete($post->image);
            }
             $path = Storage::disk('public')->put('posts_images',
              $request->image);
          
          }
    
    
            //Update a Post
    $post->update([
        'title' => $request->title,
        'body' => $request->body,
        'image' => $path,
        ]);
   
    
    
            //Redirect to Dashboard 
        return redirect()->route('dashboard')->with('success','Your post has been updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

     //Authorizing Action

     Gate::authorize('modify',$post);


     //Delete Post Images if Exists

     if($post->image){
        Storage::disk('public')->delete($post->image);
     }
    
     //Delete Post

     $post->delete();


     //Redirect back to Dashboard

    return back()->with('delete','Your post has been deleted');
    }
}
