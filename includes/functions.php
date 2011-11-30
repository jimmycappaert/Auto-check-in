<?php

/*
 * Functions 
*/

function calcDistance($lat1, $lon1, $lat2, $lon2) {

        $theta  = $lon1-$lon2;
        $dist   = sin(deg2rad($lat1))*sin(deg2rad($lat2))+cos(deg2rad($lat1))*cos(deg2rad($lat2))*cos(deg2rad($theta));
        $dist   = acos($dist);
        $dist   = rad2deg($dist);
        $miles  = $dist*60*1.1515;

        return ($miles*1.609344);

}

function getLocation() {

	global $tokens;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.geoloqi.com/1/location/last");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: OAuth ".$tokens['geoloqi']['access']));

	return curl_exec($ch);

}

function doCheckin($location) {

	global $tokens, $locations;

	$params = array("venueId" => $locations[$location]['fsq']['venueid'], "broadcast" => $locations[$location]['fsq']['broadcast']);

	$foursquare = new FoursquareAPI($tokens['fsq']['client_key'], $tokens['fsq']['client_secret']);
	$foursquare->SetAccessToken($tokens['fsq']['auth_token']);	
	$response = $foursquare->GetPrivate("checkins/add", $params, true);

}

function getValue($key) {	

	$fd = fopen("db", "r");
		
	while(!feof($fd)) {

		$line = fgets($fd, 2048);
	
		if(preg_match("/^$key=/", $line)) {

			$raw = explode("=", $line);
			return chop($raw[1]);

		}

	}

	fclose($fd);

}

function setValue($key, $value) {

	$contents = "";
	$set = false;

        $fd = fopen("db", "w+");
 
        while(!feof($fd)) {

		$line = fgets($fd, 2048);

                if(preg_match("/^$key=/", $line)) {

                        $raw = explode("=", $line);
                        $contents .= $key."=".$value."\n";
			$set = true;

                } else {

			$contents .= fgets($fd, 2048)."\n";

		}

        }

	if($set != true) {

		$contents .= $key."=".$value."\n";

	}
	
	fwrite($fd, $contents);
	fclose($fd);

}

?>
