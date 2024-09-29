<?php
session_start();

if (!isset($_SESSION['trabajadores'])) {
    $_SESSION['trabajadores'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $puesto = $_POST['puesto'] ?? '';
    
    if ($nombre && $puesto) {
        $_SESSION['trabajadores'][] = [
            'nombre' => $nombre,
            'puesto' => $puesto
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Trabajadores - Inventario Pronti Broaster</title>
</head>
<body>
    <header>
        <h1>Inventario Pronti Broaster</h1>
    </header>
    <div class="container">
        <nav>
            <ul>
                <li><a href="../views/trabajadores.php">Trabajadores</a></li>
                <li><a href="../views/pedidos.php">Pedidos</a></li>
                <li><a href="../views/proveedores.php">Proveedores</a></li>
            </ul>
        </nav>
        <main>
            <h2>Gestión de Trabajadores</h2>
            
            <form method="POST" action="trabajadores.php">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="puesto">Puesto:</label>
                <input type="text" id="puesto" name="puesto" required>
                
                <button type="submit">Agregar Trabajador</button>
            </form>
            
            <h3>Lista de Trabajadores</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Puesto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['trabajadores'] as $trabajador): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trabajador['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($trabajador['puesto']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Inventario Pronti Broaster</p>
    </footer>
</body>
</html>
