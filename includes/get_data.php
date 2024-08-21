<?php
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = isset($_POST['id']) ? $_POST['id'] : null;
$dia = isset($_POST['dia']) ? $_POST['dia'] : null;

$sql = "SELECT * FROM calendario";

if ($id !== null || $dia !== null) {
    $sql .= " WHERE";

    if ($id !== null) {
        $sql .= " id = $id";
    }

    if ($dia !== null) {
        $sql .= " dia = '$dia'";
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $data = array(
        "selectedProgram" => $row['flag_programa'],
        "hourStart" => $row['hora_inicio'],
        "hourEnd" => $row['hora_final'],
        "irrigation" => $row['flag_riega']
    );

    echo json_encode($data);
} else {
    echo "No se encontraron registros con los parámetros proporcionados";
}

$conn->close();
?>
