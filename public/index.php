<?php
# Live Man's Switch v0.1

require_once('../conf.php');

function require_auth($AUTH_USER='admin', $AUTH_PASS='test', $stop_here=true) {

	header('Cache-Control: no-cache, must-revalidate, max-age=0');

	$has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

	$is_not_authenticated = (
		!$has_supplied_credentials ||
		$_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
		$_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
	);

	if ($is_not_authenticated) {
    if($stop_here){
      header('HTTP/1.1 401 Authorization Required');
  		header('WWW-Authenticate: Basic realm="Who goes there?"');
      exit("Access denied, you can reload or try in another browser. Possible users (which are linked to different actions) are: live, test, check");
    }
		return false;
	} else return true;

}


if(require_auth('live',$PW['live'],false) || require_auth('alive',$PW['live'],false)){ // main person is checking in

  if(touch($switch_file))
    echo "OK, enjoy your life! Please check back in whenever possible. Otherwise the switch will trigger in $config_days_switch days: ".date('F d Y', strtotime("+$config_days_switch days"));

  else echo "Could not update the status file. Contact your server admin ASAP.";

}
elseif(require_auth('test',$PW['live'],false)){ // main person is manually triggering the switch

  if(touch($switch_file, time() - (($config_days_switch+1) * 60 * 60 * 24)))
    echo "OK, you manually triggered the switch. Your friend will now have access.";

  else echo "Could not update the status file. Contact your server admin ASAP.";

}
elseif(require_auth('check',$PW['check'],true)){ // friend is checking status

  $alive_date = filemtime($switch_file);

  if ($alive_date) {

    $now = time(); // or your date as well
    $date_diff = $now - $alive_date;

    $days_diff = round($date_diff / (60 * 60 * 24));

    if($days_diff <= $config_days_switch){

      echo "Good news, your friend last checked in $days_diff days ago on ". date("F d Y H:i:s", $alive_date). " UTC";

    } else {

      echo "Looks like your friend has last checked in $days_diff days ago on ". date("F d Y H:i:s", $alive_date). " UTC. Here is their message for you: <p>";

      echo $PAYLOAD;
    }


  } else echo "Could not check the status file. Possibly your friend has not checked in yet. Or there's a technical problem...";

}
