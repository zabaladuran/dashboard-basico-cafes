<?php
include __DIR__ . '/../model/basedatos.php';

$mensaje = "";

// Obtener el ID del cliente
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("ID de cliente no válido.");
}

// Procesar el formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);

    if ($nombre && $email) {
        $stmt = $conn->prepare("UPDATE clientes SET nombre=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $nombre, $email, $id);
        if ($stmt->execute()) {
            $mensaje = "¡Cliente actualizado exitosamente!";
        } else {
            $mensaje = "Error al actualizar cliente: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}

// Obtener los datos actuales del cliente
$stmt = $conn->prepare("SELECT nombre, email FROM clientes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nombre, $email);
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
    <h1 class="titulo-top">Editar Cliente</h1>
    <div class="close-icon">✖</div>
  </div>
  <header>
    <h2 class="titulo-seccion">Editar Cliente</h2>
    <span class="breadcrumb-cafe"><a href="/SRC/view/clientes.php" class="breadcrumb-cafe">Clientes</a> &gt; Editar</span>
  </header>

  <section style="display: flex; justify-content: center; align-items: center; min-height: 60vh;">
    <form method="POST" style="background: #fffbe7; padding: 32px 32px 24px 32px; border-radius: 10px; box-shadow: 0 2px 8px rgba(111,78,55,0.12); border: 1px solid #d2b48c; min-width: 350px; max-width: 400px; width: 100%;">
      <h2 style="color: #6f4e37; font-family: 'Georgia', serif; margin-bottom: 20px;">Editar Cliente</h2>
      <?php if ($mensaje): ?>
        <div style="margin-bottom: 16px; color: #388e3c; font-weight: bold;"><?php echo $mensaje; ?></div>
      <?php endif; ?>
      <div style="margin-bottom: 16px;">
        <label for="nombre" style="color: #6f4e37; font-weight: bold;">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;">
      </div>
      <div style="margin-bottom: 20px;">
        <label for="email" style="color: #6f4e37; font-weight: bold;">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;">
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