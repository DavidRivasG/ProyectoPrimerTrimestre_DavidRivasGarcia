<?php
require_once 'modelo/Equipo.php';
require_once 'modelo/Jugador.php';

class InicioController {
    private $pdo;
    private $twig;

    //Aquí no compruebo sesion porque esta pagina es publica
    public function __construct($pdo, $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }

    // Metodo principal que carga la pagina de inicio
    public function index() {
        $equipos = (new Equipo($this->pdo))->obtenerTodos();
        
        $jugadores = (new Jugador($this->pdo))->obtenerTodos();
        
        echo $this->twig->render('inicio.html.twig', [
            'equipos' => $equipos,
            'jugadores' => $jugadores
        ]);
    }
}
?>