@extends('layout')

@section('title', "Editar usuario")

@section('content')

    <div class="card">
        <h4 class="card-header">Editar usuario</h4>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h6>Por favor corriga los siguientes errores:</h6>
                    <ul>    
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ url("/usuarios/{$user->id}") }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
            
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" name="name" placeholder="Pedro Perez" 
                        value="{{ old('name', $user->name) }}">
                    @if ($errors->has('name')) <label>{{ $errors->first('name') }}</label> @endif 
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" name="email" placeholder="pedro@example.com" 
                        value="{{ old('email', $user->email) }}">
                    @if ($errors->has('email')) <label>{{ $errors->first('email') }}</label> @endif
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" name="password" placeholder="Mayor a 6 caracteres">
                    @if ($errors->has('password')) <label>{{ $errors->first('password') }}</label> @endif
                </div>
                <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar a la lista de usuarios</a>
            </form>
        </div>
    </div>


    

@endsection