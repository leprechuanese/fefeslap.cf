<?php

require("includes/config.php");

include_once "includes/functions.php";

//conect mysql server
$mysql = connectmysql();


$fefe = $_SERVER['QUERY_STRING'];

if(is_numeric($fefe)){
    $factoq = getfacto($fefe, $mysql);
}else{
    if($fefe != ""){
        $person = $fefe;
    }
    $factoq = getfacto(rand(1, getTotalFactoNumber($mysql)), $mysql);
}
if($factoq == false){
    $facto = "Facto no encontrado";
}else{
    $facto = $factoq["fefefact"];
}

$url = curWEBDIR() . "/?" . $factoq['fefefactID'];
if($factoq == false){
    $title = $facto;
}elseif(isset($person)){
    $title = "fefeslaps {$person} with {$url} {$facto}";
}else{
    $title = "fefeslaps with {$url} {$facto}";
}
printheader($title);
adsense();
printbody($factoq, $mysql);
disqus();
printfooter();
