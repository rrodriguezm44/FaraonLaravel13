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
                            <h4 class="card-title">Lista Servicios</h4>
                            <p class="card-title-desc">Administra tus Servicios: <code>crear, actualiza, lista y
                                    eliminar</code>.
                        </div>
                        </p>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">Crear
                            servicio</button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Duracion minutos</th>
                                <th>Estado</th>
                                <th>Foto</th>
                                <th>Categoria</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($servicios as $servicio)
                                <tr>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->descripcion }}</td>
                                    <td>{{ $servicio->precio }}</td>
                                    <td>{{ $servicio->duracion_minutos }}</td>
                                    <td>{{ $servicio->estado }}</td>
                                    <td>
                                        <div>
                                            <img src="{{ asset('storage/' . $servicio->foto) }}" alt="Foto" 
                                            width="50"
                                            height="50"
                                            class="rounded-circle">
                                        </div>
                                        
                                    </td>
                                    <td>{{ $servicio->categoria->nombre }}</td>
                                    {{-- <td><img src="{{ asset('storage/' . $servicio->foto) }}" alt="Foto"
                                            style="width: 100px; height: auto;"></td>
                                    <td>{{ $servicio->categoria->nombre ?? 'Sin categoria' }}</td> --}}
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
                <form method="POST" action="{{ route('crear_servicio') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header bg-primary bg-gradient">
                        <h5 class="modal-title text-white">
                            <i class="uil uil-shield-check me-2"></i>Nuevo Servicio
                        </h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium"
                                    >Nombre del servicio
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg--primary text-white"><i class="uil uil-tag-alt"></i></span>
                                    <input
                                        type="text"
                                        name="nombre"
                                        class="form-control"
                                        placeholder="Ej: ..."
                                        required
                                    />
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium"
                                    >Precio del servicio
                                    <span class="text-danger">*</span></label
                                >
                                <input
                                    type="number"
                                    name="precio"
                                    class="form-control"
                                    required
                                />
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium"
                                    >Duracion minutos
                                    <span class="text-danger">*</span></label
                                >
                                <input
                                    type="number"
                                    name="duracion_minutos"
                                    class="form-control"
                                    required
                                />
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium"
                                    >Categoria del servicio
                                    <span class="text-danger">*</span></label
                                >
                                <select name="categoria" class="form-select" required>
                                    <option value="" disabled selected>Seleccione una categoria</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-medium"
                                    >Descripcion del servicio
                                    <span class="text-danger">*</span></label
                                >
                                <textarea
                                    name="descripcion"
                                    class="form-control"
                                    rows="3"
                                    required
                                ></textarea>
                            </div>

                               {{-- FOTO --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-medium"
                                    >Imaegn
                                    <span class="text-danger">*</span></label
                                >
                                <input
                                    type="file"
                                    name="foto"
                                    id="fotoInputCrear"
                                    class="form-control"
                                    required
                                >
                            </div>
                            
                            <div class="mt-3 text-center" id="previewContainerCrear" style="display: none;">
                                
                                <img id="imagePreviewCrear" alt="Vista previa" width="200" height="200" class="rounded-circle">
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            <i class="uil uil-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="uil uil-check me-1"></i>Guardar ...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fotoInputCrear').addEventListener('change', function(e) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('previewContainerCrear');
            const imagePreview = document.getElementById('imagePreviewCrear');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                previewContainer.style.display = 'none';
            }
        });

    $('#modalCrear').on('hidden.bs.modal', function () {
        // Limpiar el formulario al cerrar el modal
        $(this).find('form')[0].reset();
        $('#previewContainerCrear').hide();
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
