<?php
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$estado = $_POST['estado'];

$sql = "UPDATE estado SET estado = $estado, ult_vez = NOW() WHERE id = (SELECT id FROM (SELECT MAX(id) as id FROM estado) as tmp);";
if ($conn->query($sql) === TRUE) {
    echo "Estado actualizado con éxito ". $estado;
} else {
    echo "Error al actualizar el estado: " . $conn->error;
}

$conn->close();
?>
