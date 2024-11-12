<?php
if (isset($_GET['monto-gasto'], $_GET['fecha-gasto'], $_GET['categoria-gasto'])) {
    $montoGasto = $_GET['monto-gasto'];
    $fechaGasto = $_GET['fecha-gasto'];
    $categoriaGasto = $_GET['categoria-gasto'];

    // Aquí puedes hacer la consulta a la base de datos si necesitas obtener más detalles
    echo "Monto: $montoGasto, Fecha: $fechaGasto, Categoría: $categoriaGasto";
} else {
    echo "No se encontraron los detalles del gasto.";
}
?>
