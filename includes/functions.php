<?php

function connectmysql(){
    global $sql_user, $sql_password, $sql_database, $sql_host;
    try{
         $dbh = new PDO("mysql:host=$sql_host;dbname=$sql_database", $sql_user, $sql_password);
    }
    catch(PDOException $e){
         echo $e->getMessage();
    }
    $dbh->query("SET NAMES utf8");
	return $dbh;
}

function printheader($title){
    $title = str_replace(array("<", ">"), array("[", "]"), $title);
    $title = htmlentities($title);
    global $webbackground;
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
    <html>
    <head>
    <title>$title</title>
    <meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />
    </head>
    <body BGCOLOR=\"#".$webbackground."\">";
}

function printbody($fefesql, $mysql){
    global $sql_table, $sql_database, $fefeslap_previous, $fefeslap_random, $fefeslap_next, $fefeslap_fefefacto, $fefeslap_this,$fefeslap_its_been_visit, $fefeslap_times;

    echo "<center>";
    $url = curPageURL() . "?" . $fefesql[1]['fefefactID'];
    
    $fefefactnumber = $fefesql[1]['fefefactID'];
    $data = $fefesql[1]['fefefact'];
    $visitas = $fefesql[1]['numberviews'];
    if($_SERVER['REMOTE_ADDR'] != $fefesql[1]['last_ip']){
        $sql = "UPDATE `$sql_database`.`$sql_table` SET last_ip='{$_SERVER['REMOTE_ADDR']}', numberviews=". ($fefesql[1]['numberviews']+1)." WHERE `fefefactID` = '{$fefesql[1]['fefefactID']}'";
        $result = $mysql->query($sql);
        $visitas = $fefesql[1]['numberviews'] + 1;
    }
    
    echo "<div>";
    if($fefesql[0] != null){
        $previous = curPageURL() . "?" . $fefesql[0]['fefefactID'];
        echo "<a style=\"margin-top: 7px;float: left; display: inline-block;\" href=\"$previous\">$fefeslap_previous</a>";
    }
    echo "<center style= \"display: inline-block;\"><a style=\"margin-top: 7px; display: inline-block;\" href=\"". curPageURL() ."\">$fefeslap_random</a></center>";
    if($fefesql[2] != null){
        $next = curPageURL() . "?" . $fefesql[2]['fefefactID'];
        echo "<a style=\"margin-top: 7px;float: right; display: inline-block;\" href=\"$next\">$fefeslap_next</a>";
    }

    echo "</div><h1 style=\"margin-top: 15px; display: inline-block;\">$fefeslap_fefefacto #" . $fefefactnumber ."</h1>
    <br />
	<a href=\"$url\">
		$url</a><br>
	<textarea disabled style=\"color: #000; background-color: #FFF;\" rows=\"7\" cols=\"100\">$data</textarea> <br />
    {$fefeslap_this} {$fefeslap_fefefacto} {$fefeslap_its_been_visit} {$visitas} {$fefeslap_times}.
	</center>"; 
}

function printfooter(){
    echo "</body></html>";
}

function getfacto($id,$mysql){
    global $sql_table, $sql_database;
    $id = $mysql->quote($id);
	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "SELECT * FROM `$sql_database`.`$sql_table` WHERE `fefefactID` = $id";
	$result = $mysql->query($sql);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if ( $row ) {
		return $row;
	} else {
		return 0;
	}
}

function getfactov2($id,$mysql){
    global $sql_table, $sql_database;
    $id = $mysql->quote($id);
	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "select * from `$sql_database`.`$sql_table` where (fefefactID = IFNULL((select min(fefefactID) from `$sql_table` where fefefactID > $id),0) or  fefefactID = IFNULL((select max(fefefactID) from `$sql_table` where fefefactID < $id),0) or fefefactID = IFNULL((select max(fefefactID) from `$sql_table` where fefefactID = $id),0))  ";
    //$sql = "select * from `$sql_database`.`$sql_table` where (fefefactID = IFNULL((select min(fefefactID) from `$sql_table` where fefefac
	$result = $mysql->query($sql);
    $results = array();
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($results, $row);
    }
    if(count($results) == 2){
        if("'".$results[1]['fefefactID']."'" == $id){
            $results[2] = null;
        }elseif("'".$results[0]['fefefactID']."'" == $id){
            array_unshift($results, null);
        }else{
            return false;
        }
    }elseif(count($results) == 1){
        array_unshift($results, null);
        array_push($results, null);
    }elseif(count($results) < 1){
        return false;
    }
    return $results;
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
  	if (@$_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
  	$pageURL .= "://";
  	if ($_SERVER["SERVER_PORT"] != "80") {
   		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].dirname($_SERVER["REQUEST_URI"]);
  	} else {
   		$pageURL .= $_SERVER["SERVER_NAME"].dirname($_SERVER["REQUEST_URI"]);
  	}
    if(substr($pageURL, -1) != "/"){
        $pageURL = $pageURL . "/";
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
        echo "<center>
        <!-- begin adsense -->
        <script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
        <ins class=\"adsbygoogle\"
             style=\"display:inline-block;width:{$google_ad_width}px;height:{$google_ad_height}px\"
             data-ad-client =\"{$google_ad_client}\"
             data-ad-slot = \"{$google_ad_slot}\"</ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <!-- end adsense --></center>";
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
echo <<<EOL

    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '{$disqus_shortname}'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    

    <script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = '{$disqus_shortname}'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
    </script>
EOL;
} //if (DISQUS_ACTIVE)

} //disqus();

function getTotalFactoNumber($mysql){
    global $sql_table, $sql_database;

	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql="SELECT * FROM `$sql_database`.`$sql_table`";
	$result = $mysql->query($sql);
	$row = $result->fetch(PDO::FETCH_NUM);
	return $result->rowCount();
}

// function to parse the http auth header
function http_digest_parse($txt)
{
    // proteger contra datos perdidos
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

