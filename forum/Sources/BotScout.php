<?php

if (!defined('SMF'))
	die('Hacking attempt...');

function checkBotScout($username, $email)
{
	global $sourcedir, $txt, $webmaster_email;

	// Your optional API key (if you don't have one 
	// you can get one here: http://botscout.com/)
	$APIKEY = '';

	// Send e-mail notices?
	$send_alerts = false;

	$ip = $_SERVER['REMOTE_ADDR'];
	$email = urlencode($email);

	$query = 'http://botscout.com/test/?multi&mail=' . $email . '&ip=' . $ip . (!empty($APIKEY) ? '&key=' . $APIKEY : '');

	if (function_exists('curl_init'))
	{
		$ch = curl_init($query);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returned_data = curl_exec($ch);
		curl_close($ch);
	}
	else
	{
		require_once($sourcedir . '/Subs-Package.php');

		$returned_data = fetch_web_data($query);
	}

	if(substr($returned_data, 0,1) == '!'){
		// if the first character is an exclamation mark, an error has occurred  
		$err_msg = fatal_lang_error($returned_data, true);
		exit;
	}

	if (empty($returned_data))
		return false;
	else
		$returned_data = explode('|', $returned_data);

		// sample 'MULTI' return string 
		// Y|MULTI|IP|4|MAIL|26|NAME|30
		
		// $botdata[0] - 'Y' if found in database, 'N' if not found, '!' if an error occurred 
		// $botdata[1] - type of test (will be 'MAIL', 'IP', 'NAME', or 'MULTI') 
		// $botdata[2] - descriptor field for item (IP)
		// $botdata[3] - how many times the IP was found in the database 
		// $botdata[4] - descriptor field for item (MAIL)
		// $botdata[5] - how many times the EMAIL was found in the database 
		// $botdata[6] - descriptor field for item (NAME)
		// $botdata[7] - how many times the NAME was found in the database 

	if ($returned_data[0] == 'Y' && $send_alerts)
	{
		require_once($sourcedir . '/Subs-Post.php');

		sendmail($webmaster_email, $txt['botscout_mail_subject'], sprintf($txt['botscout_mail_body'], $username, $email, $ip));
		fatal_lang_error('registration_disabled', false);
	}
	elseif ($returned_data[0] == 'Y')
		fatal_lang_error('registration_disabled', false);
	else
		return;
}

?>