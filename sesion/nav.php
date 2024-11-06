
<?php
$secciones = [              //Creo la variable secciones es como el arreglo 
    'vision' => 'Vision',
    'gestion' => 'Gestion', // el signo de igual es para asociar 
    'contacto' => 'Contacto',  //significa que la clave 'contacto' está asociada con el valor 'Contacto'.
    'proceso' => 'Proceso'
];

foreach ($secciones as $id => $proceso) {
    echo "<li><a href='#$id'>$proceso</a></li>"; // bucle Mediante foreach ( implode, array_map, ) se recorre  y se genera una lista HTML.
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

