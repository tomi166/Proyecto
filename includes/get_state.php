<?php
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener el estado actual
$sql = "SELECT estado FROM estado ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtiene el resultado de la consulta
    $row = $result->fetch_assoc();
    $estado = $row["estado"];
    
    // Devuelve el estado como respuesta JSON
    $response = array("estado" => $estado);
    echo json_encode($response);
} else {
    echo "No se encontraron registros de estado en la base de datos.";
}

$conn->close();
?>
