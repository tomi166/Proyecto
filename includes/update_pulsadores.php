<?php
$server = "190.105.205.228";
$user = "logisticaenvapla";
$passwordDB = "Log1st1@2022";
$db = "logisticaenvapla_ministerio";

// Crear una nueva conexión a la base de datos
$conn = new mysqli($server, $user, $passwordDB, $db);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Función para realizar las operaciones y cambiar el estado
function toggleOperacion($id, $tipo, $input_time, $conn) {
    // Obtener el estado actual
    $sql = "SELECT estado FROM pulsadores WHERE id = $id AND tipo = '$tipo'";
    $result = $conn->query($sql);
	
    $mensaje = "";
	
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $estado_actual = $row["estado"];
		
        list($minutes, $seconds) = explode(':', $input_time);
        $input_seconds = intval($minutes) * 60 + intval($seconds);

        // Cambiar el estado para el tipo "postpone"
        if ($tipo === 'postpone') {
            if ($input_seconds >= 5) {
                $postpone = $estado_actual == 0 ? 1 : 0;

                $sql = "UPDATE pulsadores SET estado = $postpone, posponer_time = '$input_time', date_time = NOW() WHERE id = $id AND tipo = 'postpone'";
                $result = $conn->query($sql);

                // Desactivar los botones "play" y "stop"
                $sql_play = "UPDATE pulsadores SET estado = 0, date_time = NOW() WHERE tipo = 'play'";
                $conn->query($sql_play);
                $sql_stop = "UPDATE pulsadores SET estado = 0, date_time = NOW() WHERE tipo = 'stop'";
                $conn->query($sql_stop);

                $mensaje = "$postpone";
            } else {
                $mensaje = "El tiempo debe ser mayor o igual a 5 segundos.";
            }
        } else if ($tipo === 'play') {
            $play = 1;
            $stop = 0;
            
            $sql_play = "UPDATE pulsadores SET estado = $play, date_time = NOW() WHERE tipo = 'play'";  
			$conn->query($sql_play);			
            $sql_stop = "UPDATE pulsadores SET estado = $stop, date_time = NOW() WHERE tipo = 'stop'";
			$conn->query($sql_stop);
            $sql = "UPDATE pulsadores SET estado = 0, date_time = NOW() WHERE tipo = 'postpone'";
			$conn->query($sql);			
			
        } else if ($tipo === 'stop') {
            $stop = 1;
            $play = 0;

            $sql_stop = "UPDATE pulsadores SET estado = $stop, date_time = NOW() WHERE tipo = 'stop'";
			$conn->query($sql_stop);
            $sql_play = "UPDATE pulsadores SET estado = $play, date_time = NOW() WHERE tipo = 'play'";
			$conn->query($sql_play);
            $sql = "UPDATE pulsadores SET estado = 0, date_time = NOW() WHERE tipo = 'postpone'";
			$conn->query($sql);				
        }

        if (isset($mensaje)) {
            echo $mensaje;
        }
    } else {
        echo "Registro no encontrado.";
    }
}

// Obtener valores de POST
$id = $_POST['id'];
$tipo = $_POST['tipo'];
$input_time = $_POST['input_time'];

// Llamar a la función para realizar la operación y cambiar el estado
toggleOperacion($id, $tipo, $input_time, $conn);

// Cerrar la conexión cuando hayas terminado de usarla
$conn->close();
?>
