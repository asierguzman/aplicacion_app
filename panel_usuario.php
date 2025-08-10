<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
require "./includes/contactos_app.php";

$usuario_id = $_SESSION['usuario_id'];
$nombre_usuario = "";

try {
    $stmt = $conexion->prepare("SELECT nombre FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario) {
        $nombre_usuario = $usuario['nombre'];
    }
} catch(PDOException $e) {
    echo "<p style='color:red;'>Error al obtener el nombre del usuario: " . $e->getMessage() . "</p>";
}

// Lógica para ELIMINAR un contacto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_contacto'])) {
    $contacto_id = $_POST['contacto_id'];
    try {
        $stmt = $conexion->prepare("DELETE FROM contactos WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->bindParam(':id', $contacto_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Contacto eliminado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al eliminar el contacto.</p>";
        }
    } catch(PDOException $e) {
        echo "<p style='color:red;'>Error de base de datos al eliminar: " . $e->getMessage() . "</p>";
    }
}
?>
<p>Hola, <?php echo htmlspecialchars($nombre_usuario); ?></p>
<h2>Tus Contactos:</h2>
<form action="contacto_add.php">
    <button type="submit">Agregar Nuevo Contacto</button>
</form>
<br>
<?php
try {
    $stmt = $conexion->prepare("SELECT id, nombre, email, telefono, fecha_creacion FROM contactos WHERE usuario_id = :usuario_id");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($contactos) > 0) {
        foreach ($contactos as $contacto) {
            echo "<div>";
            echo "<strong>Nombre:</strong> " . htmlspecialchars($contacto["nombre"]) . 
                 " - Email: " . htmlspecialchars($contacto["email"]) . 
                 " - Teléfono: " . htmlspecialchars($contacto["telefono"]) .
                 " - Fecha de creación: " . htmlspecialchars($contacto["fecha_creacion"]) . " ";
            
            echo "<form action='contacto_edit.php' method='POST' style='display:inline-block;'>";
            echo "<input type='hidden' name='contacto_id' value='" . htmlspecialchars($contacto["id"]) . "'>";
            echo "<button type='submit'>Editar</button>";
            echo "</form>";

            echo "<form action='panel_usuario.php' method='POST' style='display:inline-block;' onsubmit='return confirm(\"¿Estás seguro de que quieres eliminar este contacto?\");'>";
            echo "<input type='hidden' name='contacto_id' value='" . htmlspecialchars($contacto["id"]) . "'>";
            echo "<button type='submit' name='eliminar_contacto'>Eliminar</button>";
            echo "</form>";
            echo "<br><hr>";
            echo "</div>";
        }
    } else {
        echo "<p>No tienes contactos aún.</p>";
    }
} catch(PDOException $e) {
    echo "<p style='color:red;'>Error al obtener la lista de contactos: " . $e->getMessage() . "</p>";
}
?>
<form action="logout.php">
    <button>Cerrar sesión</button>
</form>