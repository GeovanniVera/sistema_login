<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="text-center">Registro de Usuario</h3>
                    </div>
                    <div class="card-body">
                        
                        <?php if ($isError): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>

                        <?php endif; ?>

                        <form action="/registro" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrar Usuario</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="/" class="text-decoration-none">¿Ya tienes cuenta? Inicia Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>