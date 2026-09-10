<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpleadoRequest;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('sistema.empleado.index', compact('empleados'));
    }

    public function store(StoreEmpleadoRequest $request)
    {
        try {
            
            //inicializar transacciones
            DB::beginTransaction();

            try {
                $user = User::create([
                    'name' => $request['nombre'] . ' ' . $request['apellido'],
                    'email' => $request['correo'],
                    'password' => Hash::make($request['password']),
                ]);

                Empleado::create([
                    'nombre' => $request['nombre'],
                    'apellido' => $request['apellido'],
                    'direccion' => $request['direccion'],
                    'calificacion' => $request['calificacion'],
                    'genero' => $request['genero'],
                    'estado' => true,
                    'user_id' => $user->id,
                ]);

                DB::commit(); //confirmamos todos los cambios
            }catch (\Exception $th) {
                //si hay un error, revertir la transacción
                DB::rollBack();
                throw $th;

            }

            return redirect()->back()->with('success', 'Empleado creado exitosamente.');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error al crear el empleado.'. $e->getMessage());
        }


    }

    public function destroy($id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            $user = User::findOrFail($empleado->user_id);

            //inicializar transacciones
            DB::beginTransaction();

            try {
                // Eliminar el empleado
                $empleado->delete();

                // Eliminar el usuario asociado
                if ($user) {
                    $user->delete();
                }

                DB::commit(); //confirmamos todos los cambios
            } catch (\Exception $th) {
                //si hay un error, revertir la transacción
                DB::rollBack();
                throw $th;
            }

            return redirect()->back()->with('success', 'Empleado eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }
}
