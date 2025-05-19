<?php
include __DIR__ . '/../model/basedatos.php';

// Eliminar cliente si se envía el formulario
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $mensaje = "Cliente eliminado exitosamente.";
    } else {
        $mensaje = "Error al eliminar cliente: " . $conn->error;
    }
    $stmt->close();
}

$clientes = $conn->query("SELECT id, nombre, email FROM clientes");
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
    <h1 class="titulo-top">Clientes</h1>
    <div class="close-icon">✖</div>
  </div>
  <header>
    <h2 class="titulo-seccion">Listado de Clientes</h2>
  </header>

  <section style="margin-bottom: 20px; text-align: right;">
    <a href="add-clientes.php" style="background:#388e3c; color:#fff; padding:8px 16px; border-radius:5px; text-decoration:none; font-weight:bold;">Añadir Cliente</a>
  </section>

  <section class="galeria">
    <?php if ($clientes && $clientes->num_rows > 0): ?>
      <?php while ($cliente = $clientes->fetch_assoc()): ?>
        <div class="producto-cafe">
          <img src="https://img.icons8.com/ios/100/user.png" alt="Cliente" />
          <h4><?php echo htmlspecialchars($cliente['nombre']); ?></h4>
          <p style="color:#6f4e37;"><?php echo htmlspecialchars($cliente['email']); ?></p>
          <div style="margin-top: 10px; display: flex; gap: 8px; justify-content: center;">
            <a href="editar-cliente.php?id=<?php echo $cliente['id']; ?>" style="background:#1976d2; color:#fff; padding:6px 12px; border-radius:4px; text-decoration:none;">Editar</a>
            <form method="POST" action="" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');">
              <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
              <button type="submit" style="background:#b71c1c; color:#fff; border:none; padding:6px 12px; border-radius:4px; cursor:pointer;">Eliminar</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No hay clientes registrados.</p>
    <?php endif; ?>
  </section>
  <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>