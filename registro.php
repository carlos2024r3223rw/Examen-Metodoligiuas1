<?php
// Incluir la conexión a la base de datos
require_once 'cn.php';

// Procesar formulario
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad_id = $_POST['especialidad'];
    $horarioInicio = $_POST['horarioInicio'];
    $horarioFin = $_POST['horarioFin'];

    // Armar fecha y hora completa (se puede usar una fecha base cualquiera)
    $inicio = "2000-01-01 " . $horarioInicio . ":00";
    $fin = "2000-01-01 " . $horarioFin . ":00";

    $sql = "INSERT INTO doctores (nombre, apellidos, horario_atencion_inicio, horario_atencion_fin, especialidad_id)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $apellido, $inicio, $fin, $especialidad_id);

    if ($stmt->execute()) {
        $mensaje = "✅ ¡Médico registrado exitosamente!";
    } else {
        $mensaje = "❌ Error al registrar: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener especialidades
$especialidades = [];
$result = $conn->query("SELECT id, nombre FROM especialidades");
while ($row = $result->fetch_assoc()) {
    $especialidades[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Médico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .bg-custom {
      background-color: #f8f9fa;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="bg-custom">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Sistema Médico</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="registro_medico.php">Registro Médico</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4">
          <h2 class="text-center mb-4">Registro de Médico</h2>
          <form method="POST" action="registro_medico.php">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="col-md-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="especialidad" class="form-label">Especialidad</label>
              <select class="form-select" id="especialidad" name="especialidad" required>
                <option value="" selected disabled>Seleccione una especialidad</option>
                <?php foreach ($especialidades as $esp): ?>
                  <option value="<?= $esp['id'] ?>"><?= htmlspecialchars($esp['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="horarioAtencion" class="form-label">Horario de Atención</label>
              <div class="row">
                <div class="col-md-6 mb-2">
                  <label for="horarioInicio" class="form-label">Hora de inicio</label>
                  <input type="time" class="form-control" id="horarioInicio" name="horarioInicio" required>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="horarioFin" class="form-label">Hora de finalización</label>
                  <input type="time" class="form-control" id="horarioFin" name="horarioFin" required>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary">Guardar Registro</button>
              <a href="index.php" class="btn btn-secondary">Volver</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
