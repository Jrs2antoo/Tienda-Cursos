<?php $esNuevo = $curso === null; ?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="mb-4">
                    <h1 class="fw-bold mb-1">
                        <?= $esNuevo ? 'Crear nuevo curso' : 'Editar curso' ?>
                    </h1>
                    <a href="/tiendaCursos/admin/cursos" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Volver a cursos
                    </a>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="/tiendaCursos/admin/cursos/editar">
                            <input type="hidden" name="id" value="<?= $esNuevo ? 0 : $curso->id ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Título</label>
                                <input type="text" class="form-control" name="title"
                                       value="<?= htmlspecialchars($curso->title ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Descripción</label>
                                <textarea class="form-control" name="description" rows="4"><?= htmlspecialchars($curso->description ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Precio (€)</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control" name="price"
                                           step="0.01" min="0"
                                           value="<?= $curso->price ?? '0' ?>">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">URL de imagen</label>
                                <input type="url" class="form-control" name="image_url"
                                       placeholder="https://…"
                                       value="<?= htmlspecialchars($curso->imageUrl ?? '') ?>">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <?= $esNuevo ? 'Crear curso' : 'Guardar cambios' ?>
                                </button>
                                <a href="/tiendaCursos/admin/cursos" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>