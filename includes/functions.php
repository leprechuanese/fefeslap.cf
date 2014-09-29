<?php

function connectmysql(){
    global $sql_user, $sql_password, $sql_database, $sql_host;
    try{
         $dbh = new PDO("mysql:host=$sql_host;dbname=$sql_database", $sql_user, $sql_password);
    }
    catch(PDOException $e){
         echo $e->getMessage();
    }
	return $dbh;
}

function printheader($title){
    global $webbackground;
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
    <html>
    <head>
    <title>$title</title>
    </head>
    <body BGCOLOR=\"#".$webbackground."\">";
}

function printbody($fefesql, $mysql){
    global $sql_table, $sql_database;

    echo "<center>";
    $url = curWEBDIR() . "/?" . $fefesql['fefefactID'];
    $previous = curWEBDIR() . "/?" . ($fefesql['fefefactID'] - 1);
    $next = curWEBDIR() . "/?" . ($fefesql['fefefactID'] + 1);
    $fefefactnumber = $fefesql['fefefactID'];
    $data = $fefesql['fefefact'];
    if($_SERVER['REMOTE_ADDR'] != $fefesql['last_ip']){
        $sql = "UPDATE `$sql_database`.`$sql_table` SET last_ip='{$_SERVER['REMOTE_ADDR']}', numberviews=". ($fefesql['numberviews']+1)." WHERE `fefefactID` = '{$fefesql['fefefactID']}'";
        $result = $mysql->query($sql);
    }
    $visitas = $fefesql['numberviews'];
    echo "<a style=\"margin-top: 15px;float: left;\" href=\"$previous\">&lt;- Anterior</a>
    <h1 style=\"margin-top: 15px; display: inline-block;\">fefefacto #" . $fefefactnumber ."</h1>
    <a style=\"margin-top: 15px;float: right;\" href=\"$next\">Siguiente -&gt</a>
    <br />
	<a href=\"$url\">
		$url</a><br>
	<textarea rows=\"7\" cols=\"100\">$data</textarea> <br />
    Este fefe ha sido visitado {$visitas} veces.
	</center>"; 
}

function printfooter(){
    echo "</body></html>";
}

function getfacto($id,$mysql){
    global $sql_table, $sql_database;
	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "SELECT * FROM `$sql_database`.`$sql_table` WHERE `fefefactID` = '$id'";
	$result = $mysql->query($sql);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if ( $row ) {
		return $row;
	} else {
		return 0;
	}
}

function rand_string( $length ) {
	//get me a random string
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
} //rand_string()


function calculate_uniq_key(){
	//key to use as unique
	return sha1(rand_string(255).$_SERVER['REMOTE_ADDR']);
}

function curPageURL() {
	$pageURL = 'http';
  	if ($_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
  	$pageURL .= "://";
  	if ($_SERVER["SERVER_PORT"] != "80") {
   		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  	} else {
   		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  	}
  	return $pageURL;
}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function curURL() {
	$query = $_SERVER['PHP_SELF'];
	$path = pathinfo( $query );
	$url = $path['basename'];
  	return $url;
}

function curWEBDIR(){
	return "http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["REQUEST_URI"]);
}

function adsense(){
    global $adsense_active, $google_ad_client, $google_ad_slot, $google_ad_width, $google_ad_height;
    
    if ($adsense_active){
        echo "
        <!-- begin adsense -->
        <script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
        <ins class=\"adsbygoogle\"
             style=\"display:inline-block;width:{$google_ad_width}px;height:{$google_ad_height}px\"
             data-ad-client =\"{$google_ad_client}\"
             data-ad-slot = \"{$google_ad_slot}\"</ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <!-- end adsense -->";
    }
}

function checkEmail($email) {
	if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])↪*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
    		list($username,$domain)=split('@',$email);
    		if(!checkdnsrr($domain,'MX')) {
      			return false;
    		}
    		return true;
  	}
	return false;
}

function disqus(){
    global $disqus_active, $disqus_shortname;
	if ($disqus_active){
        echo "
        <div id=\"disqus_thread\"></div>
        <script type=\"text/javascript\">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '{$disqus_active}';
        // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
        </script>";
    }
} //disqus();


function getTotalFactoNumber($mysql){
    global $sql_table, $sql_database;

	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql="SELECT * FROM `$sql_database`.`$sql_table`";
	$result = $mysql->query($sql);
	$row = $result->fetch(PDO::FETCH_NUM);
	return $result->rowCount();
}

