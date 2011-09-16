<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Unity Web Player | WebPlayer</title>
		<script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject.js"></script>

		
			<link rel="stylesheet" href="js/jquery-ui-1.8.16.custom.css">
			<script src="js/jquery-1.6.2.min.js"></script>
			<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
		
               <script>
			$(function() {
				$( "#tabs" ).tabs();
			});
		</script>
			
		<script type="text/javascript">
		<!--
		function GetUnity() {
			if (typeof unityObject != "undefined") {
				return unityObject.getObjectById("unityPlayer");
			}
			return null;
		}
		
		if (typeof unityObject != "undefined") {
			unityObject.embedUnity("unityPlayer", "WebPlayer.unity3d?session=<?php echo $_SESSION['fbid'];; ?>&date=<?php $today = date("Ymd"); echo $today; ?>&name=<?php echo  $me['first_name']; ?>", 760, 540);
			
		}

		-->
		</script>
		
		
		<style type="text/css">
		<!--
		body {
			font-family: Helvetica, Verdana, Arial, sans-serif;
			background-color: white;
			color: black;
			text-align: center;
		}
		a:link, a:visited {
			color: #000;
		}
		a:active, a:hover {
			color: #666;
		}
		p.header {
			font-size: small;
		}
		p.header span {
			font-weight: bold;
		}
		p.footer {
			font-size: x-small;
		}
		div.content {
			margin: auto;
			width: 785px;
		}
		div.missing {
			margin: auto;
			position: relative;
			top: 50%;
			width: 193px;
		}
		div.missing a {
			height: 63px;
			position: relative;
			top: -31px;
		}
		div.missing img {
			border-width: 0px;
		}
		div#unityPlayer {
			cursor: default;
			height: 760px;
			width: 540px;
		}
		
		-->
		</style>
	</head>
	<body>
		<p class="header"></p>
		<div class="content">

			<div class="demo">

				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">Game</a></li>
						<li><a href="#tabs-2">Help</a></li>
						<li><a href="#tabs-3">About</a></li>
						<li><a href="#tabs-4">Terms</a></li>
						<li><a href="#tabs-5">Privacy</a></li>
						<li><a href="#tabs-6">Feedback</a></li>
					</ul>
					
					
					
					<div id="tabs-1" style="margin-bottom:10000px;">

					</div>

					<div id="tabs-2">
					<p> Help Text</p>
					</div>
					
					<div id="tabs-3">
					
					<p> About Text</p>
					
					</div>
					
					<div id="tabs-4">
					
					<p> Terms Of Service Text</p>
					
					</div>
					
					<div id="tabs-5">
					
					<p> Privacy Text</p>
					
					</div>
					
					<div id="tabs-6">
					
					<p> Feedback Text</p>
					
					</div>
					
					<div style="margin-top:-10000px;">
					<div id="unityPlayer">	
						<div class="missing">
								<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
									<img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
								</a>
						</div>
						
					</div>
					</div>
				</div>

			</div><!-- End demo -->
			
			
			
		</div>

	</body>
</html>
