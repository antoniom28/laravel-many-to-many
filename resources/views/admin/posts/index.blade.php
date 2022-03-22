@extends('layouts.dashboards')

@section('content')
    <?php
        use App\User;
        if(isset($_GET['user']))
            $menu = false;
        else
            $menu = true;

        if(isset($_GET['category_id'])){
            $filter_category = $_GET['category_id'];
            if(is_numeric($filter_category ))
                if($filter_category >=0 && $filter_category < count($categories))
                    true;
                else
                    $filter_category = null;
                else
                    $filter_category = null;
        }
        else
            $filter_category = null;
    ?>

    <div class="text-center d-flex flex-column">
        @if ($menu)
            <h1>
                <a class="d-inline-block" href="/">Torna in home</a>
            </h1>
            <h1>
                <a class="d-inline-block" href="{{route("admin.posts.index" , ["user" => true])}}">
                    I tuoi Post
                </a>
            </h1>
    </div>
            <div class="mt-3 create">
                <h2 class="mt-0"><a href="{{route("admin.posts.create")}}">Nuovo Post</a></h2>
                <form class="filter d-flex" action="">
                    <div class="form-group m-0 mr-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="category_id">Categoria</label>
                            </div>
                            <select class="custom-select" id="category_id" name="category_id">
                              <option value="{{null}}">scegli..</option>
                              @foreach ($categories as $key => $category)
                                <option value="{{$key}}" {{(old("category_id") == $category->id) ? "selected" : ""}}>{{$category->name}}</option>
                              @endforeach
                            </select>
                          </div>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Filtra</button>
                </form>
            </div>
        @else
            <h1>
                <a class="d-inline-block" href="{{route("admin.posts.index")}}">Torna ai post</a>
            </h1>
        @endif
        
    
    
        <?php
        if(isset($_GET['user']))
            $published = Auth::user()->posts;
        else
            $published = $posts;
        ?>

    @foreach ($filter_category != null ? $categories[$filter_category]->posts : $published as $post)

            <div class="flex-row my-4 card">
                <div class="image-card">
                @if($post->image)
                    <img style="" src="{{asset('storage/'.$post->image)}}" alt="">
                @else
                    <div class="text-center h-100 d-flex align-items-center justify-content-center">
                        <h2 class="w-75 text-white"> {{$post->title}} </h2>
                    </div>
                @endif
                </div>
                <div style="{{!$post->image ? 'margin:0 auto;' : ''}}" class="text-card">
                    <div class="title">
                        <h1> {{$post->title}} </h1>
                    </div>
                <div class="all-content">
                    <p> {{$post->content}} </p>
               
                <p> <strong>Slug</strong>: {{$post->slug}} </p>
                @if($post->category != null)
                    <p> Category : {{$post->category->name}} </p> 
                @else
                    <p> Category : --- </p>
                @endif

                @foreach ($post->tags as $tag)
                    <span><a href="{{route('admin.tags.show' , $tag->id)}}">#{{$tag->name}}</a></span>
                @endforeach

                <br><br>

                <span> Creato il : {{$post->created_at}}</span>
                <?php
                    $user_post_name = User::all()->where('id',$post->user_id)->first();
                ?>
                <br>
                @if($user_post_name)
                    <span> da : {{$user_post_name->name == Auth::user()->name ? "Te" : $user_post_name->name}}</span>
                @else
                    <span> da : utente sconosciuto</span>
                @endif
                
                @if(!$post->published)
                    <h1>questo non è pubblico</h1>
                @endif
                <br><br>

                <div>
                    <a href="{{route('admin.posts.show' , $post->slug)}}">
                        VISUALIZZA
                    </a>
                </div>

                @if(!$menu)
                    <div>
                        <a href="{{route('admin.posts.edit' , $post->id)}}">
                            MODIFICA
                        </a>
                    </div>

            
                    <form class="confirm-delete" method="POST" action="{{route('admin.posts.destroy' , $post->id)}}">
                        @csrf
                        @method("DELETE")

                        <div class="button-choice">
                            <a href="">
                                <button class="p-0 yes-btn" type="submit" value="cancella">CANCELLA</button>
                            </a>
                        </div>
                    </form> 
                @endif
                </div>
                </div>
            </div>
    @endforeach
@endsection