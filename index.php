<?php
//incluye definiciones

include_once "includes/functions.php";
include_once "includes/defs.php";

//conect mysql server
$mysql = connectmysql();
$conn = $mysql;

if ( DEBUG ) { $mydomain=""; }
//determine whatever if requesting fact number
//slap $myvar with a random facto number
//slap $myvar with a facto number
//slap with a random facto

$typeofslap=0; // 0 = random to nobody, 1 = slap with $myvar, 2 = $myvar + random, 3 = $myvar + facto
$ERRORDETECTED=0;
$tmpvar="";
$tmpslapnumber=0;

// get $whole string
$myvar=$_SERVER["QUERY_STRING"];

// get factonumber if exist
$slapnumber = mysql_real_escape_string(htmlspecialchars($_REQUEST['s']));

//check if $tmpvar if a fefeslap numeric
if ( is_numeric($myvar) ) {
	//user request a fefefact #
	$tmpslapnumber=$tmpvar;
	$typeofslap=1 //slap with $myvar facto
}

if ( $tmpslapnumber ) { 
	//user already give a slapnumber
	//so if s= is SET, ISSUE an ERROR
	if ( is_numeric($slapnumber) ) { $ERRORDETECTED = 1; }
}

if ( isset($myvar) ) { 
	// if myvar is set then check if &s=XXX exist
	if ( (isset($slapnumber) ) {
		//substr from &s=XXX if exist
		$tmpvar=str_replace("&s=$slapnumber","","$myvar");
		$typeofslap=3; //slap myvar with s=XXX
	} else {
		//slap $myvar with random slap
		$typeofslap=2;
	}
}

if ( ! isset($myvar) && isset($slapnumber) ) {
	//slap with random 
	$typeofslap=0;
}

//if slapnumber less that zero
if ( intval($slapnumber) <= 0 ) { $ERRORDETECTED = 1; }


if ( $ERRORDETECTED ) {	echo "ERROR"; }


switch ($typeofslap) {
    case "0":
        echo "random slap";
        break;
    case "1":
        echo "slap with $myvar";
        break;
    case "2":
        echo "slap $myvar with randomslap";
        break;
    case "3":
        echo "slap $myvar with $slapnumber";
        break;


} 
echo "* $myvar *\n * $slapnumber *";
exit;     
	$printfefeslap=0;
	//construct my $title
	if ( ! $printfefeslap ) {
		$mytitle="fefeslap($fefefactnumber): http://fefeslap.cf/?$fefefactnumber " . substr($data, 0, $maxlenght);
	} else {
		$mytitle="fefeslaps $myvar con http://fefeslap.cf/?$fefefactnumber " . substr($data, 0, $maxlenght);
	}
 
	if ( strlen($data) > $maxlenght ) {
		//to avoid flood in title
		$title = $mytitle . " ...";
	} 
	//print_r($ini_array);
	//echo html header

	printheader($title);
	adsense();
	disqus();
	printfooter();
exit
?>

<!DOCTYPE html>
<html>
<head>
        <title>
		<?php 
			//construct my $title
			if ( ! $printfefeslap ) {
				$mytitle="fefeslap($fefefactnumber): http://fefeslap.cf/?$fefefactnumber " . substr($data, 0, $maxlenght);
			} else {
				$mytitle="fefeslaps \"$myvar\" con http://fefeslap.cf/?$fefefactnumber " . substr($data, 0, $maxlenght);
			}
			echo "$mytitle"; 
			if ( strlen($data) > $maxlenght ) {
				//to avoid flood in title
				echo " ...";
			} 
		?>
	</title>
        <meta charset="utf-8">
</head>
<body>
<center>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 468x60 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-5497936311153165"
     data-ad-slot="7432207287"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</center>
        <center>
			<?php 
			//construct my $title
			if ( $printfefeslap ) {
				echo "<h3>fefeslaps \"$myvar\" con <a href=\"http://fefeslap.cf/?$fefefactnumber\">
		http://fefeslap.cf/?$fefefactnumber
	</a></h3>";
			}
				echo "<h1>fefefacto #" . $fefefactnumber ."</h1>
	<a href=\"http://fefeslap.cf/?$fefefactnumber\">
		http://fefeslap.cf/?$fefefactnumber
	</a><br>
	<textarea rows=\"4\" cols=\"100\">$data</textarea>
	</center>"; 
		?>
</body>
</html>



