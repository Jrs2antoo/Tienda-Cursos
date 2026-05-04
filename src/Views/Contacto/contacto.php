<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="text-center mb-5">
                    <h1 class="fw-bold">Contacta con nosotros</h1>
                    <p class="text-muted">¿Tienes alguna duda? Rellena el formulario y te respondemos lo antes posible.</p>
                </div>

                <?php if (!empty($_SESSION['contacto_ok'])): ?>
                    <div class="alert alert-success py-2">
                        <i class="bi bi-check-circle me-1"></i>
                        <?= htmlspecialchars($_SESSION['contacto_ok']) ?>
                    </div>
                    <?php unset($_SESSION['contacto_ok']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['contacto_error'])): ?>
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <?= htmlspecialchars($_SESSION['contacto_error']) ?>
                    </div>
                    <?php unset($_SESSION['contacto_error']); ?>
                <?php endif; ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="/tiendaCursos/contacto">

                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Nombre</label>
                                    <input type="text" name="nombre" class="form-control"
                                           placeholder="Tu nombre" required
                                           value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control"
                                           placeholder="tu@email.com" required
                                           value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Asunto</label>
                                <input type="text" name="asunto" class="form-control"
                                       placeholder="¿En qué podemos ayudarte?" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Mensaje</label>
                                <textarea name="mensaje" class="form-control" rows="5"
                                          placeholder="Escribe tu mensaje aquí..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-send me-1"></i> Enviar mensaje
                            </button>

                        </form>
                    </div>
                </div>

                <!-- Info adicional -->
                <div class="row g-3 mt-3 text-center">
                    <div class="col-4">
                        <div class="card border-0 shadow-sm py-3">
                            <i class="bi bi-envelope fs-4 text-primary"></i>
                            <p class="small mb-0 mt-1">contacto@tiendacursos.com</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card border-0 shadow-sm py-3">
                            <i class="bi bi-clock fs-4 text-primary"></i>
                            <p class="small mb-0 mt-1">Lun–Vie 9:00–18:00</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card border-0 shadow-sm py-3">
                            <i class="bi bi-reply fs-4 text-primary"></i>
                            <p class="small mb-0 mt-1">Respuesta en 24h</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
