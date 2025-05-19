<?php
include __DIR__ . '/../model/basedatos.php';

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);

    if ($nombre && $email) {
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $email);
        if ($stmt->execute()) {
            $mensaje = "¡Cliente añadido exitosamente!";
        } else {
            $mensaje = "Error al añadir cliente: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../includes/header.php'; ?>
<body>
<?php include __DIR__ . '/../includes/barra-nav.php'; ?>

<div class="main tienda-cafe">
  <div class="topbar">
    <h1 class="titulo-top">Añadir Cliente</h1>
    <div class="close-icon">✖</div>
  </div>
  <header>
    <h2 class="titulo-seccion">Nuevo Cliente</h2>
    <span class="breadcrumb-cafe"><a href="/SRC/view/clientes.php" class="breadcrumb-cafe">Clientes</a> &gt; Añadir</span>
  </header>

  <section style="display: flex; justify-content: center; align-items: center; min-height: 60vh;">
    <form method="POST" style="background: #fffbe7; padding: 32px 32px 24px 32px; border-radius: 10px; box-shadow: 0 2px 8px rgba(111,78,55,0.12); border: 1px solid #d2b48c; min-width: 350px; max-width: 400px; width: 100%;">
      <h2 style="color: #6f4e37; font-family: 'Georgia', serif; margin-bottom: 20px;">Añadir Cliente</h2>
      <?php if ($mensaje): ?>
        <div style="margin-bottom: 16px; color: #388e3c; font-weight: bold;"><?php echo $mensaje; ?></div>
      <?php endif; ?>
      <div style="margin-bottom: 16px;">
        <label for="nombre" style="color: #6f4e37; font-weight: bold;">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;">
      </div>
      <div style="margin-bottom: 20px;">
        <label for="email" style="color: #6f4e37; font-weight: bold;">Email:</label><br>
        <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #d2b48c; margin-top: 4px;">
      </div>
      <div style="text-align: right;">
        <button type="submit" style="background: #388e3c; color: #fff; border: none; padding: 8px 18px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
          Guardar
        </button>
      </div>
    </form>
  </section>
  <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>

</body>
</html>