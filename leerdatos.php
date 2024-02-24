<?php

header('Access-Control-Allow-Origin: *');
require_once 'accesoBD.php';

$objectResponse = new stdClass();
date_default_timezone_set("UTC");

try {
    $accesoBD = new accesoBD(); // Crear una instancia de la clase accesoBD
    $objectResponse = $accesoBD->leerDatos(); // Llamar al método leerDatos()
} catch (Exception $e) {
    $objectResponse->code = '500'; // Código para error interno del servidor
    $objectResponse->message = $e->getMessage(); // Agregar el mensaje de error a la respuesta
}

echo json_encode($objectResponse); // Utilizar json_encode() para convertir el objeto a JSON
?>

