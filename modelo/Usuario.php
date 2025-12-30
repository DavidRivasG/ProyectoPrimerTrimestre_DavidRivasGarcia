<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // LOGIN: Verificar credenciales
    public function validarLogin($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['contraseña'])) {
            return $usuario;
        }

        return false;
    }

    // REGISTRO: Crear nuevo usuario
    public function registrar($email, $password, $equipoNombre) {
        $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (email, contraseña, equipo) VALUES (:email, :pass, :equipo)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':email' => $email,
            ':pass' => $passwordEncriptada,
            ':equipo' => $equipoNombre
        ]);
    }

    // Borrar el usuario asociado al equipo
    public function eliminarPorEquipo($equipo) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE equipo = :equipo");
        return $stmt->execute([':equipo' => $equipo]);
    }
}
?>