<?php
include __DIR__ . '/../model/basedatos.php';

// Procesar eliminación si se envía el formulario
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    // Eliminar ventas asociadas
    $conn->query("DELETE FROM ventas WHERE cafe_id=$id");
    // Ahora eliminar el café
    $stmt = $conn->prepare("DELETE FROM cafes WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $mensaje = "Café eliminado exitosamente.";
    } else {
        $mensaje = "Error al eliminar café: " . $conn->error;
    }
    $stmt->close();
}

$cafes = $conn->query("SELECT id, nombre, precio, descripcion FROM cafes");
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../includes/header.php'; ?>
<body>
<?php include __DIR__ . '/../includes/barra-nav.php'; ?>

<?php if ($mensaje): ?>
  <div style="background:#dff0d8; color:#3c763d; padding:10px 20px; margin:20px; border-radius:5px; text-align:center; font-weight:bold;">
    <?php echo $mensaje; ?>
  </div>
<?php endif; ?>

<div class="main tienda-cafe">
  <div class="topbar">
    <h1 class="titulo-top">Retirar Café</h1>
    <div class="close-icon">✖</div>
  </div>
  <header>
    <h2 class="titulo-seccion">Listado de Cafés</h2>
  </header>

  <section class="galeria">
    <?php if ($cafes && $cafes->num_rows > 0): ?>
      <?php while ($cafe = $cafes->fetch_assoc()): ?>
        <div class="producto-cafe">
          <img src="https://img.icons8.com/ios/100/coffee.png" alt="Café" />
          <h4><?php echo htmlspecialchars($cafe['nombre']); ?></h4>
          <p class="precio-cafe">$<?php echo number_format($cafe['precio'], 0, ',', '.'); ?></p>
          <small><?php echo htmlspecialchars($cafe['descripcion']); ?></small>
          <div style="margin-top: 10px; display: flex; gap: 8px; justify-content: center;">
            <form method="POST" action="" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este café?');">
              <input type="hidden" name="id" value="<?php echo $cafe['id']; ?>">
              <button type="submit" style="background:#b71c1c; color:#fff; border:none; padding:6px 12px; border-radius:4px; cursor:pointer;">Eliminar</button>
            </form>
            <a href="editar-cafe.php?id=<?php echo $cafe['id']; ?>" style="background:#388e3c; color:#fff; padding:6px 12px; border-radius:4px; text-decoration:none;">Editar</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No hay cafés registrados.</p>
    <?php endif; ?>
  </section>
  <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>