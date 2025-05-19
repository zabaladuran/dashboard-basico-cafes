<?php
include __DIR__ . '/../model/basedatos.php';

$mensaje = "";

// Obtener el ID del café
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si no hay ID, redirigir o mostrar error
if ($id <= 0) {
    die("ID de café no válido.");
}

// Procesar el formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $precio = trim($_POST["precio"]);
    $descripcion = trim($_POST["descripcion"]);

    if ($nombre && $precio) {
        $stmt = $conn->prepare("UPDATE cafes SET nombre=?, precio=?, descripcion=? WHERE id=?");
        $stmt->bind_param("sdsi", $nombre, $precio, $descripcion, $id);
        if ($stmt->execute()) {
            $mensaje = "¡Café actualizado exitosamente!";
        } else {
            $mensaje = "Error al actualizar café: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Por favor, completa los campos obligatorios.";
    }
}

// Obtener los datos actuales del café
$stmt = $conn->prepare("SELECT nombre, precio, descripcion FROM cafes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nombre, $precio, $descripcion);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../includes/header.php'; ?>
<body>
    <?php include __DIR__ . '/../includes/barra-nav.php'; ?>

    <div class="main tienda-cafe">
      <div class="topbar">
        <h1 class="titulo-top">Editar Café</h1>
        <div class="close-icon">✖</div>
      </div>

      <header>
        <h2 class="titulo-seccion">Editar Café</h2>
        <span class="breadcrumb-cafe"><a href="/SRC/view/retirar-cafe.php" class="breadcrumb-cafe">Cafes</a> &gt; Editar</span>
      </header>

      <section style="display: flex; justify-content: center; align-items: center; min-height: 60vh;">
        <form method="POST" style="background: #fffbe7; padding: 32px 32px 24px 32px; border-radius: 10px; box-shadow: 0 2px 8px rgba(111,78,55,0.12); border: 1px solid #d2b48c; min-width: 350px; max-width: 400px; width: 100%;">
          <h2 style="color: #6f4e37; font-family: 'Georgia', serif; margin-bottom: 20px;">Editar Café</h2>
          <?php if ($mensaje): ?>
            <div style="margin-bottom: 16px; color: #388e3c; font-weight: bold;"><?php echo $mensaje; ?></div>
          <?php endif; ?>
          <div style="margin-bottom: 16px;">
            <label for="nombre" style="color: #6f4e37; font-weight: bold;">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;">
          </div>
          <div style="margin-bottom: 16px;">
            <label for="precio" style="color: #6f4e37; font-weight: bold;">Precio</label><br>
            <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($precio); ?>" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;">
          </div>
          <div style="margin-bottom: 20px;">
            <label for="descripcion" style="color: #6f4e37; font-weight: bold;">Descripcion</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;"><?php echo htmlspecialchars($descripcion); ?></textarea>
          </div>
          <div style="text-align: right;">
            <button type="submit" style="background: #388e3c; color: #fff; border: none; padding: 8px 18px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
              Guardar Cambios
            </button>
          </div>
        </form>
      </section>
      <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>
</html>