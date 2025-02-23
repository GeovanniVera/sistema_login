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
        extract($data);
        require_once __DIR__ . "./../views/$view.php";
    }
}
?>