<?php
class Equipo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Devuelve la lista completa de equipos
    public function obtenerTodos() {
        return $this->pdo->query("SELECT * FROM equipos")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca un equipo específico por su nombre que es la clave primaria
    // Se usa para cargar el perfil del equipo en el panel de gestión
    public function obtenerPorNombre($nombre) {
        $sql = "SELECT * FROM equipos WHERE nombre = :nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualiza los datos editables del equipo (Ciudad, Estadio, etc.)
    // Nota: No actualiza el 'nombre' (porque es ID) ni el 'escudo' (foto) en esta función
    public function actualizar($nombre, $ciudad, $estadio, $fundacion, $entrenador, $pais) {
        $sql = "UPDATE equipos SET 
                    ciudad = :ciudad, 
                    estadio = :estadio, 
                    anio_fundacion = :fundacion, 
                    entrenador = :entrenador,
                    pais = :pais
                WHERE nombre = :nombre";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':ciudad' => $ciudad,
            ':estadio' => $estadio,
            ':fundacion' => $fundacion,
            ':entrenador' => $entrenador,
            ':pais' => $pais,
            ':nombre' => $nombre
        ]);
    }

    // Registra un NUEVO equipo completo en la base de datos
    // Aquí sí guardamos el escudo (imagen binaria) que sube el usuario
    public function insertar($nombre, $fundacion, $pais, $ciudad, $estadio, $escudo, $entrenador) {
        $sql = "INSERT INTO equipos (nombre, anio_fundacion, pais, ciudad, estadio, escudo, entrenador) 
                VALUES (:nombre, :fundacion, :pais, :ciudad, :estadio, :escudo, :entrenador)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':fundacion' => $fundacion,
            ':pais' => $pais,
            ':ciudad' => $ciudad,
            ':estadio' => $estadio,
            ':escudo' => $escudo,
            ':entrenador' => $entrenador
        ]);
    }

    // Borrar el equipo
    public function eliminar($nombre) {
        $stmt = $this->pdo->prepare("DELETE FROM equipos WHERE nombre = :nombre");
        return $stmt->execute([':nombre' => $nombre]);
    }
}
?>