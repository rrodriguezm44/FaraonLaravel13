<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = \App\Models\Servicio::all();
        $categorias = \App\Models\Categoria::all();
        return view('sistema.servicio.index', compact('servicios', 'categorias'));
    }

    public function crear_servicio(Request $request)
    {
        try {
            //dd($request->all());
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion_minutos' => 'required|integer',
            'categoria' => 'required|exists:categorias,id',
            'descripcion' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ruta = '';
        if($request->hasFile('foto')){
            $ruta = $request->file('foto')->store('servicios', 'public');
        }

        $servicio = Servicio::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'duracion_minutos' => $request->duracion_minutos,
            'categoria_id' => $request->categoria,
            'descripcion' => $request->descripcion,
            'foto' => $ruta,
        ]);
       

        return redirect()->back()->with('success', 'Servicio creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el servicio: ' . $e->getMessage());   
        }
    }

    public function eliminar($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);

            if($servicio->foto && Storage::disk('public')->exists($servicio->foto)){
                Storage::disk('public')->delete($servicio->foto);
            }

            $servicio->delete();

            return redirect()->back()->with('success', 'Servicio eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el servicio: ' . $e->getMessage());
        }
    }
}
