<?php
require_once 'modelo/Jugador.php';

class AdminController {
    private $pdo;
    private $twig;

    // Si el usuario no ha iniciado sesión, lo redirige al login inmediatamente
    public function __construct($pdo, $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?ctl=login");
            exit();
        }
    }

    // Página principal del panel de administración
    // Muestra la lista de jugadores que pertenecen SOLAMENTE al equipo logueado
    public function index() {
        $jugadores = (new Jugador($this->pdo))->obtenerPorEquipo($_SESSION['mi_equipo']);
        echo $this->twig->render('admin/lista.html.twig', [
            'jugadores' => $jugadores,
            'equipo' => $_SESSION['mi_equipo']
        ]);
    }

    // Procesa el formulario para crea un nuevo jugador
    public function guardar() {
        if ($_POST) {
            $datos = [
                ':nombre' => $_POST['nombre'], ':edad' => $_POST['edad'],
                ':posicion' => $_POST['posicion'], ':pais' => $_POST['pais'],
                ':dorsal' => $_POST['dorsal'], ':altura' => $_POST['altura'],
                ':peso' => $_POST['peso'], ':equipo' => $_SESSION['mi_equipo']
            ];
            (new Jugador($this->pdo))->insertar($datos);
            header("Location: index.php?ctl=admin");
        }
    }

    // Elimina un jugador por su ID
    public function borrar() {
        if (isset($_GET['id'])) {
            (new Jugador($this->pdo))->eliminar($_GET['id']);
            header("Location: index.php?ctl=admin");
        }
    }

    // Muestra el formulario de edición cargando los datos del jugador existente
    public function editar() {
        if (isset($_GET['id'])) {
            $modelo = new Jugador($this->pdo);
            $jugador = $modelo->obtenerPorId($_GET['id']);

            if ($jugador && $jugador['equipo'] == $_SESSION['mi_equipo']) {
                echo $this->twig->render('admin/form_editar.html.twig', [
                    'jugador' => $jugador,
                    'equipo' => $_SESSION['mi_equipo']
                ]);
            } else {
                header("Location: index.php?ctl=admin");
            }
        }
    }

    // Procesa el formulario de edición
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $modelo = new Jugador($this->pdo);
            
            $datos = [
                ':id'       => $_POST['id'],
                ':nombre'   => $_POST['nombre'], 
                ':edad'     => $_POST['edad'],
                ':posicion' => $_POST['posicion'], 
                ':pais'     => $_POST['pais'],
                ':dorsal'   => $_POST['dorsal'], 
                ':altura'   => $_POST['altura'],
                ':peso'     => $_POST['peso']
            ];

            $modelo->actualizar($datos);
            
            header("Location: index.php?ctl=admin");
        }
    }

    // Muestra el formulario con los datos actuales del perfil del equipo
    public function perfil() {
        require_once 'modelo/Equipo.php';
        $modeloEquipo = new Equipo($this->pdo);
        
        $datosEquipo = $modeloEquipo->obtenerPorNombre($_SESSION['mi_equipo']);

        echo $this->twig->render('admin/form_perfil.html.twig', [
            'equipo' => $datosEquipo
        ]);
    }

    // Guarda los cambios del perfil del equipo
    public function guardarPerfil() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'modelo/Equipo.php';
            $modelo = new Equipo($this->pdo);

            $modelo->actualizar(
                $_SESSION['mi_equipo'],
                $_POST['ciudad'],
                $_POST['estadio'],
                $_POST['anio_fundacion'],
                $_POST['entrenador'],
                $_POST['pais']
            );

            header("Location: index.php?ctl=admin");
        }
    }

    public function eliminarCuenta() {
        // Doble seguridad: Solo si está logueado (ya lo comprueba el constructor, pero por si acaso)
        if (isset($_SESSION['mi_equipo'])) {
            $equipo = $_SESSION['mi_equipo'];

            (new Jugador($this->pdo))->eliminarTodosDelEquipo($equipo);

            require_once 'modelo/Usuario.php';
            (new Usuario($this->pdo))->eliminarPorEquipo($equipo);

            require_once 'modelo/Equipo.php';
            (new Equipo($this->pdo))->eliminar($equipo);

            session_destroy();
            header("Location: index.php");
            exit();
        }
    }
}
?>