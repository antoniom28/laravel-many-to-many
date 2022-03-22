@extends('layouts.dashboards')

@section('content')
<?php
    use App\User;
?>
<h1>
    <a class="d-inline-block" href="{{route("admin.posts.index")}}">Torna ai post</a>
</h1>
@foreach ($posts as $post)
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
    </div>
    </div>
</div>
@endforeach
@endsection