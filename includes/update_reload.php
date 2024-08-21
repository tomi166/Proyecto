<?php
$server = "190.105.205.228";
$username = "logisticaenvapla";
$password = "Log1st1@2022";
$dbname = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Comprobar si se ha enviado una solicitud POST para reiniciar
if (isset($_POST['reiniciar'])) {
    // Actualizar el estado a 1 y la fecha actual
    $sql = "UPDATE reload SET estado = 1, ult_vez = NOW() WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        $response = array(
            "message" => "success",
            "estado" => 1
        );

        echo json_encode($response);
    } else {
        $response = array(
            "message" => "error",
            "estado" => 0
        );

        echo json_encode($response);
    }
} else {
    // Consultar el estado actual
    $sql = "SELECT estado FROM reload";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $estado = $row["estado"];

        $response = array(
            "message" => "success",
            "estado" => $estado
        );

        echo json_encode($response);
    } else {
        $response = array(
            "message" => "error",
            "estado" => 0
        );

        echo json_encode($response);
    }
}

$conn->close();
?>
