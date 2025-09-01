<?php
$mensaje = "";
$cita = null;

// Lista de médicos simulada
$medicos = [
    1 => "Dr. Juan Pérez",
    2 => "Dra. María López",
    3 => "Dr. Carlos Ramírez",
    4 => "Dra. Ana Torres"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $fecha  = trim($_POST["fecha"]);
    $hora   = trim($_POST["hora"]);
    $medico_id = trim($_POST["medico"]);

    if ($nombre == "" || $fecha == "" || $hora == "" || $medico_id == "") {
        $mensaje = "<p class='error'>⚠️ Debes completar todos los campos.</p>";
    } else {
        $mensaje = "<p class='exito'>✅ Cita registrada con éxito.</p>";
        $cita = [
            "nombre" => $nombre,
            "fecha"  => $fecha,
            "hora"   => $hora,
            "medico" => $medicos[$medico_id] ?? "Desconocido"
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Citas</title>
    <style>
        /* 🎨 Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* 🌐 Navbar */
        .navbar {
            width: 100%;
            background: #333;
            color: white;
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 20px;
        }

        .navbar nav a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar nav a:hover {
            color: #74ABE2;
        }

        /* 🎨 Fondo */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74ABE2, #5563DE);
            margin: 0;
            padding-top: 70px; /* para que no tape el navbar */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        /* 📦 Contenedor principal */
        .contenedor {
            background: #fff;
            padding: 30px 25px;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.15);
            width: 400px;
            animation: fadeIn 0.6s ease-in-out;
        }

        /* ✨ Animación suave */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* 🏷️ Título */
        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 24px;
        }

        /* 🔖 Labels */
        form label {
            display: block;
            margin: 12px 0 5px;
            font-weight: 600;
            color: #444;
        }

        /* ✍️ Inputs y selects */
        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border 0.3s, box-shadow 0.3s;
        }

        form input:focus, form select:focus {
            border: 1px solid #5563DE;
            box-shadow: 0px 0px 5px rgba(85, 99, 222, 0.5);
            outline: none;
        }

        /* 🔘 Botón */
        button {
            width: 100%;
            padding: 12px;
            background: #5563DE;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background: #3f4bbd;
            transform: scale(1.05);
        }

        /* ⚠️ Mensajes */
        .error {
            background: #ffe0e0;
            color: #a94442;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            border: 1px solid #f5c2c2;
        }

        .exito {
            background: #e0ffe5;
            color: #2d7a35;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            border: 1px solid #b6e2b9;
        }

        /* 📋 Tarjeta de cita registrada */
        .tarjeta {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f4f6ff;
            border: 1px solid #ccd4ff;
        }

        .tarjeta h3 {
            margin-top: 0;
            color: #333;
        }

        .tarjeta p {
            margin: 5px 0;
            color: #444;
        }
    </style>
</head>
<body>
    <!-- 🌐 Navbar -->
    <div class="navbar">
        <h2>🏥 Sistema Médico</h2>
        <nav>
            <a href="#">Inicio</a>
            <a href="#">Citas</a>
            <a href="#">Pacientes</a>
            <a href="#">Doctores</a>
        </nav>
    </div>

    <!-- 📋 Formulario -->
    <div class="contenedor">
        <h1>📅 Registro de Citas</h1>
        
        <?php echo $mensaje; ?>

        <form method="POST" action="">
            <label for="nombre">👤 Nombre del paciente:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="fecha">📆 Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="hora">⏰ Hora:</label>
            <input type="time" id="hora" name="hora" required>

            <label for="medico">🩺 Médico:</label>
            <select id="medico" name="medico" required>
                <option value="">-- Seleccionar Médico --</option>
                <?php foreach ($medicos as $id => $nombre): ?>
                    <option value="<?= $id ?>"><?= $nombre ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Registrar Cita</button>
        </form>

        <?php if ($cita): ?>
            <div class="tarjeta">
                <h3>📌 Detalle de la Cita</h3>
                <p><strong>Paciente:</strong> <?= htmlspecialchars($cita["nombre"]) ?></p>
                <p><strong>Fecha:</strong> <?= htmlspecialchars($cita["fecha"]) ?></p>
                <p><strong>Hora:</strong> <?= htmlspecialchars($cita["hora"]) ?></p>
                <p><strong>Médico:</strong> <?= htmlspecialchars($cita["medico"]) ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
