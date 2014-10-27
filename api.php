<?php
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
