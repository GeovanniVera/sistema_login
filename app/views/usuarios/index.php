<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">Usuarios Registrados</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mensajes de éxito/error -->
                        <?php if (isset($isMensaje) && $isMensaje): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($mensaje) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($isError) && $isError): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>


                        <a href="/dashboard" class="btn btn-secondary mb-3">← Volver al Dashboard</a>

                        <!-- Tabla de usuarios -->
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['usuarios'] as $usuario): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                                        <td>
                                            <a
                                                href="/usuarios/ver/<?= htmlspecialchars($usuario['id']) ?>"
                                                class="btn btn-sm btn-info">
                                                Ver Detalles
                                            </a>
                                            <a href="/usuarios/eliminar/<?= htmlspecialchars($usuario['id']) ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>