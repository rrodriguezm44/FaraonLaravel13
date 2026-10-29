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
            Operaciones
        @endslot
        @slot('title')
            Asignaciones
        @endslot
    @endcomponent

    <div class="row">
        {{-- PANEL IZQUIERDO | LISTA DE EMPLEADOS --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3"> <i class="uil uil-users-alt"></i>
                        Empleados
                    </h5>
                    <div id="listaEmpleados">
                        @foreach ($empleados as $empleado)
                            <div class="empleado-card d-flex align-items-center mb-3 p-2 border rounded"
                                data-id="{{ $empleado->id }}"
                                data-nombre="{{ $empleado->nombre }} {{ $empleado->apellido }}"
                                data-email="{{ $empleado->user->email }}">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px;">
                                    {{ strtoupper(substr($empleado->nombre, 0, 1)) }}
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </div>
                                    <small class="text-muted">{{ $empleado->user->email }}</small>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>
        {{-- PANEL DERECHO | ASIGNACIONES- --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div id="estadoVacio" class="text-center py-5">
                        <i class="uil uil-user" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">Seleccione un empleado para ver sus asignaciones.</p>
                    </div>

                    <div id="skeletonLoader" style="display: none;">
                        <div class="placeholder-glow mb-3">
                            <div class="placeholder w-100 bg-secondary" style="height: 28px"></div>
                        </div>

                        <div class="placeholder-glow mb-2">
                            <div class="placeholder w-100 bg-secondary" style="height: 48px"></div>
                        </div>

                    </div>

                    <div id="contenidoPrincipal" style="display: none">
                        <div class="d-flex align-items-center gap-3">
                            <div id="detAvatarCircle"
                                class="rounded-circle bg-primary text-white text-primary d-flex align-items-center justify-content-center"
                                style="width: 52px; height: 52px; font-size: 1.4rem; font-weight: 700;">

                            </div>
                            <div>
                                <h5 id="detNombre" class="fw-semibold mt-2"></h5>
                                <small id="detEmail" class="text-muted"></small>
                            </div>

                            <div class="ms-auto">
                                <button id="btnGuardarServicios" class="btn btn-primary btn-sm"
                                    style="display: none">Asignar Servicio
                                </button>
                            </div>
                        </div>


                        {{-- checkbok --}}

                        <h6 class="mb-3">Servicios</h6>
                        <p class="text-muted">
                            Marca los Servicios que puede realizar el empleado
                        </p>

                        <div id="listaServicios" class="row g-2">
                            @foreach ($servicios as $servicio)
                                <div class="fw-medium" style="font-size: .9rem;">
                                    <label class="border rounded p-2 d-flex align-items-center servicio-label"
                                        for="srv_{{ $servicio->id }}" value="{{ $servicio->id }}">
                                        <input type="checkbox" class="form-check-input servicio-check m-0"
                                            id="srv_{{ $servicio->id }}" value="{{ $servicio->id }}">
                                        <div>
                                            <div class="fw-medium" style="font-size: .9rem;">
                                                {{ $servicio->nombre }}
                                            </div>
                                            <small class="text-muted">
                                                Bs. {{ $servicio->precio }}
                                                . {{ $servicio->duracion_minutos }} min
                                            </small>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


        <script>
            window.serviciosLista = @json($servicios);

            let empleadoActivoId = null;
            document.querySelectorAll('.empleado-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.empleado-card').forEach(c => {
                        c.classList.remove('active');
                    })
                    this.classList.add('active');

                    const id = this.dataset.id;
                    const nombreCompleto = this.dataset.nombre;
                    empleadoActivoId = id;

                    document.getElementById('estadoVacio').style.display = 'none';
                    document.getElementById('contenidoPrincipal').style.display = 'block';
                    document.getElementById('skeletonLoader').style.display = 'block';
                    document.getElementById('btnGuardarServicios').style.display = 'none';

                    const nombres = nombreCompleto.split(' ');
                    let iniciales = '';
                    if (nombres.length >= 2) {
                        iniciales = (nombres[0][0] + nombres[1][0]).toUpperCase();
                    } else {
                        iniciales = nombres[0][0].toUpperCase();
                    }

                    document.getElementById('detAvatarCircle').textContent = iniciales;
                    document.getElementById('detNombre').textContent = nombreCompleto;
                    document.getElementById('detEmail').textContent = this.dataset.email;

                    cargarServiciosAsignados(id);
                })
            })

            function cargarServiciosAsignados(empleadoId) {
                axios.get(`/asignaciones/empleado/${empleadoId}`)
                    .then(response => {
                        const serviciosAsignadosIds = response.data.servicios_asignados || [];

                        document.getElementById('skeletonLoader').style.display = 'none';
                        document.getElementById('btnGuardarServicios').style.display = 'block';

                        //marcar y desmarcar checkboks

                        document.querySelectorAll('.servicio-check').forEach(checkbox => {
                            const servicioId = parseInt(checkbox.value);
                            checkbox.checked = serviciosAsignadosIds.includes(servicioId);

                            const label = checkbox.closest('.servicio-label');
                            if (checkbox.checked) {
                                label.classList.add('border-primary', 'bg-primary', 'bg-opacity-10', 'text-white');
                            } else {
                                label.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10',
                                    'text-white');
                            }
                        })
                    })
                    .catch(error => {
                        document.getElementById('skeletonLoader').style.display = 'none';
                        Swal.fire('Error', error.response?.data?.error || 'error al cargar los servicios', 'error');
                    });
            }

            document.querySelectorAll('.servicio-check').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.closest('.servicio-label');
                    if (this.checked) {
                        label.classList.add('border-primary', 'bg-primary', 'bg-opacity-10', 'text-white');
                    } else {
                        label.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10', 'text-white');
                    }
                })
            });

            // document.getElementById('btnGuardarServicios').addEventListener('click', function() {
            //     if (!empleadoActivoId) {
            //         Swal.fire('Advertencia', 'Seleccione un empleado primero', 'warning');
            //         return;
            //     }

            //     const serviciosAsignados = [];
            //     document.querySelectorAll('.servicio-check:checked').forEach(checkbox => {
            //             serviciosAsignados.push(parseInt(checkbox.value));
            //     });

            //     const fd = new FormData();
            //     serviciosAsignados.forEach(id => 
            //         fd.append('servicios[]', id));
            //         fd.append('_token', '{{ csrf_token() }}');

            //         this.dataset = true;
            //         this.innerHTML = '<span class="spinner-border spinner-border-sm me-1">Guardando......</span>'


            //     axios.post(`/asignaciones/empleado/${empleadoActivoId}/servicios`, fd)
            //         .then(({data}) => {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Éxito',
            //                 text: data.message || 'Servicios asignados correctamente',
            //                 showConfirmButton: false,
            //             });
            //         })
            //         .catch(error => {
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Error',
            //                 text: error.response?.data?.message || 'Error al asignar servicios',
            //                 showConfirmButton: false,
            //             })
            //         })
            // });

            const btnGuardar = document.getElementById('btnGuardarServicios');
            const btnGuardarHTMLOriginal = btnGuardar.innerHTML;

            btnGuardar.addEventListener('click', function() {
                if (!empleadoActivoId) {
                    Swal.fire('Advertencia', 'Seleccione un empleado primero', 'warning');
                    return;
                }

                const serviciosAsignados = [];
                document.querySelectorAll('.servicio-check:checked').forEach(checkbox => {
                    serviciosAsignados.push(parseInt(checkbox.value));
                });

                const fd = new FormData();
                serviciosAsignados.forEach(id => fd.append('servicios[]', id));
                fd.append('_token', '{{ csrf_token() }}');

                // Estado de carga correcto
                btnGuardar.disabled = true;
                btnGuardar.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Guardando...';

                axios.post(`/asignaciones/empleado/${empleadoActivoId}/servicios`, fd)
                    .then(({
                        data
                    }) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message || 'Servicios asignados correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response?.data?.message || 'Error al asignar servicios',
                        });
                    })
                    .finally(() => {
                        // Siempre restaurar el botón
                        btnGuardar.disabled = false;
                        btnGuardar.innerHTML = btnGuardarHTMLOriginal;
                    });
            });
        </script>


        <style>
            .empleado-card:hover {
                border-color: #007bff !important;
                background-color: #4a4e50 !important;
                cursor: pointer;
            }

            .empleado-card:active {
                border-color: #556ee6;
                background-color: #88b1c5 !important;
            }

            .servicio-label {
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .serivicio-label:has(input:checked) {
                border-color: #007bff !important;
                background-color: #4a4e50 !important;
            }
        </style>
    @endsection

    @section('script')
        <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    @endsection
