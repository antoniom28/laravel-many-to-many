<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\User;
use App\Tag;
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $validation = [
        "title" => "string|min:10",
        "content" => "required",
        "published" => "required",
        "category_id" => "required",
    ];

    protected function create_slug($value , $id){
        $slug = Str::slug($value);
        $count = 1;
        while(Post::whereSlug($slug)->where('id' , '!=' , $id)->first()){
            $slug = Str::slug($value)."-".$count;
            $count++;
        }
        //Str::of($data["title"])->slug("-")
        return $slug;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        $users = User::all();
        $tags = Tag::all();
        return view('admin.posts.index' , compact('posts' ,'tags' , 'categories', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create' , compact('categories' , 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation);
        $data = $request->all();

        $new_post = new Post();
        if(isset($data['image'])){
            $path = Storage::put('uploads' , $data['image']);
            $new_post->image = $path;
        }

        if($data["published"] == 'yes')
            $new_post->published = true;

        $new_post->slug = $this->create_slug($data["title"], null);
        $new_post->user_id = Auth::user()->id;

        //$test = "#gluten free #vegan";
        $tag_control = explode('#' , $data['tag']);
        $tag_to_pass = [];
        foreach($tag_control as $control){
            $temp = Tag::where('name' , $control)->first();
            if($temp != null)
                $tag_to_pass[] = $temp->id;
        }
        $tag_to_pass = array_diff($tag_to_pass, array(null));
        $new_post->fill($data);
        $new_post->save();

        $new_post->tags()->sync($tag_to_pass);
        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show' , compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit' , compact('post','categories'));
        //compact restituisce 'post' => $post , 'categories' => $categories
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validation);

        $data = $request->all();
        
        if($post->title != $data["title"])
            $post->slug = $this->create_slug($data["title"], $post->id);
        if($data["published"] == 'yes')
            $post->published = true;
        else
            $post->published = false;

        $post->fill($data);
        $post->save();

        return redirect()->route('admin.posts.show' , $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with(['mes'=>'cancellato']);
    }
}
