<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="text-center">
                            Detalles de <?= htmlspecialchars($data['nombre']) ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar detalles -->
                        <div class="mb-3">
                            <label class="form-label"><strong>ID:</strong></label>
                            <p><?= htmlspecialchars($usuario->getId()) ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Nombre:</strong></label>
                            <p><?= htmlspecialchars($usuario->getNombre()) ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Correo:</strong></label>
                            <p><?= htmlspecialchars($usuario->getEmail()) ?></p>
                        </div>
                        <a href="/usuarios" class="btn btn-primary">← Volver a Usuarios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>