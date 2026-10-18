<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Empleado;
use App\Models\Servicio;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la lista de asignaciones
        $empleados = Empleado::all(); // Obtener todos los empleados
        $servicios = Servicio::all();
        return view('sistema.asignacion.index', compact('empleados', 'servicios'));
    }

    public function datos_empleados($id)
    {
       try{
           $empleado = Empleado::findOrFail($id);

           $servicios_asignados = Asignacion::where('empleado_id', $id)
           ->pluck('servicio_id')
           ->toArray();

           return response()->json([
               'empleado' => $empleado,
               'servicios_asignados' => $servicios_asignados
           ]);

       } catch (\Exception $e) {
           return response()->json([
            'error' => $e->getMessage(),
            'servicios_asignados' => [],
            ], 200);
       }
    }

    public function guardar_servicios(Request $request, $id)
    {
        try {
            // Validar que el empleado exista
            $empleado = Empleado::findOrFail($id);

            // Obtener los servicios seleccionados del request
            $servicios = $request->input('servicios', []);

            // Eliminar las asignaciones existentes para el empleado
            Asignacion::where('empleado_id', $id)->delete();

            // Crear nuevas asignaciones para los servicios seleccionados
            foreach ($servicios as $servicio_id) {
                Asignacion::create([
                    'empleado_id' => $id,
                    'servicio_id' => $servicio_id,
                    'estado' => true,
                ]);
            }

            return response()->json(['message' => 'Servicios asignados correctamente.'], 200);
 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al asignar servicios: ' . $e->getMessage()], 500);
        }
    }
}
