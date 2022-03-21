@extends('layouts.dashboards')

@section('content')
    <h1>Modifica il tuo post!</h1>
    <form action="{{route("admin.posts.update" , $post->id)}}" method="POST">
        @csrf
        @method('PUT')
    <div class="form-group">
        <label for="title">Titolo</label>
        <input value="{{old("title") ? old("title") : $post->title}}" type="text" class="form-control @error('title') is-invalid @enderror " id="title" name="title" placeholder="titolo">
        @error('title')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="content">Contenuto</label>
        <div class="form-floating">
            <textarea class="form-control" id="content" name="content" placeholder="Descrizione" style="height: 100px">{{old("content") ? old("content") : $post->content}}</textarea>
        </div>
        @error('content')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="published">Pubblicare alla creazione ? </label>
        SI <input {{(old("published")== "yes"||$post->content == "yes") ? "checked" : ""}} value="yes" type="radio" name="published" id="published">
        NO <input {{(old("published")== "no"||$post->content == "no") ? "checked" : ""}} value="no" type="radio" name="published" id="published">
        @error('published')
        <div class="alert alert-danger">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="tag">Tag (#iltuotag , senza # non verranno presi)</label>
        <div class="form-floating">
            <textarea class="form-control" id="tag" name="tag" placeholder="tag" style="height: 50px">@foreach ($post->tags as $tag)#{{$tag->name}}@endforeach</textarea>
        </div>
        @error('tag')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>


    <div class="form-group">
        <label for="category_id">Categoria</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text" for="category_id">Categoria</label>
            </div>
            <select class="custom-select" id="category_id" name="category_id">
              <option value="{{null}}">scegli..</option>
              @foreach ($categories as $category)
                <option value="{{$category->id}}" {{((old("category_id")??$post->category_id) == $category->id) ? "selected" : ""}}>{{$category->name}}</option>
              @endforeach
            </select>
          </div>
          @error('category_id')
              <div class="alert alert-danger">
                  {{$message}}
              </div>
          @enderror
    </div>

    <button type="submit" class="btn btn-primary">Modifica</button>
    </form>
    <a href="/admin/posts">
        <h3 class="mt-2">Torna ai post</h3>
    </a>
    
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection