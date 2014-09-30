<?php

require("includes/config.php");

require("includes/functions.php");
require("includes/error_display.php");

//conect mysql server
$mysql = connectmysql();


$fefe = mysql_real_escape_string($_SERVER['QUERY_STRING']);

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
printbody($factoq, $mysql);
disqus();
adsense();
printfooter();
