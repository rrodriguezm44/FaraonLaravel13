<?php

use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
//use Illuminate\Database\Schema\IndexDefinition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root']);

/*
    GET     =   LISTAR
    POST    =   INSERTAR
    PUT     =   ACTUALIZAR
    DELETE  =   ELIMINAR

    CRUD CREATE READ UPDATE DELETE
*/

Route::get('/categorias', [CategoriaController::class, 'index'])->name('lista_categoria');
Route::post('/categoria/crear', [CategoriaController::class, 'store'])->name('crear_categoria');
Route::delete('/categoria/eliminar/{id}', [CategoriaController::class, 'destroy'])->name('eliminar_categoria');
Route::put('/categoria/editar/{id}', [CategoriaController::class, 'update']);

//SERVICIOS

Route::get('/servicios', [ServicioController::class, 'index'])->name('lista_servicios');
Route::post('/servicio/crear', [ServicioController::class, 'crear_servicio'])->name('crear_servicio');
Route::delete('/servicio/eliminar/{id}', [ServicioController::class, 'eliminar'])->name('eliminar_servicio');

///EMPLEADOS

Route::controller(EmpleadoController::class)->middleware('auth')->group(function(){
    Route::get('/empleados', 'index')->name('listar_empleado');
    Route::post('/empleado/crear', 'store')->name('crear_empleado');
    Route::delete('/empleado/eliminar/{id}', 'destroy')->name('eliminar_empleado');
});

//clientes
Route::controller(ClienteController::class)->prefix('cliente')->middleware('auth')->group(function(){
    Route::get('/', 'index')->name('cliente.index');
    Route::post('/store', 'store')->name('cliente.store');
    Route::put('/editar/{id}', 'update');
    Route::delete('/eliminar/{id}', 'destroy');
});


//PERMISOS
Route::resource('/permisos', PermisoController::class)->names('permisos');
//index, create, store, show, edit, update, destroy


//ROLES
Route::resource('roles', RoleController::class)->names('roles');

//USUARIOS
Route::controller(UserController::class)->middleware('auth')->group(function(){
    Route::get('/usuarios', 'index')->name('usuarios.index');
    Route::post('/usuarios/crear', 'crear')->name('usuarios.store');
    Route::put('/usuarios/actualizar/{id}', 'actualizar');
    Route::delete('/servicio/eliminar/{id}', 'eliminar');
});

//ASIGNACIONES
Route::get('/asignaciones',[AsignacionController::class,'index'])->name('asignacion.index');
Route::get('/asignaciones/empleado/{Id}', [AsignacionController::class, 'datos_empleados'])->name('asignacion.datos');
Route::post('/asignaciones/empleado/{id}/servicios', [AsignacionController::class, 'guardar_servicios']);


Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index']);
//Language Translation

Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::post('/formsubmit', [App\Http\Controllers\HomeController::class, 'FormSubmit'])->name('FormSubmit');

