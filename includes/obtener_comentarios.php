<?php

$server = "190.105.205.228";
$user = "logisticaenvapla"; 
$passwordDB = "Log1st1@2022"; 
$db = "logisticaenvapla_ministerio"; 

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM comentarios ORDER BY fecha DESC";
    $result = $conn->query($sql);

    $comentarios = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comentarios[] = $row;
        }
    }

    // Devolver los comentarios como JSON
    header('Content-Type: application/json');
    echo json_encode($comentarios);
}

$conn->close();
?>
