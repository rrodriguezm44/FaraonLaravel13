{{-- ══════════ MODAL EDITAR CON CHECKBOXES ══════════ --}}
<div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="formEditarUsuario">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary bg-gradient">
                    <h5 class="modal-title text-white">
                        <i class="uil uil-edit me-2"></i>Editar usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Nombre del cliente
                                <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Correo electrónico
                                <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="edit_email" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" name="password" class="form-control" />
                            <small class="text-muted">Solo si desea cambiar la contraseña</small>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" />
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-medium d-block mb-3">
                                Roles del usuario
                                <span class="text-danger">*</span>
                            </label>

                            <div class="row" id="rolesCheckboxes">
                                @foreach ($roles as $rol)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input role-checkbox"
                                                   type="checkbox"
                                                   name="roles[]"
                                                   value="{{ $rol->name }}"
                                                   id="edit_rol_{{ $rol->id }}">
                                            <label class="form-check-label" for="edit_rol_{{ $rol->id }}">
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
                        <i class="uil uil-check me-1"></i>Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar edición de usuario
        const botones = document.querySelectorAll('.btn-editar-usuario');

        botones.forEach((btn) => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const email = this.dataset.email;
                const roles = JSON.parse(this.dataset.roles || '[]');

                // Llenar datos básicos
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;

                // Resetear checkboxes
                const checkboxes = document.querySelectorAll('#editUsuarioModal .role-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Marcar los roles actuales del usuario
                checkboxes.forEach(checkbox => {
                    if (roles.includes(checkbox.value)) {
                        checkbox.checked = true;
                    }
                });

                // Setear acción del formulario
                document.getElementById('formEditarUsuario').action =
                    `/usuarios/actualizar/${id}`;
            });
        });

        // Validar que al menos un rol esté seleccionado antes de enviar
        const formCrear = document.querySelector('#modalCrear form');
        const formEditar = document.querySelector('#editUsuarioModal form');

        if (formCrear) {
            formCrear.addEventListener('submit', function(e) {
                const checkboxes = this.querySelectorAll('input[name="roles[]"]:checked');
                if (checkboxes.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error',
                        text: 'Debe seleccionar al menos un rol para el usuario',
                        confirmButtonColor: '#f46a6a'
                    });
                }
            });
        }

        if (formEditar) {
            formEditar.addEventListener('submit', function(e) {
                const checkboxes = this.querySelectorAll('input[name="roles[]"]:checked');
                if (checkboxes.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error',
                        text: 'Debe seleccionar al menos un rol para el usuario',
                        confirmButtonColor: '#f46a6a'
                    });
                }
            });
        }
    });
</script>
