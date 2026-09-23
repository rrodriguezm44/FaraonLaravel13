<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        $permisos = Permission::orderBy('name')->get();
        return view('sistema.seguridad.roles.index', compact('roles', 'permisos'));
    }

    public function store(Request $request)
    {
       
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            $role = Role::create([
                'name' => $request->name,
            ]);

            if ($request->filled('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->back()->with('success', 'Rol creado exitosamente.');
    }
}
