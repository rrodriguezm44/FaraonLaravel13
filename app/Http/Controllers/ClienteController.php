<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
      public function index()
    {
        $clientes = Cliente::all();
        return view('sistema.cliente.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'telefono' => 'required|integer|min:8',
                'direccion' => 'required|string',
                'genero' => 'required|in:M,F',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8'
            ], [
                'email.unique' => 'El correo ya esta registrado',
            ]);

            $user = User::create([
                'name' => $request->nombre . ' ' . $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'genero' => $request->genero,
                'user_id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Creado con exito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $cliente = Cliente::findOrFail($id);
        $user = User::findOrFail($cliente->user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no existe');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|integer|min:8',
            'direccion' => 'required|string',
            'genero' => 'required|in:M,F',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|confirmed|min:8'
        ]);


        if($request->password){
            $user->password = $request->password;
        }

        $user->name = $request->nombre . ' ' . $request->apellido;
        $user->email = $request->email;
        $user->save();

        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->genero = $request->genero;
        $cliente->save();

        return redirect()->back()->with('success', 'Actualizado con exito');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return redirect()->back()->with('success', 'Eliminado con exito');
    }

}
