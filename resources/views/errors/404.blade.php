@extends('layout')

@section('title', "Página no encontrada")

@section('content')

    <h1>Página no encontrada</h1>
    <p><a href="{{ route('users.index') }}">Regresar a la página principal</a></p>

@endsection