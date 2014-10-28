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
    die('Acceso denegado');


// Generando una respuesta valida
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('Datos Erroneos!');

#######
# </authentication>
#######
$mysql = connectmysql();

if(@$_GET['a'] == "del"){
    $_GET['id'] = $mysql->quote($_GET['id']);
    $sql = "DELETE FROM `{$sql_database}`.`{$sql_table}` WHERE fefefactID={$_GET['id']}";
    $result = $mysql->query($sql);
    header("Location: admin.php");
    die();
}

if((@$_GET['a'] == "edit") && (@$_POST['fefe'])){
    $_POST['fefe'] = $mysql->quote($_POST['fefe']);
    $_GET['id'] = $mysql->quote($_GET['id']);
    $sql = "UPDATE `{$sql_database}`.`{$sql_table}` SET fefefact={$_POST['fefe']} WHERE fefefactID={$_GET['id']}";
    $mysql->query($sql);
    header("Location: admin.php");
    die();
}

if((@$_GET['a'] == "new") && (@$_POST['fefe'])){
    $_POST['fefe'] = $mysql->quote($_POST['fefe']);
    $sql = "INSERT INTO `{$sql_database}`.`{$sql_table}` (`fefefact`, `created`) VALUES ({$_POST['fefe']}, '".date("Y-m-d")."')";
    $result = $mysql->query($sql);
    $mysql->query("SET @count = 0; UPDATE `{$sql_database}`.`{$sql_table}` SET fefefactID = @count:= @count + 1; ALTER TABLE `{$sql_database}`.`{$sql_table}` AUTO_INCREMENT = 1;");
    header("Location: admin.php");
    die();
}


printheader("Administración");
switch(@$_GET['a']){
    case "new":
        echo "
        <h1>Editar fefeslap</h1>
        <form method=\"post\">
        <textarea rows=\"7\" cols=\"70\" name=\"fefe\"></textarea> <br/> <br />
        <input type=\"submit\" value=\"Enviar facto\" />  <a href=\"admin.php\">[Cancelar]</a>
        </form>
        ";
    break;
    case "edit":
        echo "
        <h1>Editar facto</h1>
        <form method=\"post\">
        <textarea rows=\"7\" cols=\"70\" name=\"fefe\">". getfacto($_GET['id'], $mysql)['fefefact'] ."</textarea> <br/> <br />
        <input type=\"submit\" value=\"Enviar\" /> <a href=\"admin.php\">[Cancelar]</a>
        </form>";
        
    break;
    default:
        echo "<h1>Administración</h1>";
        echo "<a href=\"?a=new\">[Nuevo]</a> <br /><br />";
        $result = $mysql->query("SELECT * FROM `{$sql_database}`.`{$sql_table}`");
        echo "<table><tr><td>#</td><td><b>facto</b></td></tr>";
        while($fefe = $result->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><td>{$fefe['fefefactID']}</td><td>". htmlentities(substr($fefe['fefefact'],0, 80))."</td><td><a href=\"?a=del&id={$fefe['fefefactID']}\" onclick=\"return confirm('Estas seguro/a?')\">[Eliminar]</a> <a href=\"?a=edit&id={$fefe['fefefactID']}\">[Editar]</a></td></tr>";
        }
        echo "</table>";
}
printfooter();
