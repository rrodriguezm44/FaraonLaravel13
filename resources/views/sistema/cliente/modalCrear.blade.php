{{-- ══════════ MODAL CREAR CLIENTE ══════════ --}}
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form method="POST" action="{{ route('cliente.store') }}">
                @csrf

                <div class="modal-header bg-primary bg-gradient border-0">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-user-plus me-2"></i>Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-user-circle text-primary me-1"></i>
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Carlos" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-user text-primary me-1"></i>
                                Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="apellido" class="form-control" placeholder="Ej: Mamani" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-phone text-primary me-1"></i>
                                Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="telefono" class="form-control" placeholder="77777777" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-location-point text-primary me-1"></i>
                                Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="direccion" class="form-control" placeholder="Ej: Av. 123" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-venus-mars text-primary me-1"></i>
                                Género <span class="text-danger">*</span>
                            </label>
                            <select name="genero" class="form-control" required>
                                <option value="" disabled selected>Seleccione género</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-envelope text-primary me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="cliente@ejemplo.com" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-lock text-primary me-1"></i>
                                Contraseña <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-lock-alt text-primary me-1"></i>
                                Confirmar Contraseña <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="uil uil-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="uil uil-check-circle me-1"></i>Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
