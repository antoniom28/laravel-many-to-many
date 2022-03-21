@extends('layouts.dashboards')

@section('content')
    <h1>Crea un nuovo post!</h1>
    <form action="{{route("admin.posts.store")}}" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Titolo</label>
        <input value="{{old("title")}}" type="text" class="form-control @error('title') is-invalid @enderror " id="title" name="title" placeholder="titolo">
        @error('title')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="content">Contenuto</label>
        <div class="form-floating">
            <textarea class="form-control" id="content" name="content" placeholder="Descrizione" style="height: 100px">{{old('content')}}</textarea>
        </div>
        @error('content')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="p-1 form-control @error('image') is-invalid @enderror ">
    </div>
    @error('image')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror

    <div class="form-group">
        <label for="published">Pubblicare alla creazione ? </label>
        SI <input {{(old("published") == "yes") ? "checked" : ""}} value="yes" type="radio" name="published" id="published">
        NO <input {{(old("published") == "no") ? "checked" : ""}} value="no" type="radio" name="published" id="published">
        @error('published')
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
                <option value="{{$category->id}}" {{(old("category_id") == $category->id) ? "selected" : ""}}>{{$category->name}}</option>
              @endforeach
            </select>
          </div>
          @error('category_id')
              <div class="alert alert-danger">
                  {{$message}}
              </div>
          @enderror
    </div>

    <div class="form-group">
        <label for="tag">Tag (#iltuotag , senza # non verranno presi)</label>
        <div class="form-floating">
            <textarea class="form-control" id="tag" name="tag" placeholder="tag" style="height: 50px">{{old('tag')}}</textarea>
        </div>
        @error('tag')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">CREA</button>
    </form>
    <a href="/admin/posts">
        <h3 class="mt-2">Back to post</h3>
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