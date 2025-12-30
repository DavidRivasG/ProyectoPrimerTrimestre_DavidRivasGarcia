<?php
class Jugador {
    private $pdo;

    public function __construct($pdo) { $this->pdo = $pdo; }

    // Devuelve todos los jugadores de la tabla sin ningún filtro
    public function obtenerTodos() {
        return $this->pdo->query("SELECT * FROM jugadores")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca y devuelve solo los jugadores que pertenecen a un equipo concreto
    public function obtenerPorEquipo($equipo) {
        $stmt = $this->pdo->prepare("SELECT * FROM jugadores WHERE equipo = :equipo");
        $stmt->execute([':equipo' => $equipo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve la lista de resultados
    }

    // Inserta un nuevo jugador en la base de datos recibiendo todos sus datos en un array
    public function insertar($datos) {
        $sql = "INSERT INTO jugadores (nombre, edad, posicion, pais, dorsal, altura, peso, equipo) 
                VALUES (:nombre, :edad, :posicion, :pais, :dorsal, :altura, :peso, :equipo)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($datos);
    }

    // Elimina un jugador de la base de datos buscando por su ID único
    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM jugadores WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Obtiene los datos de un solo jugador por su ID (útil para rellenar el formulario de edición)
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM jugadores WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // fetch devuelve solo una fila
    }

    // Modifica los datos de un jugador existente en la base de datos, devuelve true si se actualizó correctamente
    public function actualizar($datos) {
        $sql = "UPDATE jugadores SET 
                    nombre = :nombre, 
                    edad = :edad, 
                    posicion = :posicion, 
                    pais = :pais, 
                    dorsal = :dorsal, 
                    altura = :altura, 
                    peso = :peso 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($datos);
    }

    // Borrar TODOS los jugadores de un equipo
    public function eliminarTodosDelEquipo($equipo) {
        $stmt = $this->pdo->prepare("DELETE FROM jugadores WHERE equipo = :equipo");
        return $stmt->execute([':equipo' => $equipo]);
    }
}
?>