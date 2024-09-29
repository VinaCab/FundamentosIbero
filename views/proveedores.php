<?php
session_start();

if (!isset($_SESSION['proveedores'])) {
    $_SESSION['proveedores'] = [];
}

$estados_factura = [
    'Pendiente',
    'Pagada'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_proveedor'])) {
        $proveedor = $_POST['proveedor'] ?? '';
        $factura = $_POST['factura'] ?? '';

        if ($proveedor && $factura) {
            $_SESSION['proveedores'][] = [
                'proveedor' => $proveedor,
                'factura' => $factura,
                'estado' => 'Pendiente' 
            ];
        }
    }

    if (isset($_POST['cambiar_estado'])) {
        $indice = $_POST['indice'] ?? '';
        $nuevo_estado = $_POST['estado'] ?? '';

        if (isset($_SESSION['proveedores'][$indice]) && $nuevo_estado) {
            $_SESSION['proveedores'][$indice]['estado'] = $nuevo_estado;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Proveedores - Inventario Pronti Broaster</title>
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
            <h2>Gestión de Proveedores</h2>

            <!-- Formulario para agregar proveedor -->
            <form method="POST" action="proveedores.php">
                <label for="proveedor">Nombre del Proveedor:</label>
                <input type="text" id="proveedor" name="proveedor" required>
                
                <label for="factura">Número de Factura:</label>
                <input type="text" id="factura" name="factura" required>
                
                <button type="submit" name="agregar_proveedor">Agregar Proveedor</button>
            </form>

            <!-- Tabla para mostrar proveedores -->
            <h3>Lista de Proveedores</h3>
            <table>
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Número de Factura</th>
                        <th>Estado</th>                    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['proveedores'] as $indice => $proveedor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proveedor['proveedor']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['factura']); ?></td>
                            <td>
                                <form method="POST" action="proveedores.php">
                                    <select name="estado" onchange="this.form.submit()">
                                        <?php foreach ($estados_factura as $estado): ?>
                                            <option value="<?php echo htmlspecialchars($estado); ?>" <?php if ($proveedor['estado'] == $estado) echo 'selected'; ?>><?php echo htmlspecialchars($estado); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                    <input type="hidden" name="cambiar_estado" value="1">
                                </form>
                            </td>                          
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
