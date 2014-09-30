<?php
require("includes/config.php");
require("includes/functions.php");
require("includes/error_display.php");

$realm = 'Area restringida';

if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

    die('Acceso denegado');
}


// analiza la variable PHP_AUTH_DIGEST
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('Datos Erroneos!');


// Generando una respuesta valida
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('Datos Erroneos!');

#######
# </authentication>
#######
printheader("enviar burrada");
    echo "
    <h1>Enviar fefeburrada</h1>
    <form method=\"post\">
    <textarea rows=\"7\" cols=\"70\" name=\"fefe\"></textarea> <br/> <br />
    <input type=\"submit\" value=\"Enviar burrada\" />
    </form>
    ";

if(@!$_POST['fefe']){

}else{
    $mysql = connectmysql();
    $_POST['fefe'] = $mysql->quote($_POST['fefe']);
    $sql = "INSERT INTO `fefeslap` (`fefefact`, `created`) VALUES ({$_POST['fefe']}, '".date("Y-m-d")."')";
    $result = $mysql->query($sql);
    echo "Fefe enviado";
}
printfooter();
