<?php
// Conexión a la base de datos (reemplaza con tus propios datos de conexión)
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

$conn = new mysqli($server, $user, $passwordDB, $db);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el valor del select
    $selectedOption = $_POST["option"];

    // Realiza la consulta SQL
    $sql = "SELECT * FROM calendario WHERE id = $selectedOption";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtiene los datos de la primera fila (puedes ajustar según tu base de datos)
        $row = $result->fetch_assoc();

        // Crear un array asociativo para devolver como JSON
        $data = array(
            "regar" => $row['flag_riega']
        );

        // Devuelve los datos como JSON
        echo json_encode($data);
    } else {
        // No se encontraron resultados
        echo "No se encontraron datos para la opción seleccionada.";
    }
} else {
    // Método de solicitud incorrecto
    echo "Solicitud incorrecta.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
