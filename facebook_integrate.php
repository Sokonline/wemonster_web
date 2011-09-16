<?php

require_once("lib/facebook.php");

session_start() or die("Unable to start session.");
$appConfig = parse_ini_file("conf.ini");

if (@$appConfig['debug'] != "1") {
	
	// Create our Application instance.
	$facebook = new Facebook(array(
	  'appId' => $appConfig['facebook_appid'],
	  'secret' => $appConfig['facebook_secret'],
	  'cookie' => true,
	));
	
        
	$_SESSION['fbid'] = NULL;
	$_SESSION['first_name'] = $facebook->getUsername();
        $me = $facebook->api('/me');
	try {
		$session = $facebook->getSession();
		$_SESSION['fbid'] = $facebook->getUser();
           
	} catch (FacebookApiException $e) {
	    die('Failed to get facebook user id.');
	}
	
	if ($_SESSION['fbid'] == NULL) {
		?>
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		
		<html>
			<head>
				<title>Login</title>
			</head>
			<body>
				
				<?php
				$url = $facebook->getLoginUrl(array(
				'canvas' => 1,
				'fbconnect' => 0
				));
				 
				echo "<script type='text/javascript'>top.location.href = '$url';</script>";
				?>
				
			</body>
		</html>
		
		<?php
		die("");
	}
} else {
	if (($_SESSION['fbid'] = @$_REQUEST['fbid_override']) === NULL) {
		$_SESSION['fbid'] = $appConfig['debug_fbid'];
	}
}

?>
