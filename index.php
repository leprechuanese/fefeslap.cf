<?php

require("includes/config.php");
require_once("lang/lang-{$lang}.php");
require("includes/functions.php");
require("includes/error_display.php");

//conect mysql server
$mysql = connectmysql();


$fefe = $_SERVER['QUERY_STRING'];

if(is_numeric($fefe)){
    $factoq = getfacto($fefe, $mysql);
}else{
    $f = explode("&", $fefe);
    if(!@$f[1]){
        if($fefe != ""){
            header("Location: ./?" . rand(1, getTotalFactoNumber($mysql)) . "&" . $fefe );
        }else{
            header("Location: ./?" . rand(1, getTotalFactoNumber($mysql)));
        }
    }else{
        if(is_numeric($f[1])){
            $person = $f[0];
            $factoq = getfacto($f[1], $mysql);
        }else{
            $person = $f[1];
            $factoq = getfacto($f[0], $mysql);
        }
    }
}
if($factoq == false){
    $facto = "{$fefeslap_not_found}";
}else{
    $facto = $factoq["fefefact"];
}

$url = curPageURL() . "?" . $factoq['fefefactID'];
if($factoq == false){
    $title = $facto;
}elseif(isset($person)){
    $title = "{$fefeslap_name} {$person} {$fefeslap_with} {$url} {$facto}";
}else{
    $title = "{$fefeslap_name} {$fefeslap_with} {$url} {$facto}";
}
printheader($title);
printbody($factoq, $mysql);
disqus();
adsense();
printfooter();
