<?php
	//carga archivo .ini
     	$ini_array = parse_ini_file("includes/fefeslap.ini", true);
	//print_r($ini_array);
	//define('foo'),$ini_array['var']);

	define('LOCAL', $ini_array['coneccion']); 
     	define('DEBUG',$ini_array['debug']);
	define('HOSTNAME',$ini_array['host']);
	define('URL',$ini_array['url']);
	define('LINELENGHT',$ini_array['linelenght']);
	define('MAXLENGHT',$ini_array['maxlenght']);
	define('WEBBACKGROUND',$ini_array['webbackground']);
	/*define('SQL_HOST',$ini_array['sql_host']);
	define('SQL_USER',$ini_array['sql_user']);
	define('SQL_PASSWD',$ini_array['sql_passwd']);*/

	define('DISQUS_ACTIVE', $ini_array['disqus_active']);
	define('DISQUS_SHORTNAME',$ini_array['disqus_shortname']);

     	define('GOOGLE_ADSENSE', $ini_array['google_adsense']);
     	define('GOOGLE_AD_CLIENT', $ini_array['google_ad_client']);
     	define('GOOGLE_AD_SLOT', $ini_array['google_ad_slot']);
     	define('GOOGLE_AD_WIDTH', $ini_array['google_ad_width']);
     	define('GOOGLE_AD_HEIGHT', $ini_array['google_ad_height']);

     	define('SQL_DATABASE_TABLE',$ini_array['sql_database_table']);
     	define('CHARSET', $ini_array['charset']);
     	define('SQL_HOST', $ini_array['local']['sql_host']);
     	define('SQL_DATABASE', $ini_array['local']['sql_database']);
     	define('SQL_USER', $ini_array['local']['sql_user']);
     	define('SQL_PASSWORD', $ini_array['local']['sql_password']);
