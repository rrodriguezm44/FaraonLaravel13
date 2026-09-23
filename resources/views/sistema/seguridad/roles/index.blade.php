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
            Roles
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title">Administra tus roles con permisos</h4>
                            <p class="card-title-desc">Roles y permisos.</p>
                        </div>

                        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal"
                            data-bs-target="#modalCrear">
                            <i class="uil uil-plus me-1"></i>
                            Crear Rol
                        </button>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Permisos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <td>{{ $rol->name }}</td>
                                    <td>
                                        @if ($rol->permissions->count())
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($rol->permissions as $permiso)
                                                    <span class="badge bg-soft-primary">{{ $permiso->name }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">Sin permisos</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEditar">
                                            <i class="uil uil-edit"></i>
                                            Editar
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

    {{-- ══════════ MODAL CREAR ══════════ --}}
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-gradient">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-shield-check me-2"></i>Nuevo Rol
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{route('roles.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-medium">Nombre del rol
                                <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Ej: Cliente" />
                        </div>

                        <div class="border rounded p-3">
                            <label class="form-label fw-medium mb-2">Permisos</label>
                            <div class="row g-2">
                                @foreach ($permisos as $permiso)
                                    <div class="col-md-6">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="crear_p{{ $permiso->id }}"
                                                name="permissions[]" value="{{$permiso->name}}">
                                            <label class="form-check-label">{{ $permiso->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="uil uil-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="uil uil-check me-1"></i>Guardar rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ══════════ MODAL EDITAR ══════════ --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning bg-gradient">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-edit me-2"></i>Editar Rol
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Nombre del rol
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="Administrador" />
                    </div>

                    <div class="border rounded p-3">
                        <label class="form-label fw-medium mb-2">Permisos</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="checkbox" id="edit_permiso1" checked>
                                    <label class="form-check-label" for="edit_permiso1">users.index</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="checkbox" id="edit_permiso2" checked>
                                    <label class="form-check-label" for="edit_permiso2">users.create</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="checkbox" id="edit_permiso3">
                                    <label class="form-check-label" for="edit_permiso3">users.edit</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="checkbox" id="edit_permiso4">
                                    <label class="form-check-label" for="edit_permiso4">users.delete</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="checkbox" id="edit_permiso5">
                                    <label class="form-check-label" for="edit_permiso5">productos.ver</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="checkbox" id="edit_permiso6">
                                    <label class="form-check-label" for="edit_permiso6">comprar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="uil uil-times me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="uil uil-check me-1"></i>Actualizar rol
                    </button>
                </div>
            </div>
        </div>
    </div>


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
                title: 'Errores de validación!',
                icon: "error",
                html: `
                    <ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>`,
                confirmButtonColor: '#f46a6a',
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
