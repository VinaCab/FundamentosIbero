<?php
session_start();

if (!isset($_SESSION['pedidos'])) {
    $_SESSION['pedidos'] = [];
}

$productos = [
    'Pollo Asado',
    'Pechuga a la Plancha',
    'Alitas Picantes',
    'Papas Fritas',
    'Ensalada César'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_pedido'])) {
        $producto = $_POST['producto'] ?? '';
        
        if ($producto) {
            $_SESSION['pedidos'][] = [
                'producto' => $producto,
                'estado' => 'En Fila' 
            ];
        }
    }
    
    if (isset($_POST['cambiar_estado'])) {
        $indice = $_POST['indice'] ?? '';
        $nuevo_estado = $_POST['estado'] ?? '';
        
        if (isset($_SESSION['pedidos'][$indice]) && $nuevo_estado) {
            $_SESSION['pedidos'][$indice]['estado'] = $nuevo_estado;
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
    <title>Pedidos - Inventario Pronti Broaster</title>
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
            <h2>Gestión de Pedidos</h2>
            
            <form method="POST" action="pedidos.php">
                <label for="producto">Seleccionar Producto:</label>
                <select id="producto" name="producto" required>
                    <option value="">Seleccione un producto</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo htmlspecialchars($producto); ?>"><?php echo htmlspecialchars($producto); ?></option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" name="agregar_pedido">Agregar Pedido</button>
            </form>
            
            <h3>Lista de Pedidos</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['pedidos'] as $indice => $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['producto']); ?></td>
                            <td>
                                <form method="POST" action="pedidos.php">
                                    <select name="estado" onchange="this.form.submit()">
                                        <option value="En Fila" <?php if ($pedido['estado'] == 'En Fila') echo 'selected'; ?>>En Fila</option>
                                        <option value="Listo" <?php if ($pedido['estado'] == 'Listo') echo 'selected'; ?>>Listo</option>
                                        <option value="Entregado" <?php if ($pedido['estado'] == 'Entregado') echo 'selected'; ?>>Entregado</option>
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
