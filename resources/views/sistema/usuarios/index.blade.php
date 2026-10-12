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
            Tabla
        @endslot
        @slot('title')
            Usuarios
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title d-flex align-items-center gap-2 mb-1">
                                <i class="uil uil-apps text-primary"></i>
                                Usuarios
                            </h4>

                            <p class="text-muted mb-0">
                                Administra usuarios en el sistema
                            </p>
                        </div>

                        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal"
                            data-bs-target="#modalCrear">

                            <i class="uil uil-plus me-1"></i>
                            Crear Usuarios
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        @if ($usuario->roles->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($usuario->roles as $rol)
                                                    @php
                                                        $badgeClass = match ($rol->name) {
                                                            'admin' => 'bg-danger',
                                                            'super-admin' => 'bg-dark',
                                                            'gerente' => 'bg-warning',
                                                            default => 'bg-primary',
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">
                                                        <i class="uil uil-check-circle me-1"></i>
                                                        {{ $rol->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="uil uil-times me-1"></i>Sin rol
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar"
                                                data-id="{{ $usuario->id }}">Eliminar
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm btn-editar-usuario"
                                                data-bs-toggle="modal" data-bs-target="#editUsuarioModal"
                                                data-id="{{ $usuario->id }}" data-name="{{ $usuario->name }}"
                                                data-email="{{ $usuario->email }}"
                                                data-roles='@json($usuario->roles->pluck('name'))'>
                                                <i class="uil uil-edit me-1"></i>Editar
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <form id="formEliminar" method="POST">
        @csrf
        @method('DELETE')
    </form>
{{-- ══════════ MODAL CREAR CON CHECKBOXES ══════════ --}}
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf

                <div class="modal-header bg-primary bg-gradient">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-shield-check me-2"></i>Nuevo usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Nombre del cliente
                                <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Correo electrónico
                                <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Contraseña
                                <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Confirmar Contraseña
                                <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required />
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-medium d-block mb-3">
                                Roles del usuario
                                <span class="text-danger">*</span>
                            </label>

                            <div class="row">
                                @foreach ($roles as $rol)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="roles[]"
                                                   value="{{ $rol->name }}"
                                                   id="rol_{{ $rol->id }}">
                                            <label class="form-check-label" for="rol_{{ $rol->id }}">
                                                <i class="uil uil-badge me-1"></i>
                                                {{ $rol->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Seleccione uno o más roles para el usuario</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="uil uil-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="uil uil-check me-1"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesEliminar = document.querySelectorAll('.btn-eliminar');
            const formEliminar = document.getElementById('formEliminar');
            botonesEliminar.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;

                    Swal.fire({
                        title: "Eliminar usuario?",
                        text: "Esta accion no se puede deshacer!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Eliminar!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formEliminar.action = `/servicio/eliminar/${id}`
                            formEliminar.submit();
                        }
                    });
                });
            });

        });
    </script>



    @include('sistema.usuarios.crear')
    @include('sistema.usuarios.editar')


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: "Éxito",
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: "Error",
                text: '{{ session('error') }}',
                confirmButtonColor: '#f46a6a'
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
