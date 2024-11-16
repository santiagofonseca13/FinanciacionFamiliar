
<?php
$secciones = [
    'vision' => 'Vision',
    'gestion' => 'Gestion',
    'contacto' => 'Contacto',
    'proceso' => 'Proceso'
];

foreach ($secciones as $id => $proceso) {
    echo "<li><a href='#$id'>$proceso</a></li>";
}
foreach ($secciones as $id => $contacto) {
    echo "<li><a href='#$id'>$contacto</a></li>";
}
foreach ($secciones as $id => $gestion) {
    echo "<li><a href='#$id'>$gestiob</a></li>";
}
foreach ($secciones as $id => $vision) {
    echo "<li><a href='#$id'>$vision</a></li>";
}
?>

