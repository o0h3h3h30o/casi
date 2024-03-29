 <?php
include('config.php');

if(empty($_SESSION['uid']))
{
	header("Location: index.php");
}

include('class/userClass.php');
$userClass = new userClass();
$userDetails=$userClass->userDetails($_SESSION['uid']);

$secret=$userDetails->google_auth_code;
$email=$userDetails->username.'@big686.club';
if($secret==''){
	require_once 'googleLib/GoogleAuthenticator.php';
	$ga = new GoogleAuthenticator();
	$secret = $ga->createSecret();
	$userClass->updateGa($userDetails->id,$secret);
	//update secret vào cơ sở dữ liệu
}
// echo $secret;die();
require_once 'googleLib/GoogleAuthenticator.php';

$ga = new GoogleAuthenticator();

$qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'Big686');


?>
<!DOCTYPE html>
<html>
<head>
    <title>2-Step Verification using Google Authenticator</title>
    <link rel="stylesheet" type="text/css" href="style.css" charset="utf-8" />
</head>
<body>
	<div id="container">
		<h1>2-Step Verification using Google Authenticator</h1>
		<div id='device'>

<p>Enter the verification code generated by Google Authenticator app on your phone.</p>
<div id="img">
<img src='<?php echo $qrCodeUrl; ?>' />
</div>

<form method="post" action="home.php">
<label>Enter Google Authenticator Code</label>
<input type="text" name="code" />
<input type="submit" class="button"/>
</form>
</div>
<div style="text-align:center">
	<h3>Get Google Authenticator on your phone</h3>
<a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank"><img class='app' src="images/iphone.png" /></a>

<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank"><img class="app" src="images/android.png" /></a>
</div>
</div>
</body>
</html>
