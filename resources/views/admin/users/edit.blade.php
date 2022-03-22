@extends('layouts.dashboards')

@section('content')
    <h1>IL TUO PROFILO</h1>
    <form action="{{route("admin.users.update" , $user->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="form-group">
        <label for="name">Username</label>
        <input value="{{old("name") ? old("name") : $user->name}}" type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" placeholder="titolo">
        @error('name')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    <div class="d-flex form-group">
        @if($user->avatar)
            <div class="edit-avatar-box avatar-box">
                <img src="{{ asset("storage/".Auth::user()->avatar) }}" alt="">
                <input type="file" name="avatar" class="change-avatar w-100 h-100 p-1 form-control @error('avatar') is-invalid @enderror ">
            </div>
        @else
            <h1 class="w-100">CARICA UN AVATAR</h1>    
            <input type="file" name="avatar" class="w-70 p-1 form-control @error('avatar') is-invalid @enderror ">
        @endif
    </div>
    @error('avatar')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    
    <button type="submit" class="btn btn-primary">Modifica</button>
    </form>
    <a href="/">
        <h3 class="mt-2">Torna alla home</h3>
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

<style>
.change-avatar{
    cursor: pointer;
    opacity: 0;
}

.edit-avatar-box{
    margin: 0 auto;
    border: 2px outset blue;
}
</style>