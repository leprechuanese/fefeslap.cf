<?php
	$DEBUG=1;
	$mydomain="fefeslap.cf";
	if ( $DEBUG ) { $mydomain=""; }
	$linelenght=2;
	$maxlenght=200;
	$fefeslapfile="./archlinux-co-frases-de-fortuna/fefes.txt";
        $myvar=$_SERVER["QUERY_STRING"];	      
	$printfefeslap=0;
	if (!isset($myvar) && trim($myvar)===''){ 
		// if no argument given, choose a random fefeslap
		$handle = fopen($fefeslapfile, "r");
		do {
			$f_contents = file($fefeslapfile);
			$line = $f_contents[array_rand($f_contents)];
			$data = $line;
			#echo "." . $data . ".";
			$linelenght = strlen($data);
		} while ($linelenght < 4);
		fclose($handle);

		// now get fefe fact line number
		$linecount = 0;
		$handle = fopen($fefeslapfile, "r");
		while(!feof($handle)){
  			$line = fgets($handle);
  			$linecount++;
			if ($line == $data) {
				$fefefactnumber=$linecount;
			}
		}
		$fefefactnumber=$linecount-1;

		fclose($handle);

		#echo $linecount . "Fefefact: " . $fefefactnumber;

	} else {
		//yes, we have an argument given
		//determine if is a name or a number
			if ( (is_numeric($myvar)) && (intval($myvar) >= 0) ) {
				//myvar is a number and not zero
				$file=$fefeslapfile;
				$linecount = 0;
				$handle = fopen($file, "r");
				while(!feof($handle)){
  					$line = fgets($handle);
  					$linecount++;
				}

				fclose($handle);

				#echo "($myvar) mayor ($linecount) ";				
				if ( intval($myvar) > (intval($linecount)-1) ) {
					//echo " { $myvar > $linecount }";
					if ( $DEBUG ) { echo "<meta http-equiv=\"refresh\" content=\"0; url=http://fefeslap.cf/\" />\n"; }
					exit;				
				}

				//find fefefact number


				$lines = file( $fefeslapfile ); 
				$data=$lines[$myvar];
				$linelenght = strlen($data);
				$fefefactnumber=$myvar;

				if ($linelenght < 4) {
	 				if ( $DEBUG ) {echo "<meta http-equiv=\"refresh\" content=\"0; url=http://fefeslap.cf/\" />\n"; }
					exit;
				}
				
			} else {
				//is a string, probably a name
				// get a random fefefact
				// now get fefe fact line number
				$linecount = 0;

				$handle = fopen($fefeslapfile, "r");	
				do {
					$f_contents = file($fefeslapfile);
					$line = $f_contents[array_rand($f_contents)];
					$data = $line;
					#echo "." . $data . ".";
					$linelenght = strlen($data);
				} while ($linelenght < 4);
				fclose($handle);

				$handle = fopen($fefeslapfile, "r");
				while(!feof($handle)){
  					$line = fgets($handle);
  					$linecount++;
					if ($line == $data) {
						$fefefactnumber=$linecount;
					}
				}

				fclose($handle);
				$printfefeslap=TRUE;
		}
	} //no given fefefact 

$fefefactnumber=$myvar;
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



