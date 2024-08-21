<?php
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT 
            ldr_value, 
            SUM(CASE WHEN ldr_value = 1 THEN 1 ELSE 0 END) AS count_ldr_1,
            SUM(CASE WHEN ldr_value = 0 THEN 1 ELSE 0 END) AS count_ldr_0
        FROM sensor_data
        GROUP BY ldr_value";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'status' => ($row['ldr_value'] == 1) ? 'Luz encendida' : 'Luz apagada',
            'color' => ($row['ldr_value'] == 1) ? '#007bff' : '#dc3545',
            'value' => ($row['ldr_value'] == 1) ? $row['count_ldr_1'] : $row['count_ldr_0'],
        );
    }

    echo json_encode($data);
} else {
    echo "0 resultados";
}

$conn->close();

?>
