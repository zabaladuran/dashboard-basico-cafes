<?php
include __DIR__ . '/../model/basedatos.php';

$mensaje = "";

// Procesar el formulario de nueva venta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cafe_id = intval($_POST["cafe_id"]);
    $cliente_id = intval($_POST["cliente_id"]);
    $cantidad = intval($_POST["cantidad"]);

    if ($cafe_id && $cliente_id && $cantidad > 0) {
        $stmt = $conn->prepare("INSERT INTO ventas (cafe_id, cliente_id, cantidad) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $cafe_id, $cliente_id, $cantidad);
        if ($stmt->execute()) {
            $mensaje = "¡Venta registrada exitosamente!";
        } else {
            $mensaje = "Error al registrar la venta: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}

// Obtener cafés y clientes para el formulario
$cafes = $conn->query("SELECT id, nombre FROM cafes");
$clientes = $conn->query("SELECT id, nombre FROM clientes");

// Obtener ventas para mostrar detalles
$ventas = $conn->query("
    SELECT v.id, c.nombre AS cafe, cl.nombre AS cliente, v.cantidad, v.fecha
    FROM ventas v
    JOIN cafes c ON v.cafe_id = c.id
    JOIN clientes cl ON v.cliente_id = cl.id
    ORDER BY v.fecha DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../includes/header.php'; ?>
<body>
<?php include __DIR__ . '/../includes/barra-nav.php'; ?>

<div class="main tienda-cafe">
  <div class="topbar">
    <h1 class="titulo-top">Ventas</h1>
    <div class="close-icon">✖</div>
  </div>
  <header>
    <h2 class="titulo-seccion">Registrar Venta</h2>
  </header>

  <?php if ($mensaje): ?>
    <div style="background:#dff0d8; color:#3c763d; padding:10px 20px; margin:20px; border-radius:5px; text-align:center; font-weight:bold;">
      <?php echo $mensaje; ?>
    </div>
  <?php endif; ?>

  <section style="display: flex; justify-content: center; align-items: center; min-height: 30vh;">
    <form method="POST" style="background: #fffbe7; padding: 24px; border-radius: 10px; box-shadow: 0 2px 8px rgba(111,78,55,0.12); border: 1px solid #d2b48c; min-width: 320px;">
      <div style="margin-bottom: 16px;">
        <label for="cafe_id" style="color: #6f4e37; font-weight: bold;">Café:</label><br>
        <select id="cafe_id" name="cafe_id" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c;">
          <option value="">Seleccione un café</option>
          <?php while($cafe = $cafes->fetch_assoc()): ?>
            <option value="<?php echo $cafe['id']; ?>"><?php echo htmlspecialchars($cafe['nombre']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div style="margin-bottom: 16px;">
        <label for="cliente_id" style="color: #6f4e37; font-weight: bold;">Cliente:</label><br>
        <select id="cliente_id" name="cliente_id" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c;">
          <option value="">Seleccione un cliente</option>
          <?php while($cliente = $clientes->fetch_assoc()): ?>
            <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div style="margin-bottom: 20px;">
        <label for="cantidad" style="color: #6f4e37; font-weight: bold;">Cantidad:</label><br>
        <input type="number" id="cantidad" name="cantidad" min="1" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c;">
      </div>
      <div style="text-align: right;">
        <button type="submit" style="background: #388e3c; color: #fff; border: none; padding: 8px 18px; border-radius: 5px; font-weight: bold; cursor: pointer;">
          Registrar Venta
        </button>
      </div>
    </form>
  </section>

  <header>
    <h2 class="titulo-seccion" style="margin-top:40px;">Detalles de Ventas</h2>
  </header>
  <section>
    <table style="width:100%; background:#fffbe7; border-radius:8px; border:1px solid #d2b48c; margin-top:10px;">
      <thead>
        <tr style="background:#d2b48c; color:#6f4e37;">
          <th style="padding:8px;">ID</th>
          <th style="padding:8px;">Café</th>
          <th style="padding:8px;">Cliente</th>
          <th style="padding:8px;">Cantidad</th>
          <th style="padding:8px;">Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($ventas && $ventas->num_rows > 0): ?>
          <?php while($venta = $ventas->fetch_assoc()): ?>
            <tr>
              <td style="padding:8px;"><?php echo $venta['id']; ?></td>
              <td style="padding:8px;"><?php echo htmlspecialchars($venta['cafe']); ?></td>
              <td style="padding:8px;"><?php echo htmlspecialchars($venta['cliente']); ?></td>
              <td style="padding:8px;"><?php echo $venta['cantidad']; ?></td>
              <td style="padding:8px;"><?php echo $venta['fecha']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" style="text-align:center; padding:12px;">No hay ventas registradas.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </section>
  <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>