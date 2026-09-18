<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permission::all();
        return view('sistema.seguridad.permisos.index', compact('permisos'));
    }

    public function store(Request $request)
    {
        
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name',
            ]);

            $permiso = Permission::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true, 
                'id' => $permiso->id,
                'name' => $permiso->name,
            ]);

            //return redirect()->route('permisos.index')->with('success', 'Permiso creado exitosamente.');

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el permiso: ' . $e->getMessage(),
            ]);
        }
        
    }

    public function destroy($id)
    {
        try {
            $permiso = Permission::findOrFail($id);
            $permiso->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permiso eliminado exitosamente.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el permiso: ' . $e->getMessage(),
            ]);
        }
    }
}