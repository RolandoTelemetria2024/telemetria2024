<?php
require_once 'conexion.php';
date_default_timezone_set("UTC");
class accesoBD{
    public static function leerDatos(){
        $pArray = new stdClass();
        $sql="SELECT * FROM datos;";
        $res=conexion::ejecutarSQL($sql);
        if($res->num_rows>0){
            while($campos=$res->fetch_object()){
                $pArray->datos[] = array('id'=>$campos->id, 'valor'=>$campos->value, 'fecha'=>$campos->date,'tipo'=>$campos->type ,'dispositivo'=>$campos->id_device);
            }
            $pArray->code ='200';
        }else $pArray->code = '300';
        conexion::cerrarConexion();
        return $pArray;
    }
public static function subirDatos($valor, $tipo, $id_device) {   // se agrego $id_device
    $pArray = new stdClass();
    $fecha = date('Y-m-d H:i:s');
    // Asegúrate de incluir 'id_device' en tu consulta SQL
    $sql= "INSERT INTO datos (type, value, date, id_device) VALUES ('{$tipo}', '{$valor}', '{$fecha}', '{$id_device}')";// se agrego $id_device
    if (conexion::ejecutarSQL($sql)) $pArray->code='200';
    else $pArray->code ='300';
    conexion::cerrarConexion();
    return $pArray;
}
}
?>
