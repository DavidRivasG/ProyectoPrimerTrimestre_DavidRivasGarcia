<?php

require_once 'vendor/autoload.php';
session_start();

$loader = new \Twig\Loader\FilesystemLoader('vista');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('base64_encode', 'base64_encode'));

try {
    $dsn = "mysql:host=dwes-db;dbname=CRUD";
    $pdo = PDO::connect($dsn, "root", "root"); 
} catch (PDOException $pdoe) {
    die("Error BBDD: ". $pdoe->getMessage());
}

require_once 'controlador/InicioController.php';
require_once 'controlador/AuthController.php';
require_once 'controlador/AdminController.php';

$ctl = $_GET['ctl'] ?? 'inicio';

try {
    switch ($ctl) {
        case 'inicio':
            (new InicioController($pdo, $twig))->index();
            break;
        case 'login':
            (new AuthController($pdo, $twig))->login();
            break;
        case 'logout':
            (new AuthController($pdo, $twig))->logout();
            break;
        case 'admin':
            (new AdminController($pdo, $twig))->index();
            break;
        case 'guardar_jugador':
            (new AdminController($pdo, $twig))->guardar();
            break;
        case 'borrar_jugador':
            (new AdminController($pdo, $twig))->borrar();
            break;
        case 'editar_jugador':
            (new AdminController($pdo, $twig))->editar();
            break;            
        case 'actualizar_jugador':
            (new AdminController($pdo, $twig))->actualizar();
            break;
        case 'editar_perfil':
            (new AdminController($pdo, $twig))->perfil();
            break;
        case 'guardar_perfil':
            (new AdminController($pdo, $twig))->guardarPerfil();
            break;
        case 'registro':
            (new AuthController($pdo, $twig))->registro();
            break;
        case 'guardar_registro':
            (new AuthController($pdo, $twig))->guardarRegistro();
            break;
        case 'eliminar_cuenta':
            (new AdminController($pdo, $twig))->eliminarCuenta();
            break;
        default:
            echo "Página no encontrada";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>