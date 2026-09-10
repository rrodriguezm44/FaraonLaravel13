@extends('layouts.master')
@section('title')
    @lang('translation.Datatables')
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Tables
        @endslot
        @slot('title')
            Datatables
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="card-title">Lista Empleados</h4>
                            <p class="card-title-desc">Administra tus empleados: <code>crear, actualiza, lista y
                                    eliminar</code>.
                        </div>
                        </p>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">Crear
                            empleado</button>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Direccion</th>
                                <th>Calificacion</th>
                                <th>Genero</th>
                                <th>Email</th>
                                <th>Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $index => $empleado)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->apellido }}</td>
                                    <td>{{ $empleado->direccion }}</td>
                                    <td>{{ $empleado->calificacion }}</td>
                                    <td>{{ $empleado->genero }}</td>
                                    <td>{{ $empleado->user?->email }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn-eliminar_empleado"
                                            data-id="{{ $empleado->id }}">
                                            <i class="uil uil-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <form id="formEliminarEmpleado" method="POST">
        @csrf
        @method('DELETE')

    </form>


    {{-- ══════════ MODAL CREAR ══════════ --}}
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST"
                    action="{{ Route::has('crear_empleado') ? route('crear_empleado') : url()->current() }}">
                    @csrf

                    <div class="modal-header bg-primary bg-gradient">
                        <h5 class="modal-title text-white">
                            <i class="uil uil-shield-check me-2"></i>Nuevo empleado +
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Nombre del empleado
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control" placeholder="Ej: Arial"
                                    required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Apellido del empleado
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="apellido" class="form-control" placeholder="Ej: Lopez"
                                    required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Direccion
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="direccion" class="form-control" placeholder="Av. Mariscal"
                                    required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Calificacion
                                    <span class="text-danger">*</span></label>
                                <input type="number" name="calificacion" class="form-control" required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Genero
                                    <span class="text-danger">*</span></label>
                                <select name="genero" id="" class="form-control">
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Email
                                    <span class="text-danger">*</span></label>
                                <input type="email" name="correo" class="form-control" required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Cotraseña
                                    <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium">Cotraseña
                                    <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required />
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="uil uil-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="uil uil-check me-1"></i>Guardar empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eliminarButtons = document.querySelectorAll('.btn-eliminar_empleado');
            const formEliminarEmpleado = document.getElementById('formEliminarEmpleado');

            eliminarButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const empleadoId = this.getAttribute('data-id');
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formEliminarEmpleado.action = `/empleado/eliminar/${empleadoId}`;
                            formEliminarEmpleado.submit();
                            Swal.fire({
                                title: "Eliminado!!!",
                                text: "El empleado ha sido eliminado.",
                                icon: "success",
                            });
                        }
                    });
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @elseif (session('error'))
            Swal.fire({
                title: 'Ups Error!',
                text: '{{ session('error') }}'
                icon: "error",
                draggable: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Errores de validacion!',
                text: 'Por favor, revisa los errores en el formulario.',
                icon: "error",
                html: `<ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach 
                      </ul>`,
                ConfirmButtonColor: '#3085d6',
                draggable: true
            });
        @endif
    </script>

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
