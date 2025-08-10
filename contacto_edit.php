<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
require "./includes/contactos_app.php";

$contacto_id = $_POST['contacto_id'] ?? '';
$nombre = '';
$telefono = '';
$email = '';
$usuario_id = $_SESSION['usuario_id'];

if ($contacto_id) {
    try {
        $sql = "SELECT nombre, telefono, email FROM contactos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $contacto_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($contacto) {
            $nombre = $contacto['nombre'];
            $telefono = $contacto['telefono'];
            $email = $contacto['email'];
        } else {
            echo "Contacto no encontrado o no tienes permiso para editarlo.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    $contacto_id = $_POST['contacto_id'];
    $nombre_nuevo = $_POST['nombre_contacto'];
    $telefono_nuevo = $_POST['telefono_contacto'];
    $email_nuevo = $_POST['email_contacto'];

    try {
        $sql = "UPDATE contactos SET nombre = :nombre, telefono = :telefono, email = :email WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_nuevo);
        $stmt->bindParam(':telefono', $telefono_nuevo);
        $stmt->bindParam(':email', $email_nuevo);
        $stmt->bindParam(':id', $contacto_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        header("Location: panel_usuario.php");
        exit();
    } catch(PDOException $e) {
        echo "Error al actualizar el contacto: " . $e->getMessage();
    }
}
?>
<h1>Editar Contacto</h1>
<form action="contacto_edit.php" method="POST">
    <input type="hidden" name="contacto_id" value="<?php echo htmlspecialchars($contacto_id); ?>">
    <label for="nombre_contacto">Nombre:</label><br>
    <input type="text" id="nombre_contacto" name="nombre_contacto" value="<?php echo htmlspecialchars($nombre); ?>" required><br><br>
    <label for="telefono_contacto">Teléfono:</label><br>
    <input type="tel" id="telefono_contacto" name="telefono_contacto" value="<?php echo htmlspecialchars($telefono); ?>"><br><br>
    <label for="email_contacto">Correo electrónico:</label><br>
    <input type="email" id="email_contacto" name="email_contacto" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
    <button type="submit" name="guardar_cambios">Guardar Cambios</button>
</form>
<br><a href="panel_usuario.php">Volver a mis contactos</a>