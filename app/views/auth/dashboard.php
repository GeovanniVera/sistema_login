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
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h3 class="text-center">Bienvenido, <?= htmlspecialchars($nombre) ?></h3>
                    </div>
                    <div class="card-body">
                        <!-- Información del usuario -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                                <p><strong>ID de Usuario:</strong> <?= htmlspecialchars($id) ?></p>
                            </div>
                        </div>

                        <!-- Menú de acciones -->
                        <div class=" mt-3 mb-3">
                            <h3 class="title text-center">Modulo de Inventario </h3>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <!-- Modulo Inventario -->
                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/insumos'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">🖨️ Insumos</h5>
                                        <p class="card-text">Administra papel, tinta y materiales</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/inventario'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">📖 Inventarios</h5>
                                        <p class="card-text">Administra el Inventario de los insumos</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/inventario'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"> 🛒 Proveedores</h5>
                                        <p class="card-text">Proveedores de Insumos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" mt-3 mb-3">
                            <h3 class="title text-center">Modulo de Usuarios </h3>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                            <!-- Gestión de Usuarios-->
                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/usuarios'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">👥 Usuarios</h5>
                                        <p class="card-text">Administra cuentas de usuarios</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 card-link" onclick="window.location='/usuarios'">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">👨🏻‍🏫 roles</h5>
                                        <p class="card-text">Administra los roles</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class=" mt-3 mb-3">
                            <h3 class="title text-center">Otras Opciones </h3>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">

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