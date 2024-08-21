<?php
// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $irrigation = $_POST["irrigation"];
    $selectedProgram = isset($_POST["selectedProgram"]) ? $_POST["selectedProgram"] : "NULL";
    $hourStart = $_POST["hourStart"];
    $hourEnd = $_POST["hourEnd"];

    if (isset($_POST["selectedDay"])) {
        $selectedDay = $_POST["selectedDay"]; // Obtener el valor seleccionado del campo "dia"
    } else {
        // Si el campo "dia" no está presente, asignar un valor predeterminado (en este caso, -1)
        $selectedDay = -1;
    }

    // Realizar la conexión a la base de datos (debes configurar tus propios valores de conexión)
    $server = "190.105.205.228";
    $user = "logisticaenvapla"; 
    $passwordDB = "Log1st1@2022"; 
    $db = "logisticaenvapla_ministerio"; 

    $conn = new mysqli($server, $user, $passwordDB, $db);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Ejecutar la sentencia SQL para actualizar la base de datos
    $sql = "UPDATE calendario SET 
            flag_riega = $irrigation, 
            flag_programa = $selectedProgram, 
            hora_inicio = '$hourStart', 
            hora_final = '$hourEnd' 
            WHERE dia = $selectedDay";

    if ($conn->query($sql) === TRUE) {
        // Construir un mensaje de éxito que incluya los valores actualizados
        $successMessage = "Datos actualizados con éxito. Valores actualizados: 
            irrigación: $irrigation, 
            día seleccionado: $selectedDay, 
            programa seleccionado: $selectedProgram, 
            hora de inicio: $hourStart, 
            hora final: $hourEnd";
        echo $successMessage;
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se reciben datos por POST, muestra un mensaje de error
    echo "Error: No se recibieron datos por POST.";
}
?>
