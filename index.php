<?php

	$linelenght=2;
	$fefeslapfile="./archlinux-co-frases-de-fortuna/fefes";
	
	do {
		$f_contents = file($fefeslapfile);
		$line = $f_contents[array_rand($f_contents)];
		$data = $line;
		#echo "." . $data . ".";
		$linelenght = strlen($data);
	} while ($linelenght < 3);

	// now get fefe fact line number
	$file=$fefeslapfile;
	$linecount = 0;
	$handle = fopen($file, "r");
	while(!feof($handle)){
  		$line = fgets($handle);
  		$linecount++;
		if ($line == $data) {
			$fefefactnumber=$linecount;
		}
	}

	fclose($handle);

	#echo $linecount . "Fefefact: " . $fefefactnumber;

        #$myvar=$_SERVER["QUERY_STRING"];
        #if (!isset($myvar) || trim($myvar)===''){ $myvar = "negro"; }
?>
<!DOCTYPE html>
<html>
<head>
        <title><?php echo "fefeslap #" . $fefefactnumber . ": " . substr($data, 0, 120) . " ..."; ?></title>
        <meta charset="utf-8">

        <script type="text/javascript">
//<![CDATA[
try{if (!window.CloudFlare) {var CloudFlare=[{verbose:0,p:0,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/c$
//]]>
</script>
<style>
                @font-face {
                        font-family: 'Open Sans';
                        font-style: normal;
                        font-weight: 400;
                        src: local('Open Sans Extrabold'), local('OpenSans-Extrabold'),
                        url(https://themes.googleusercontent.com/static/fonts/opensans/v8/EInbV5DfGHOiMmvb1Xr-hnhCUOGz7vYGh6$
                        }

                h1 {
                        top: 50%;
                        position: absolute;
                        margin: -80px auto 0;
                        line-height: 160px;
                        font-size: 160px;
                        font-family: 'Open Sans';
                        font-style: normal;
                        font-weight: 400;
                        src: local('Open Sans Extrabold'), local('OpenSans-Extrabold'),
                        url(https://themes.googleusercontent.com/static/fonts/opensans/v8/EInbV5DfGHOiMmvb1Xr-hnhCUOGz7vYGh6$
                        }

                h1 {
                        top: 50%;
                        position: absolute;
                        margin: -80px auto 0;
                        line-height: 160px;
                        font-size: 160px;
                        font-family: 'Open Sans';
                        font-style: normal;
                        font-weight: 400;
                        height: 120px;
                        width: 100%;
                        text-align: center;
                        color: #E68383;
                }
        </style>
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
        <center><h1><?php echo "fefefacto #" . $fefefactnumber ."</h1><textarea rows=\"4\" cols=\"100\">" . $data . "</textarea></center>"; ?>
</body>
</html>



