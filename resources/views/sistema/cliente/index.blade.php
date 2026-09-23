@extends('layouts.master')
@section('title')
    Gestión de Clientes
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Administración
        @endslot
        @slot('title')
            Clientes
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <div>
                            <h4 class="card-title d-flex align-items-center gap-2 mb-1">
                                <i class="uil uil-users-alt text-primary fs-4"></i>
                                Listado de Clientes
                            </h4>
                            <p class="text-muted mb-0">
                                <i class="uil uil-info-circle me-1"></i>
                                Administra la información de tus clientes registrados
                            </p>
                        </div>
                        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            <i class="uil uil-plus me-1"></i>
                            Crear Cliente
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="uil uil-user-circle me-1"></i> Nombre</th>
                                    <th><i class="uil uil-user me-1"></i> Apellido</th>
                                    <th><i class="uil uil-envelope me-1"></i> Correo</th>
                                    <th><i class="uil uil-location-point me-1"></i> Dirección</th>
                                    <th><i class="uil uil-venus-mars me-1"></i> Género</th>
                                    <th><i class="uil uil-cog me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="align-middle fw-semibold">{{ $cliente->nombre }}</td>
                                        <td class="align-middle">{{ $cliente->apellido }}</td>
                                        <td class="align-middle">
                                            <span class="badge bg-info-subtle text-info px-3 py-2">
                                                <i class="uil uil-envelope-alt me-1"></i>
                                                {{ $cliente->user->email }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <i class="uil uil-map-marker text-muted me-1"></i>
                                            {{ $cliente->direccion }}
                                        </td>
                                        <td class="align-middle">
                                            @php
                                                $generoIcon = $cliente->genero == 'Masculino' ? 'uil uil-mars' : ($cliente->genero == 'Femenino' ? 'uil uil-venus' : 'uil uil-genderless');
                                                $generoColor = $cliente->genero == 'Masculino' ? 'primary' : ($cliente->genero == 'Femenino' ? 'danger' : 'secondary');
                                            @endphp
                                            <span class="badge bg-{{ $generoColor }}-subtle text-{{ $generoColor }} px-3 py-2">
                                                <i class="{{ $generoIcon }} me-1"></i>
                                                {{ $cliente->genero }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-primary btn-sm rounded-circle btn-editar-cliente"
                                                    style="width: 34px; height: 34px;"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                    data-id="{{ $cliente->id }}"
                                                    data-nombre="{{ $cliente->nombre }}"
                                                    data-apellido="{{ $cliente->apellido }}"
                                                    data-telefono="{{ $cliente->telefono }}"
                                                    data-email="{{ $cliente->user->email }}"
                                                    data-direccion="{{ $cliente->direccion }}"
                                                    data-genero="{{ $cliente->genero }}">
                                                    <i class="uil uil-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm rounded-circle btn-eliminar-cliente"
                                                    style="width: 34px; height: 34px;"
                                                    data-id="{{ $cliente->id }}">
                                                    <i class="uil uil-trash-alt"></i>
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
    </div>

    <form id="formEliminarCliente" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @include('sistema.cliente.modalCrear')
    @include('sistema.cliente.modalEditar')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: "¡Éxito!",
                text: '{{ session('success') }}',
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                title: "¡Error!",
                text: '{{ session('error') }}',
                icon: "error",
                confirmButtonColor: "#d33"
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesEliminar = document.querySelectorAll('.btn-eliminar-cliente');
            const formEliminar = document.getElementById('formEliminarCliente');

            botonesEliminar.forEach((btn) => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const nombre = this.closest('tr').querySelector('td:first-child').innerText;

                    Swal.fire({
                        title: "¿Eliminar cliente?",
                        html: `Estás a punto de eliminar a <strong>${nombre}</strong><br>Esta acción no se puede deshacer`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formEliminar.action = `/cliente/eliminar/${id}`;
                            formEliminar.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
