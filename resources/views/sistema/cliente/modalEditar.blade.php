<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form method="POST" id="formEditar">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary bg-gradient border-0">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-edit-alt me-2"></i>Editar Cliente
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
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" placeholder="Ej: Carlos" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-user text-primary me-1"></i>
                                Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="apellido" id="edit_apellido" class="form-control" placeholder="Ej: Mamani" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-phone text-primary me-1"></i>
                                Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="telefono" id="edit_telefono" class="form-control" placeholder="77777777" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-location-point text-primary me-1"></i>
                                Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="direccion" id="edit_direccion" class="form-control" placeholder="Ej: Av. 123" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-venus-mars text-primary me-1"></i>
                                Género <span class="text-danger">*</span>
                            </label>
                            <select name="genero" id="edit_genero" class="form-control" required>
                                <option value="" disabled>Seleccione género</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-envelope text-primary me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="edit_email" class="form-control" placeholder="cliente@ejemplo.com" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-lock text-primary me-1"></i>
                                Contraseña <span class="text-muted">(opcional)</span>
                            </label>
                            <input type="password" name="password" id="edit_password" class="form-control" placeholder="Dejar en blanco para mantener actual">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="uil uil-lock-alt text-primary me-1"></i>
                                Confirmar Contraseña
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar nueva contraseña">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="uil uil-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="uil uil-check-circle me-1"></i>Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botones = document.querySelectorAll('.btn-editar-cliente');

        botones.forEach((btn) => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const genero = this.dataset.genero;

                document.getElementById('edit_nombre').value = this.dataset.nombre || '';
                document.getElementById('edit_apellido').value = this.dataset.apellido || '';
                document.getElementById('edit_telefono').value = this.dataset.telefono || '';
                document.getElementById('edit_direccion').value = this.dataset.direccion || '';
                document.getElementById('edit_email').value = this.dataset.email || '';

                const generoSelect = document.getElementById('edit_genero');
                if (genero === 'Masculino' || genero === 'M') {
                    generoSelect.value = 'M';
                } else if (genero === 'Femenino' || genero === 'F') {
                    generoSelect.value = 'F';
                } else {
                    generoSelect.value = '';
                }

                document.getElementById('edit_password').value = '';
                document.querySelector('input[name="password_confirmation"]').value = '';

                document.getElementById('formEditar').action = `/cliente/editar/${id}`;
            });
        });
    });
</script>
