<?php
/* API PARA FEFESLAPS
 * Uso:
 *   Añadir fefe: /api.php?a=add&user=USUARIO&pass=CONTRASEÑA&fefe=TEXTO_DEL_FEFE
 *   Eliminar fefe: /api.php?a=del&user=USUARIO&pass=CONTRASEÑA&id=ID_DEL_FEFE
 *   Ver fefe: /api.php?a=get&id=ID_DEL_FEFE
 * Retorna:
 * - >:O si faltan parámetros
 * - >:( si falta el parámetro "a"
 * - No. si el usuario o contraseña son incorrectos
 * - OK si añadió el fefe correctamente
 * - El fefe cuando a=get finalizó correctamente
 * - 404 cuando no se ha encontrado el fefe
 */ 

require("includes/config.php");
require("includes/functions.php");
require("includes/error_display.php");

if(!isset($_GET['a'])){die(">:(");}

switch($_GET['a']){
    case "add":
        if(!isset($_GET['user']) || !isset($_GET['pass']) || !isset($_GET['fefe'])){die(">:O");}
        if(!isset($users[$_GET['user']])){
            die("No.");
        }elseif($users[$_GET['user']] != $_GET['pass']){
            die("No.");
        }
        $mysql = connectmysql();

        $_GET['fefe'] = $mysql->quote($_GET['fefe']);
        $sql = "INSERT INTO `{$sql_database}`.`{$sql_table}` (`fefefact`, `created`) VALUES ({$_GET['fefe']}, '".date("Y-m-d")."')";
        $result = $mysql->query($sql);
        echo "OK";
        break;
    case "del":
    case "add":
        if(!isset($_GET['user']) || !isset($_GET['pass']) || !isset($_GET['id'])){die(">:O");}
        if(!isset($users[$_GET['user']])){
            die("No.");
        }elseif($users[$_GET['user']] != $_GET['pass']){
            die("No.");
        }
        $mysql = connectmysql();
        $_GET['id'] = $mysql->quote($_GET['id']);
        $sql = "DELETE FROM `{$sql_database}`.`{$sql_table}` WHERE fefefactID={$_GET['id']}";
        $result = $mysql->query($sql);
        if($result->rowCount() != 0){
            echo "OK";
        }else{
            echo "404";
        }
        break;
    case "get":
        if(!isset($_GET['id'])){die(">:O");}
        $mysql = connectmysql();
        $_GET['id'] = $mysql->quote($_GET['id']);
        $result = $mysql->query("SELECT * FROM `{$sql_database}`.`{$sql_table}` WHERE fefefactID={$_GET['id']}");
        $fefe = $result->fetch(PDO::FETCH_ASSOC);
        if($fefe){
            echo $fefe['fefefact'];
        }else{
            die("404");
        }
}
