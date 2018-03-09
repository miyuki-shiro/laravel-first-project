<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        //$users = DB::table('users')->get();   constructor de consultas -> coleccion de objetos
        $users = User::all();   //eloquent -> genera una coleccion de instancias de la clase User
        
        $title = 'Listado de usuarios';

        return view('users.index', compact('title', 'users'));


        /*return view('users.index')
            ->with('users', User::all())
            ->with('title', 'Listado de usuarios');*/
    }

    public function show(User $user)
    {
        /*$user = User::find($id);

        if ($user == null) { return response()->view('errors.404', [], 404); }*/

        //$user = User::findOrFail($id);  //ModelNotFound -> respuesta de tipo 404

        return view('users.show', compact('user'));
              
    }

    public function create()
    {
        //return 'Crear nuevo usuario';
        return view('users.create');
    }

    public function store()
    {
        //$data = request()->all();

        /*if (empty($data['name'])) { 
            return redirect('/usuarios/nuevo')->withErrors([
                'name' => 'El campo nombre es obligatorio'
            ]); 
        } --> para validar si el campo nombre esta vacio, pero es muy engorroso asi*/

        //return redirect('/usuarios/nuevo')->withInput();

        $data = request()->validate([
            'name' => 'required',
            //'email' => 'required|email', //asi indicas que es obligatorio y que sea válido
            'email' => ['required', 'email', 'unique:users,email'],  //o tambien asi lo puedes hacer
            'password' => ['required', 'min:6']
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email está en uso y debe ser único',
            'password.required' => 'El campo password es obligatorio',
            'password.min' => 'La contraseña debe contener más de 6 caracteres'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            //'email' => ['required', 'email', 'unique:users,email,'.$user->id]
            'email' => ['required', 'email', Rule::unique('users','email')->ignore($user->id)],
            'password' => ''
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email está en uso y debe ser único'
        ]);
        
        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        
        //return redirect("/usuarios/{$user->id}");
        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
