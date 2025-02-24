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
                        <h3 class="text-center">Nuevo Insumo</h3>

                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error)?></div>
                        <?php endif; ?>
                        <form action="/nuevoInsumo" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Clave</label>
                                <input type="text" class="form-control" name="clave" required>
                            </div>
                            <div class="mb-3">
                                <select name="id_inventario" id="inventario" class="form-select ">
                                    
                                    <option value="" disabled selected>---Seleccionar un Inventario---</option>
                                    <?php foreach ($data['inventarios'] as $inventario) : ?>
                                        <option value="<?php echo $inventario['id'] ?>"><?php echo $inventario['nombre'] ?></option>
                                    <?php endforeach ;?>

                                </select>            
                            </div>


                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        <a href="/insumos" class="btn btn-danger mt-3 w-100">Cancelar</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>