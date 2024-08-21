<?php
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$queryCount = "SELECT COUNT(*) as totalRows FROM sensor_data";
$resultCount = $conn->query($queryCount);

if ($resultCount) {
    $row = $resultCount->fetch_assoc();
    $num_total_rows = ceil($row['totalRows'] / 200); 
    $query = "SELECT * FROM sensor_data WHERE MOD(id, $num_total_rows) = 0 ORDER BY id ASC LIMIT 200;";
    $result = $conn->query($query);
} else {
    die("Error en la consulta de conteo: " . $conn->error);
}


if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$data = array();

while ($row = $result->fetch_assoc()) {
    $humidity = $row['humidity'];
    $temperature = $row['temperature'];
    $ldr_value = $row['ldr_value'];

    $buzzer = 0;
    if ($humidity != 0 && $temperature != 0 && $ldr_value != 0) {
        $buzzer = 15120;
    }

    $esp8266Value = ($ldr_value == 0 || $temperature == 0 || $humidity == 0) ? 100800 : 122400;

    $totalConsumptionValue = array_sum([18000, 1800, 7920, $esp8266Value, $buzzer]);
    
    $data['humidity'][] = ($humidity > 0) ? 18000 : 0;
    $data['temperature'][] = ($temperature > 0) ? 1800 : 0;
    $data['ldr_value'][] = ($ldr_value > 0) ? 7920 : 0;
    $data['buzzer'][] = $buzzer;
    $data['date_time'][] = $row['date_time'];
    $data['esp8266'][] = $esp8266Value;
    $data['totalConsumption'][] = $totalConsumptionValue;
}

echo json_encode($data);

$conn->close();


?>
