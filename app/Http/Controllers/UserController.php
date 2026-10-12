<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
        public function index()
    {
        $usuarios = User::with('roles')->latest()->get();
        $roles = Role::all();
        return view('sistema.usuarios.index', compact('usuarios', 'roles'));
    }

    public function crear(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,name',
            ], [
                'email.unique' => 'Correo ya se encuentra registrado',
                'roles.required' => 'Debe seleccionar al menos un rol',
                'roles.min' => 'Debe seleccionar al menos un rol'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Asignar múltiples roles
            $user->assignRole($request->roles);

            $totalUsers = User::count();

            return redirect()->back()->with('success', 'Usuario creado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error ' . $e->getMessage());
        }
    }

    public function actualizar(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|confirmed|min:8',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ], [
            'roles.required' => 'Debe seleccionar al menos un rol',
            'roles.min' => 'Debe seleccionar al menos un rol'
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Sincronizar roles
        $user->syncRoles($request->roles);

        return redirect()->back()->with('success', 'Actualizado con éxito');
    }

    public function eliminar($id)
    {
        $usuario = User::findOrFail($id);

        $cliente = Cliente::where('user_id', $usuario->id)->first();
        if ($cliente) {
            $cliente->delete();
        }
        $empleado = Empleado::where('user_id', $usuario->id)->first();
        if ($empleado) {
            $empleado->delete();
        }

        $usuario->delete();
        return redirect()->back()->with('success', 'Eliminado con éxito');
    }
}

