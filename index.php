<?php
//incluye definiciones
include_once "includes/defs.php";

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
$facto = $factoq["fefefact"];

$url = curWEBDIR() . "/?" . $factoq['fefefactID'];
if(isset($person)){
    $title = "fefeslaps {$person} with {$url} {$facto}";
}else{
    $title = "fefeslaps with {$url} {$facto}";
}
printheader($title);
printbody($factoq);

adsense();
disqus();
printfooter();
