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
                            <h4 class="card-title">Lista Categoría</h4>
                            <p class="card-title-desc">Administra tus categorias: <code>crear, actualiza, lista y
                                    eliminar</code>.
                        </div>
                        </p>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">Crear
                            categoria</button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td>{{ $categoria->descripcion }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('eliminar_categoria', $categoria->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-outline-danger btn-sm">Eliminar</button>
                                            </form>
                                            <button class="btn btn-outline-primary btn-sm btn-editar-categoria"
                                                data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                data-id="{{ $categoria->id }}" data-nombre="{{ $categoria->nombre }}"
                                                data-descripcion="{{ $categoria->descripcion }}">Editar</button>
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

    {{-- MODAL CREAR --}}

    <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCrearLabel">Crear Categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('crear_categoria') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">Nombre categoria</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: telefonos"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="descripcion" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditarLabel">Crear Categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">Nombre categoria</label>
                                <input type="text" class="form-control" name="nombre" id="edit_nombre"
                                    placeholder="Ej: telefonos" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="descripcion" id="edit_descripcion"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesEditar = document.querySelectorAll('.btn-editar-categoria');
            console.log(botonesEditar)

            botonesEditar.forEach(btn => {
                btn.addEventListener('click', function() {

                    const id = this.dataset.id;
                    document.getElementById('edit_nombre').value = this.dataset.nombre;
                    document.getElementById('edit_descripcion').value = this.dataset.descripcion;

                    document.getElementById('formEditar').action = `/categoria/editar/${id}`;
                })
            })
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
    </script>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
