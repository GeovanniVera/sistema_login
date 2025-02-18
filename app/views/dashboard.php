<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h3 class="text-center">Bienvenido al Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <p>Hola, <strong><?= htmlspecialchars(Session::get('usuario')['nombre']) ?></strong></p>
                            <p>Correo: <?= htmlspecialchars(Session::get('usuario')['email']) ?></p>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="/logout" class="btn btn-danger">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>