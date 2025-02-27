<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insumos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">Insumos Registrados</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mensajes de éxito -->
                         <?php $insumos = $data['insumos']?>
                        <?php if ($data['mensaje']): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($data['mensaje']) ?>
                            </div>
                        <?php endif; ?>

                        <a href="/dashboard" class="btn btn-secondary mb-3">← Volver al Dashboard</a>
                        <a href="/nuevoInsumo" class="btn btn-success mb-3">+ Nuevo Insumo</a>

                        <!-- Tabla de usuarios -->
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Clave</th>
                                    <th>Nombre</th>
                                    <th>Inventario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($insumos as $insumo): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($insumo->getId()) ?></td>
                                        <td><?= htmlspecialchars($insumo->getClave()) ?></td>
                                        <td><?= htmlspecialchars($insumo->getNombre()) ?></td>
                                        <td><?= htmlspecialchars($insumo->getIdInventario()) ?></td>

                                        <td>
                                            <a 
                                                href="/insumos/ver/<?= htmlspecialchars($insumo->getId()) ?>" 
                                                class="btn btn-sm btn-info"
                                            >
                                            Ver Detalles
                                            </a>
                                            <a 
                                                href="/insumos/eliminar/<?= htmlspecialchars($insumo->getId()) ?>" 
                                                class="btn btn-sm btn-danger"
                                            >
                                            Eliminar
                                            </a>
                                            <a 
                                                href="/insumos/actualizar/<?= htmlspecialchars($insumo->getId()) ?>" 
                                                class="btn btn-sm btn-warning"
                                            >
                                            Actualizar
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