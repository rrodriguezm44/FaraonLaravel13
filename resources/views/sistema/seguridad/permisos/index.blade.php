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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title d-flex align-items-center gap-2 mb-1">
                                <i class="uil uil-apps text-primary"></i>
                                Permisos
                            </h4>
                            <p class="text-muted mb-0">
                                Administra tus permisos en el sistema
                            </p>
                        </div>
                        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal"
                            data-bs-target="#modalCrear">
                            <i class="uil uil-plus me-1"></i>
                            Crear Permiso
                        </button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPermisos">
                            @foreach ($permisos as $permiso)
                                <tr id="fila-{{ $permiso->id }}">
                                    <td>{{ $permiso->id }}</td>
                                    <td class="nombre-permiso-{{ $permiso->id }}">{{ $permiso->name }}</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <button class="btn btn-outline-danger btn-sm btn-eliminar-permiso"
                                                data-id="{{ $permiso->id }}">
                                                <i class="uil uil-trash-alt"></i>
                                            </button>
                                            <button class="btn btn-outline-success btn-sm btn-editar-permiso"
                                                data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                data-id="{{ $permiso->id }}" data-name="{{ $permiso->name }}">
                                                <i class="uil uil-edit"></i>
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

    <!-- MODAL CREAR -->
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-gradient">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-plus-circle me-2"></i>Crear Permiso
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Nombre del permiso <span class="text-danger">*</span></label>
                        <input type="text" id="crear_nombre" class="form-control" placeholder="Ej: users.create"
                            required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="uil uil-times me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarCreacion">
                        <i class="uil uil-check me-1"></i>Crear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success bg-gradient">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-shield-check me-2"></i>Editar Permiso
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Nombre del permiso <span class="text-danger">*</span></label>
                        <input type="text" id="edit_nombre" class="form-control" required />
                        <input type="hidden" id="edit_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="uil uil-times me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarEdicion">
                        <i class="uil uil-check me-1"></i>Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnCrear = document.getElementById('btnGuardarCreacion');

            btnCrear.addEventListener('click', async function() {
                const nombre = document.getElementById('crear_nombre').value.trim();

                if (!nombre) {
                    Swal.fire('El nombre es requerido');
                    return;
                }
                Swal.fire({
                    title: 'Creando....',
                    didOpen: () => Swal.showLoading(),
                });

                // AXIOS
                const response = await axios.post('/permisos', {
                    // Parametros
                    name: nombre,
                    _token: '{{ csrf_token() }}'
                })

                if (response.data.success) {
                    // Verdad
                    const nuevaFila = `
                    <tr id="fila-${response.data.id}">
                        <td>${response.data.id}</td>
                        <td class="nombre-permiso-${response.data.id}">${response.data.name}</td>
                        <td>
                            <div class="d-flex gap-3">
                                <button class="btn btn-outline-danger btn-sm btn-eliminar-permiso"
                                    data-id="${response.data.id}">
                                    <i class="uil uil-trash-alt"></i>
                                </button>

                            <button class="btn btn-outline-success btn-sm btn-editar-permiso"
                                data-id="${response.data.id}"
                                data-name="${response.data.name}">
                                <i class="uil uil-edit"></i>
                            </button>
                            </div>
                        </td>
                    </tr>
                    `;

                    document.getElementById('tablaPermisos').insertAdjacentHTML('beforeend', nuevaFila);
                    document.getElementById('crear_nombre').value = '';

                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCrear')).hide();

                    Swal.fire('Creado', 'Permiso Creado', 'success');
                }
            })

            function agregarEventosEliminar() {
                const botonesEliminar = document.querySelectorAll('.btn-eliminar-permiso');
                console.log('pasas')
                botonesEliminar.forEach((btn) => {
                    btn.removeEventListener('click', handleEliminar);
                    btn.addEventListener('click', handleEliminar);
                })
            }

            async function handleEliminar(event) {
                const btn = event.currentTarget;
                const id = btn.getAttribute('data-id');

                const result = await
                Swal.fire({
                    title: "Estas seguro?",
                    text: "No podras revertir esta acción",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                });

                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando...',
                        didOpen: () => Swal.showLoading(),
                        allowOutsideClick: false,
                    })
                }

                const response = await axios.delete(`/permisos/${id}`, {
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                });

                if (response.data.success) {
                    const fila = document.getElementById(`fila-${id}`);
                    if (fila) {
                        fila.remove();
                    }

                    Swal.fire('!Eliminado', 'Permiso eliminado correctamente', 'success');
                }
            }
            agregarEventosEliminar();
        })
    </script>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
