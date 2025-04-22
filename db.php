<?php
$host = "localhost"; // Cambia esto si tu servidor Oracle está en otro host
$port = "1521"; // Puerto predeterminado de Oracle
$service_name = "XE"; // Cambia esto por el nombre del servicio de tu base de datos
$user = "Progra_PAR";
$password = "Progra_PAR";

try {
    // Cadena de conexión para Oracle
    $dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$service_name)))";
    
    // Crear la conexión
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexión exitosa con el usuario Progra_PAR.";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
