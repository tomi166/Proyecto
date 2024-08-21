<?php

$host = "190.105.205.228";
$usuario = "logisticaenvapla";
$contrasena = "Log1st1@2022";
$base_de_datos = "logisticaenvapla_ministerio";

$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener la data
$sql = "SELECT date_time FROM sensor_data";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $data = array();

    while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
    }

    echo json_encode(array("data" => $data));
} else {
    echo json_encode(array("data" => array()));
}

$conexion->close();

?>
