<?php
namespace App\Controllers;
use App\Interfaces\Autenticable;

require_once __DIR__.'./../interfaces/Auntenticatable.php';
abstract class BaseController implements Authenticatable {
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
        extract($data);
        require_once __DIR__ . "./../views/$view.php";
    }
}
?>