<main class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h1 class="fw-bold mb-1">Finalizar compra</h1>
                <p class="text-muted mb-4">Revisa tu pedido e introduce tus datos de pago.</p>

                <div class="row g-4">

                    <!-- Formulario de pago -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Datos de facturación</h5>

                                <form method="POST" action="/tiendaCursos/checkout/pagar">

                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-6">
                                            <label class="form-label fw-semibold small">Nombre</label>
                                            <input type="text" class="form-control" name="nombre"
                                                   value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label fw-semibold small">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                   value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h5 class="fw-bold mb-3">Datos de pago</h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Número de tarjeta</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456"
                                                   maxlength="19" required>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold small">Caducidad</label>
                                            <input type="text" class="form-control" placeholder="MM/AA"
                                                   maxlength="5" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold small">CVV</label>
                                            <input type="text" class="form-control" placeholder="123"
                                                   maxlength="3" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning fw-semibold w-100 py-2">
                                        <i class="bi bi-lock-fill me-1"></i> Pagar ahora
                                    </button>

                                    <p class="small text-success text-center mt-2 mb-0">
                                        <i class="bi bi-shield-check me-1"></i>Pago 100% seguro y encriptado
                                    </p>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Resumen</h5>

                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Subtotal</span>
                                    <span>69,98 €</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 small">
                                    <span class="text-muted">Descuento</span>
                                    <span class="text-success">— 0,00 €</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                                    <span>Total</span>
                                    <span class="text-primary">69,98 €</span>
                                </div>

                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge bg-light text-dark border px-3 py-2">VISA</span>
                                    <span class="badge bg-light text-dark border px-3 py-2">MC</span>
                                    <span class="badge bg-primary px-3 py-2">PayPal</span>
                                </div>

                                <a href="/tiendaCursos/carrito" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                    ← Volver al carrito
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
