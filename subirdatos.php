<?php
header('Access-Control-Allow-Origin: *');
require_once 'accesoBD.php';
$objectResponse= new stdClass();
date_default_timezone_set("UTC");

if (isset($_POST['valor']) && isset($_POST['tipo']) && isset($_POST['id_device'])){ // aqui se agrego isset($_POST['id_device']
    $valor = mysqli_real_escape_string(conexion::conectar(), $_POST['valor']);
    $tipo = mysqli_real_escape_string(conexion::conectar(), $_POST['tipo']);
    $id_device = mysqli_real_escape_string(conexion::conectar(), $_POST['id_device']); // aqui se agrego isset($_POST['id_device']

    // Llama al método subirDatos de la clase accesoBD, incluyendo el id_device
    $objectResponse = accesoBD::subirDatos($valor, $tipo, $id_device);// aqui se agrego $id_device
    echo(json_encode($objectResponse));
}else{
    $objectResponse->code = '500'; // Código de error si faltan variables
    echo (json_encode($objectResponse));
}
?>
