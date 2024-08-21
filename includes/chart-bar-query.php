<?php

$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$intervalQueryCount = "SELECT COUNT(*) as totalRows FROM sensor_data";
$intervalResultCount = $conn->query($intervalQueryCount);

if ($intervalResultCount) {
    $row = $intervalResultCount->fetch_assoc();
    $num_total_rows = ceil($row['totalRows'] / 200);

    $query = "SELECT * FROM sensor_data WHERE MOD(id, $num_total_rows) = 0 AND humidity < 100 ORDER BY id ASC LIMIT 200;";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'date' => $row['date_time'],
                'temperature' => $row['temperature'],
                'humidity' => $row['humidity'],
            );
        }

        echo json_encode($data);
    } else {
        echo json_encode(array('message' => 'No se encontraron datos en el intervalo.'));
    }
} else {
    die("Error en la consulta de conteo: " . $conn->error);
}

$conn->close();

?>
