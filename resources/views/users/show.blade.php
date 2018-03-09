@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')

    <div class="card">
        <h4 class="card-header">Usuario n°{{ $user->id }}</h4>
        <div class="card-body">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Nombre del usuario</label>
                <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" 
                        id="staticEmail" value="{{ $user->name }}">
                </div>
                <label for="staticEmail" class="col-sm-3 col-form-label">Correo electrónico</label>
                <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" 
                        id="staticEmail" value="{{ $user->email }}">
                </div>
                {{--<a href="{{ url('/usuarios') }}">Regresar a la lista de usuarios</a>
                <a href="{{ action('UserController@index') }}">Regresar</a>--}}
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar a la lista de usuarios</a>
        </div>
    </div>

@endsection