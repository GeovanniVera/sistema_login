<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Imprenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-link:hover {
            transform: scale(1.05);
            transition: transform 0.3s;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Mensajes de sesión -->
                <?php if ($mensaje): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($mensaje) ?>
                    </div>
                <?php endif; ?>

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">Bienvenido, <?= htmlspecialchars($usu) ?></h3>
                    </div>
                    <div class="card-body">
                        <!-- Información del usuario -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($correo) ?></p>
                                <p><strong>ID de Usuario:</strong> <?= htmlspecialchars($idU) ?></p>
                            </div>
                        </div>

                        <!-- Menú de acciones -->
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <!-- Gestión de Insumos -->
                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/insumos'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">🖨️ Insumos</h5>
                                        <p class="card-text">Administra papel, tinta y materiales</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Gestión de Usuarios -->
                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/usuarios'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">👥 Usuarios</h5>
                                        <p class="card-text">Administra cuentas de usuarios</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cerrar Sesión -->
                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/logout'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">🔒 Cerrar Sesión</h5>
                                        <p class="card-text">Salir del sistema</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>