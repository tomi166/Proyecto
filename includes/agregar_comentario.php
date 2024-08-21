<?php
$server = "190.105.205.228";
$user = "logisticaenvapla"; 
$passwordDB = "Log1st1@2022"; 
$db = "logisticaenvapla_ministerio"; 

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["comentario"])) {
        $nombre = $_POST["nombre"];
        $comentario = $_POST["comentario"];

        $stmt = $conn->prepare("INSERT INTO comentarios (nombre, comentario, fecha) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $nombre, $comentario);

        if ($stmt->execute()) {
            echo json_encode(array("mensaje" => "Comentario agregado con éxito"));
        } else {
            echo json_encode(array("mensaje" => "Error al agregar el comentario"));
        }

        $stmt->close();
    } else {
        echo json_encode(array("mensaje" => "Datos de nombre y comentario no proporcionados"));
    }
}

$conn->close();
?>
