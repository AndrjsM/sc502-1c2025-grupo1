<?php
$servername = "localhost";
$username = "root";
$password = "lingsalas";
$database = "patitas_db";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) { //$conn es una variable importante, se va a usar en otros php como referencia de conexion a la bdd
    die("La conexión ha fallado: " . $conn->connect_error);
}
?>
