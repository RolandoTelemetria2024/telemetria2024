<?php

class conexion {

    public static function conectar() {
        $user = "xptqutikygnq36gg";
        $host = "kf3k4aywsrp0d2is.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        $db_name = "wx7tgkx522wy0jts";
        $pass = "upar5eaioxnnp5h9";

        return new mysqli($host, $user, $pass, $db_name, 3306);
    }

    public static function ejecutarSQL($sql) {
        return self::conectar()->query($sql);
    }

    public static function cerrarconexion() {
        return self::conectar()->close();
    }

}
?>

