<main>

    <!-- ===== HERO ===== -->
    <section class="bg-primary text-white py-5">
        <div class="container py-3">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="badge bg-white text-primary mb-3 px-3 py-2 fs-6">
                            👋 Hola, <?= htmlspecialchars($_SESSION['full_name']) ?>
                        </span>
                    <?php endif; ?>
                    <span class="badge bg-warning text-dark mb-3">🎓 +500 cursos disponibles</span>
                    <h1 class="display-5 fw-bold mb-3">
                        Aprende lo que <em>quieras</em>,<br>cuando quieras.
                    </h1>
                    <p class="lead text-white-50 mb-4">
                        Descubre nuestra colección de cursos impartidos por expertos.
                        Aprende a tu ritmo y obtén certificados reconocidos.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/tiendaCursos/cursos" class="btn btn-warning fw-semibold px-4 py-2">
                            Ver todos los cursos →
                        </a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/tiendaCursos/mis-cursos" class="btn btn-outline-light px-4 py-2">
                                Mis cursos
                            </a>
                        <?php else: ?>
                            <a href="/tiendaCursos/registro" class="btn btn-outline-light px-4 py-2">
                                Crear cuenta gratis
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Stats -->
                <div class="col-lg-5">
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3">
                                <div class="fs-3 fw-bold">12k+</div>
                                <div class="small text-white-50">Estudiantes</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3">
                                <div class="fs-3 fw-bold">500+</div>
                                <div class="small text-white-50">Cursos</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3">
                                <div class="fs-3 fw-bold">98%</div>
                                <div class="small text-white-50">Satisfacción</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CURSOS DESTACADOS ===== -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Cursos destacados</h2>
                <a href="/tiendaCursos/cursos" class="btn btn-outline-primary btn-sm">
                    Ver todos →
                </a>
            </div>

            <div class="row g-4">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <?php if (!empty($course->imageUrl)): ?>
                                <img src="/tiendaCursos/public/img/cursos/<?= htmlspecialchars($course->imageUrl) ?>"
                                     class="card-img-top object-fit-cover"
                                     style="height:180px;"
                                     alt="<?= htmlspecialchars($course->title) ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-primary-subtle"
                                     style="height:180px;">
                                    <i class="bi bi-play-circle fs-1 text-primary"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary-subtle text-primary mb-2 align-self-start">
                                    Curso
                                </span>
                                <h5 class="card-title fw-semibold">
                                    <?= htmlspecialchars($course->title) ?>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= htmlspecialchars($course->description) ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="fs-5 fw-bold text-primary">
                                        <?= number_format($course->price, 2) ?> €
                                    </span>
                                    <a href="/tiendaCursos/cursos" class="btn btn-sm btn-outline-primary">
                                        Ver curso
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="/tiendaCursos/cursos" class="btn btn-primary px-5">
                    Ver todos los cursos →
                </a>
            </div>
        </div>
    </section>

    <!-- ===== POR QUÉ NOSOTROS ===== -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">¿Por qué elegirnos?</h2>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="fs-1 mb-3">🎓</div>
                    <h5 class="fw-semibold">Expertos del sector</h5>
                    <p class="text-muted small">Todos nuestros cursos están impartidos por profesionales con amplia experiencia.</p>
                </div>
                <div class="col-md-4">
                    <div class="fs-1 mb-3">📱</div>
                    <h5 class="fw-semibold">Aprende donde quieras</h5>
                    <p class="text-muted small">Accede a tus cursos desde cualquier dispositivo, en cualquier momento.</p>
                </div>
                <div class="col-md-4">
                    <div class="fs-1 mb-3">🏆</div>
                    <h5 class="fw-semibold">Certificados reconocidos</h5>
                    <p class="text-muted small">Obtén certificados que avalan tu formación y mejoran tu perfil profesional.</p>
                </div>
            </div>
        </div>
    </section>

</main>