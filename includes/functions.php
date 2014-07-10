<?php

function connectmysql(){
//echo "in MYSQL";exit;
# MySQL with PDO_MYSQL
#print_r(PDO::getAvailableDrivers());
$host=SQL_HOST;
$dbname=SQL_DATABASE;
$user=SQL_USER;
$pass=SQL_PASSWORD;
try {
     $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
     }
catch(PDOException $e)
     {
     echo $e->getMessage();
     }
	return $dbh;
}

function printheader($title){
// print html header
echo "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>$title</title>
<script type=\"text/javascript\">
<!--

function viewPage() {
parent.frames['ifr'].document.getElementById('iframeDiv').innerHTML=document.forms[0].elements[0].value;
}

function ClipBoard()
{
holdtext.innerText = copytext.innerText;
Copied = holdtext.createTextRange();
Copied.execCommand(\"Copy\");
}

function select_all(obj) {
var text_val=eval(obj);
text_val.focus();
text_val.select();
if (!document.all) return; // IE only
r = text_val.createTextRange();
r.execCommand('copy');
}
//-->
</script>
</head>
<body BGCOLOR=\"#".WEBBACKGROUND."\">
";
} //end printheader();


function printfooter(){
echo "
	</body>
</html>
";
}

function getfacto($id,$mysql){
	//get row
	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$database=MYSQL_DATABASE;
	$database_table=MYSQL_DATABASE_TABLE;
	//$sql = "SELECT * FROM `database`.`table` ORDER BY `date` DESC LIMIT 20";
	$sql = "SELECT * FROM `$database`.`$database_table` WHERE `id` = '$id'";
	$result = $mysql->query($sql);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if ( $row ) {
		//found
		return $row;
	} else {
		//not found
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
//adsense

if (GOOGLE_ADSENSE){
echo "
<!-- begin adsense -->
<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
<!-- 468x60 -->
<ins class=\"adsbygoogle\"
     style=\"display:inline-block;width:".GOOGLE_AD_WIDTH."px;height:".GOOGLE_AD_HEIGHT."px\"
     data-ad-client =\"".GOOGLE_AD_CLIENT."\"
     data-ad-slot = \"".GOOGLE_AD_SLOT."\"</ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!-- end adsense -->
";
} //if (GOOGLE_ADSENSE){
} //end adsense

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
	if (DISQUS_ACTIVE){
echo "
<div id=\"disqus_thread\"></div>
<script type=\"text/javascript\">
/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
var disqus_shortname = '<?php echo DISQUS_SHORTNAME; ?>';
// required: replace example with your forum shortname

/* * * DON'T EDIT BELOW THIS LINE * * */
(function() {
var dsq = document.createElement('script');
dsq.type = 'text/javascript';
dsq.async = true;
dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();
</script>
";

} //if (DISQUS_ACTIVE)

} //disqus();


function getTotalFactoNumber($mysql){
	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$database=MYSQL_DATABASE;
	$database_table=MYSQL_DATABASE_TABLE;
	$sql="SELECT * FROM `$database`.`$database_table` WHERE `id` > ''";
	$result = $mysql->query($sql);
	$row = $result->fetch(PDO::FETCH_NUM);
	return $result->rowCount();
}

