<?php
require_once 'modelo/Usuario.php';

class AuthController {
    private $pdo;
    private $twig;

    public function __construct($pdo, $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }

    // Gestiona el inicio de sesión (Login)
    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = (new Usuario($this->pdo))->validarLogin($_POST['email'], $_POST['password']);
            
            if ($user) {
                $_SESSION['usuario'] = $user['email'];
                $_SESSION['mi_equipo'] = $user['equipo'];
                
                header("Location: index.php?ctl=admin");
                exit();
            }
            $error = "Credenciales incorrectas";
        }
        echo $this->twig->render('login.html.twig', ['error' => $error]);
    }

    // Cierra la sesión del usuario
    public function logout() {
        session_destroy();
        header("Location: index.php");
    }

    // Muestra el formulario de registro
    public function registro() {
        echo $this->twig->render('registro.html.twig');
    }

    // Procesa el registro de un nuevo equipo y su usuario
    public function guardarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $escudoBlob;
            if (isset($_FILES['escudo']) && $_FILES['escudo']['error'] === UPLOAD_ERR_OK) {
                // Leemos el archivo y lo convertimos a datos binarios para guardar en BLOB
                $escudoBlob = file_get_contents($_FILES['escudo']['tmp_name']);
            } else {
                die("Error: Debes subir un escudo.");
            }

            try {
                require_once 'modelo/Equipo.php';
                $modeloEquipo = new Equipo($this->pdo);
                
                $modeloEquipo->insertar(
                    $_POST['nombre'],
                    $_POST['anio'],
                    $_POST['pais'],
                    $_POST['ciudad'],
                    $_POST['estadio'],
                    $escudoBlob,
                    $_POST['entrenador']
                );

                require_once 'modelo/Usuario.php';
                $modeloUsuario = new Usuario($this->pdo);
                
                $modeloUsuario->registrar(
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['nombre']
                );

                header("Location: index.php?ctl=login");

            } catch (Exception $e) {
                echo "Error al registrar: " . $e->getMessage();
            }
        }
    }
}
?>