<?php
namespace App\Controllers;
use App\Interfaces\Authenticable; 
use App\Core\Session;

abstract class BaseController implements Authenticable {
    protected $model;

    // Método obligatorio para autenticación
    public function checkAuth(): void {
        if (!Session::has('usuario')) {
            header('Location: /login');
            exit();
        }
    }

    // Método común para renderizar vistas
    protected function render(string $view, array $data = []): void {
        $viewPath = __DIR__ . "/../views/$view.php";

    // Verificar si la vista existe
    if (!file_exists($viewPath)) {
        throw new \Exception("La vista '$view' no existe.");
    }

    // Extraer los datos para que estén disponibles en la vista
    extract($data);

    // Incluir la vista
    require $viewPath;
    }
}
?>