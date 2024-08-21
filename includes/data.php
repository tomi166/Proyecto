<?php
$server = "190.105.205.228";
$user = "logisticaenvapla"; 
$passwordDB = "Log1st1@2022"; 
$db = "logisticaenvapla_ministerio"; 

$conn = new mysqli($server, $user, $passwordDB, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los valores de temperatura, humedad y ldr_value
$sql = "SELECT * FROM sensor_data WHERE id = (SELECT MAX(id) FROM sensor_data);";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data = array(
        'temperature' => $row['temperature'],
        'humidity' => $row['humidity'],
        'ldr_value' => $row['ldr_value'],
        'time' => $row['date_time'],
		'id' => $row['id']
    );
    echo json_encode($data);
} else {
    echo json_encode(array());
}

$conn->close();
?>
