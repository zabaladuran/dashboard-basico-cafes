<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../includes/header.php'; ?>
<body>
  <?php include __DIR__ . '/../includes/barra-nav.php'; ?>
  

  <!-- Contenedor Principal -->
  <div class="main tienda-cafe">
    <!-- Encabezado horizontal -->
    <div class="topbar">
      <h1 class="titulo-top">Electiva Profesional</h1>
      <div class="close-icon">✖</div>
    </div>

    <!-- Contenido central -->
    <header>
      <h2 class="titulo-seccion">Home</h2>
      <span class="breadcrumb-cafe">Cafes &gt; Home</span>
    </header>

    <?php include __DIR__ . '/../model/basedatos.php'; ?>

    <!-- Sección de resumen -->
    <section class="resumen">
      <?php
        // Total Cafés
        $resCafes = $conn->query("SELECT COUNT(*) as total FROM cafes");
        $totalCafes = $resCafes ? $resCafes->fetch_assoc()['total'] : 0;

        // Total Clientes
        $resClientes = $conn->query("SELECT COUNT(*) as total FROM clientes");
        $totalClientes = $resClientes ? $resClientes->fetch_assoc()['total'] : 0;

        // Total Ventas
        $resVentas = $conn->query("SELECT COUNT(*) as total FROM ventas");
        $totalVentas = $resVentas ? $resVentas->fetch_assoc()['total'] : 0;
      ?>
      <div class="resumen-cafe">
        <h3>Cafes</h3>
        <p class="dato-principal">#<?php echo $totalCafes; ?></p>
        <small>Total Cafes</small>
      </div>
      <div class="resumen-cafe">
        <h3>Clientes</h3>
        <p class="dato-principal">#<?php echo $totalClientes; ?></p>
        <small>Total Clientes</small>
      </div>
      <div class="resumen-cafe">
        <h3>Ventas</h3>
        <p class="dato-principal">#<?php echo $totalVentas; ?></p>
        <small>Total Ventas</small>
      </div>
    </section>

    <!-- Sección de productos -->
    <section class="galeria">
      <?php
        $cafes = $conn->query("SELECT nombre, precio, descripcion FROM cafes");
        if ($cafes && $cafes->num_rows > 0):
          while ($cafe = $cafes->fetch_assoc()):
      ?>
        <div class="producto-cafe">
          <img src="https://img.icons8.com/ios/100/coffee.png" alt="Café" />
          <h4><?php echo htmlspecialchars($cafe['nombre']); ?></h4>
          <p class="precio-cafe">$<?php echo number_format($cafe['precio'], 0, ',', '.'); ?></p>
          <small><?php echo htmlspecialchars($cafe['descripcion']); ?></small>
        </div>
      <?php
          endwhile;
        else:
      ?>
        <p>No hay cafés registrados.</p>
      <?php endif; ?>
    </section>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
  </div>
</body>
</html>
