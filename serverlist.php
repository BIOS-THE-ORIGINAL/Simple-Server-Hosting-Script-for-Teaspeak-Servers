<?PHP

/*-------SETTINGS-------*/
$ts3_ip = '127.0.0.1';
$ts3_queryport = 10101;
$ts3_user = 'serveradmin';
$ts3_pass = 'MGuVPApHX2OH';
/*----------------------*/

#Include ts3admin.class.php
require("ts3admin.class.php");

#build a new ts3admin object
$tsAdmin = new ts3admin($ts3_ip, $ts3_queryport);

if($tsAdmin->getElement('success', $tsAdmin->connect())) {
	#login as serveradmin
	$tsAdmin->login($ts3_user, $ts3_pass);
	
	#get serverlist
	$servers = $tsAdmin->serverList();
	
	#set output var
	$output = '';
	
	#generate table codes for all servers
	foreach($servers['data'] as $server) {
		$output .= '<tr bgcolor="#ffffff" onmouseover="style.backgroundColor=\'#eeeeee\'" onmouseout="style.backgroundColor=\'#ffffff\'">';
		$output .= '<td width="50px" align="center">#'.$server['virtualserver_id'].'</td>';
		$output .= '<td width="300px">&nbsp;&nbsp;'.htmlspecialchars($server['virtualserver_name']).'</td>';
		$output .= '<td width="100px" align="center">'.$server['virtualserver_port'].'</td>';
		if(isset($server['virtualserver_clientsonline'])) {
			$clients = $server['virtualserver_clientsonline'] . '/' . $server['virtualserver_maxclients'];
		}else{
			$clients = '-';
		}
		$output .= '<td width="200px" align="center">'.$clients.'</td>';
		$output .= '<td width="100px" align="center">'.$server['virtualserver_status'].'</td>';
		if(isset($server['virtualserver_uptime'])) {
			$uptime = $tsAdmin->convertSecondsToStrTime(($server['virtualserver_uptime']));
		}else{
			$uptime = '-';
		}
		$output .= '<td width="150px" align="center">'.$uptime.'</td>';
	}
}else{
	echo 'Connection could not be established.';
}

if(count($tsAdmin->getDebugLog()) > 0) {
	foreach($tsAdmin->getDebugLog() as $logEntry) {
		echo '<script>alert("'.$logEntry.'");</script>';
	}
}

?>
<html>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>

		<meta content="freedns, tsdns, ts3 dns, ts dns, dns" name="keywords">
		<meta content="Host-You.de, Free DNS Service. You can redirect your servers using free DNS." name="description">
		<meta name="author" content="BIOS">
		<meta name="copyright" content="BIOS">
		<meta name="rating" content="General">
		<meta name="revisit-after" content="5 days">
		<meta name="robots" content="ALL">
		<meta name="distribution" content="Global">
		<meta http-equiv="Content-Language" content="tr">
		<meta http-equiv="reply-to" content="info@host-you.de">
		<meta http-equiv="pragma" content="no-cache"> 
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta charset="utf-8">
		
        <title>Host-You Serverlist</title>

		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/VpIXGrgSbKSVnjGemjkS.css" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Alegreya+Sans|Nunito|Josefin+Sans|Orbitron|Audiowide|Exo+2" rel="stylesheet" type="text/css">
	</head>
		<body>
		<div id="particles-js"></div>
			<div class="bilgidiv">
			</div>
		</div>
		<header>
			<nav class="navbar navbar-inverse">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">
								Menü							</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="https://host-you.de">
							<i class="fa fa-headphones"></i> Host-<span style="color: #008cba;">You.de</span>						</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">

							<li>
								<a href="http://host-you.de/">
									Home								</a>
							</li>
							<li>
								<a href="https://board.host-you.de/">
									Forum								</a>
							</li>		
							
														<li>
								<a href="faq.php">
									FAQ								</a>
							</li>		
							
							<li>
								<a href="dns.php">
									TSDNS								</a>
							</li>
							
							<li>
								<a href="https://wi.host-you.de/">
									Webinterface								</a>
							</li>
							
							<li>
								<a href="serverlist.php">
									Serverlist								</a>
							</li>
														
							<li>
								<a href="banlist.php">
									Banlist								</a>
							</li>
														
							<li>
								<a href="stat.php">
									Network Statistic								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
    <body>
    	<table bgcolor="#000000" cellpadding="5" cellspacing="1" width="900px" border="0" align="center">
        	<tr bgcolor="#c0c0c0">
            	<td width="50px" align="center"><b>ID<b></td>
                <td width="300px" align="center"><b>Servername<b></td>
            	<td width="100px" align="center"><b>Port<b></td>
            	<td width="200px" align="center"><b>Current clients<b></td>
                <td width="100px" align="center"><b>Status<b></td>
                <td width="150px" align="center"><b>Uptime<b></td>
            </tr>
			       <div class="container">

 	   
            <?PHP echo $output; ?>
		
        </table>
    </body>
					<section class="main-content bg-light">
				<div class="container text-center">
					<h2 class="page-header text-center">Welcome</h2>
					<p>Host-You.de Thank you for using our services</p><p>Host-You.de Services are completely free and open to all humanity.</p><p>Your thoughts, suggestions and criticisms are very important to us. You can notify us through our contact options.</p>				</div>
			</section>

			<section class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 text-center">
							<i style="color: #008cba;" class="fa fa-gift fa-5x fa-css-circle"></i>
							<h3>Free!</h3>
							<p>Our Service is completely free.</p>
						</div>
						<div class="col-sm-4 text-center">
							<i style="color: #008cba;" class="fa fa-child fa-5x fa-css-circle"></i>
							<h3>Easy to use!</h3>
							<p>Only need to Enter, Servername and Slots, Leave the rest to us :)</p>
						</div>
						<div class="col-sm-4 text-center">
							<i style="color: #008cba;" class="fa fa-magic fa-5x fa-css-circle"></i>
							<h3>Fast!</h3>
							<p>Activation and use in seconds.</p>
						</div>
					</div>
				</div>
			</section>

		</main>
		<script src="cdn/js/jquery.min.js"></script>
		<script src="cdn/js/bootstrap.min.js"></script>
		<script src="cdn/js/notiny.min.js"></script><div class="notiny"><div class="notiny-container" style="top: 10px; left: 10px;"></div><div class="notiny-container" style="bottom: 10px; left: 10px;"></div><div class="notiny-container" style="top: 10px; right: 10px;"></div><div class="notiny-container" style="bottom: 10px; right: 10px;"></div><div class="notiny-container notiny-container-fluid-top" style="top: 0px; left: 0px; right: 0px;"></div><div class="notiny-container notiny-container-fluid-bottom" style="bottom: 0px; left: 0px; right: 0px;"></div></div>
		<script src="cdn/js/nepix.min.js"></script>
			<footer>
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<h4>
							About Host-You						</h4>
						<p>
							V2 software distributed by Host-You, forum is very practical and fast. This software, working on Teamspeak, Teaspeak, is free, easy and fast to use with the assurance of Host-You.de ..						</p>
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://host-you.de/" data-a2a-title="Host-You">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_pinterest"></a>
<a class="a2a_button_linkedin"></a>
<a class="a2a_button_reddit"></a>
<a class="a2a_button_whatsapp"></a>
<a class="a2a_button_tumblr"></a>
<a class="a2a_button_facebook_messenger"></a>
<a class="a2a_button_myspace"></a>
<a class="a2a_button_outlook_com"></a>
<a class="a2a_button_skype"></a>
<a class="a2a_button_sms"></a>
<a class="a2a_button_vk"></a>
</div>
<script>
var a2a_config = a2a_config || {};
a2a_config.num_services = 16;
</script>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
 <a href='https://www.symptoma.it/'>Symptoma</a> <script type='text/javascript' src='https://www.freevisitorcounters.com/auth.php?id=c2f4e80c765c8227b0fb6aa4370c96b7e8bd7095'></script>
<script type="text/javascript" src="https://www.freevisitorcounters.com/en/home/counter/447464/t/10"></script>
					</div>
					<div class="col-sm-3">
						<h4>
							Support						</h4>
						<ul>
							<li>
								<a href="https://board.host-you.de/">
									Forum								</a>
							</li>
							<li>
								<a href="https://r4p3.net/threads/simple-server-hosting-script-remake.7437/">
									R4p3.net								</a>
							</li>
							<li>
								<a href="#">
									Email								</a>
							</li>
							<li>
								<a href="https://discordapp.com/invite/hTFHkAN">
									Discord								</a>
							</li>
														<li>
								<a href="https://www.elitepvpers.com/forum/freebies/3981896-free-teamspeak-sponsoring-gratis-teamspeak-sponsoring.html#post33837534">
									Elitepvpers							</a>
							</li>
						</ul>
					</div>
					<div class="col-sm-3">
						<h4>
							Contact						</h4>
						<ul>
							<li>
								<a href="mailto:info@host-you.de" target="_blank">
									<i class="fa fa-envelope-o" aria-hidden="true"></i>ᅠinfo@host-you.de (
									No Support)
								</a>
							</li>
							<li>
								<a href="mailto:support@host-you.de" target="_blank">
									<i class="fa fa-envelope-o" aria-hidden="true"></i>ᅠsupport@host-you.de
								</a>
							</li>
						</ul>
					</div>
				</div>
				<hr>
					<div class="row copyline">
						<div class="col-sm-6">
							<p>Copyright © 2018 Host-You.de - 
								All rights reserved and reserved.						</p>
						</div>
						<div class="col-sm-6 text-right">
								<a href="privacy-policy.php">
									Privacy	Policy							</a></p>
								<p>	<a href="terms.php">
									Terms of Use								</a>
							</p>
						</div>
					</div>
				</div>
			</footer>

	
		<div id="mrjwg9h-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: auto !important; position: fixed !important; border: 0px !important; min-height: 0px !important; min-width: 0px !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: auto !important; height: auto !important; z-index: 2000000000 !important; cursor: auto !important; float: none !important; bottom: 0px !important; left: 0px !important; right: auto !important; display: block;"><iframe id="H14aEER-1486297661162" src="about:blank" frameborder="0" scrolling="no" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: auto !important; right: auto !important; bottom: auto !important; left: auto !important; position: static !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 320px !important; height: 400px !important; z-index: 999999 !important; cursor: auto !important; float: none !important; display: none !important;"></iframe><iframe id="FB9SwlA-1486297661164" src="about:blank" frameborder="0" scrolling="no" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; position: fixed !important; border: 0px !important; padding: 0px !important; transition-property: none !important; z-index: 1000001 !important; cursor: auto !important; float: none !important; height: 40px !important; min-height: 40px !important; max-height: 40px !important; width: 320px !important; min-width: 320px !important; max-width: 320px !important; transform: rotate(0deg) translateZ(0px) !important; transform-origin: 0px center 0px !important; margin: 0px !important; top: auto !important; bottom: 0px !important; left: 10px !important; right: auto !important; display: block !important;"></iframe><iframe id="Smno28Y-1486297661164" src="about:blank" frameborder="0" scrolling="no" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; position: fixed !important; border: 0px !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; display: none !important; z-index: 1000003 !important; cursor: auto !important; float: none !important; top: auto !important; bottom: 40px !important; left: 10px !important; right: auto !important; width: 320px !important; max-width: 320px !important; min-width: 320px !important; height: 37px !important; max-height: 37px !important; min-height: 37px !important;"></iframe><div id="vh0MeDi-1486297661160" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none rgb(255, 255, 255) !important; opacity: 0 !important; top: 1px !important; bottom: auto !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: auto !important; height: 45px !important; display: block !important; z-index: 999997 !important; cursor: move !important; float: none !important; left: 0px !important; right: 96px !important;"></div><div id="U1D5MCk-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: 0px !important; right: 96px !important; bottom: auto !important; left: 0px !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 6px !important; height: 100% !important; display: block !important; z-index: 999998 !important; cursor: w-resize !important; float: none !important;"></div><div id="m1rdEYe-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: 0px !important; right: 0px !important; bottom: auto !important; left: auto !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 6px !important; height: 100% !important; display: block !important; z-index: 999998 !important; cursor: e-resize !important; float: none !important;"></div><div id="wuIp22K-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: 0px !important; right: 0px !important; bottom: auto !important; left: auto !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 100% !important; height: 6px !important; display: block !important; z-index: 999998 !important; cursor: n-resize !important; float: none !important;"></div><div id="MC1caeV-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: auto !important; right: 0px !important; bottom: 0px !important; left: auto !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 100% !important; height: 6px !important; display: block !important; z-index: 999998 !important; cursor: s-resize !important; float: none !important;"></div><div id="XdIOaGj-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: 0px !important; right: auto !important; bottom: auto !important; left: 0px !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 12px !important; height: 12px !important; display: block !important; z-index: 999998 !important; cursor: nw-resize !important; float: none !important;"></div><div id="yqm4Nax-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: 0px !important; right: 0px !important; bottom: auto !important; left: auto !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 12px !important; height: 12px !important; display: block !important; z-index: 999998 !important; cursor: ne-resize !important; float: none !important;"></div><div id="lIXuM8T-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: auto !important; right: auto !important; bottom: 0px !important; left: 0px !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 12px !important; height: 12px !important; display: block !important; z-index: 999998 !important; cursor: sw-resize !important; float: none !important;"></div><div id="fLfkLqp-1486297661161" class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: auto !important; right: 0px !important; bottom: 0px !important; left: auto !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 12px !important; height: 12px !important; display: block !important; z-index: 999999 !important; cursor: se-resize !important; float: none !important;"></div><div class="" style="outline: none !important; visibility: visible !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: none transparent !important; opacity: 1 !important; top: 0px !important; right: auto !important; bottom: auto !important; left: 0px !important; position: absolute !important; border: 0px !important; min-height: auto !important; min-width: auto !important; max-height: none !important; max-width: none !important; padding: 0px !important; margin: 0px !important; transition-property: none !important; transform: none !important; width: 100% !important; height: 100% !important; display: none !important; z-index: 1000001 !important; cursor: move !important; float: left !important;"></div></div><iframe src="about:blank" style="display: none !important;"></iframe></body>
</html>
