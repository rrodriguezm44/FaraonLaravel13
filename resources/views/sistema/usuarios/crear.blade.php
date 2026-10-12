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
