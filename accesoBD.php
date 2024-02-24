<?php

require_once 'conexion.php';

date_default_timezone_set("UTC");

class accesoBD {

    public static function leerDatos() {
        $pArray = new stdClass();
        $host = "SELECT * FROM things;";
        $res = conexion::ejecutarSQL($host);
        if ($res->num_rows > 0) {
            while ($campos = $res->fetch_object()) {
                $pArray->things[] = array('id' => $campos->id, 'valor' => $campos->value, 'fecha' => $campos->date, 'tipo' => $campos->type);
            }
            $pArray->code = '200';
        } else {
            $pArray->code = '300';
        }
        conexion::cerrarconexion();
        return $pArray;
    }

    public static function subirDatos($value, $type) {
        $pArray = new stdClass();
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO things (type, value, date) VALUES ('{$type}', '{$value}', '{$fecha}')";
        if (conexion::ejecutarSQL($sql)) {
            $pArray->code = '200';
        } else {
            $pArray->code = '300';
        }
        conexion::cerrarConexion();
        return $pArray;
    }
}
?>


