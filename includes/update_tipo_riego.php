<?php
// Conexión a la base de datos (reemplaza con tus propios datos de conexión)
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el valor del input radio seleccionado
    $option = $_POST["option"];

    // Define los valores para actualizar en la base de datos
    $automatedFlag = 0;
    $programmableFlag = 0;

    if ($option === 'automated') {
        $automatedFlag = 1;
    } elseif ($option === 'programmable') {
        $programmableFlag = 1;
    }

    // Actualiza la base de datos
    $sql1 = "UPDATE calendario SET flag_riega = $automatedFlag WHERE id = 8";
    $sql2 = "UPDATE calendario SET flag_riega = $programmableFlag WHERE id = 9";

    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "Tipo de riego actualizado";
    } else {
        echo "Error al actualizar la base de datos: " . $conn->error;
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
