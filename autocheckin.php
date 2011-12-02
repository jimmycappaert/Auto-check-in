<?php

/*
 *	Auto check-in
 *	Do automatic Foursquare check-ins based on your current location.
 * 	https://github.com/jimmycappaert/Auto-check-in
 *
 *	Jimmy Cappaert
 * 	<jimmy@cappaert.com>
 */

// Init external libraries 

require_once("lib/fsq/FoursquareAPI.class.php");

// Init proprietary payloads

require_once("includes/functions.php");
require_once("config/locations.php");
require_once("config/tokens.php");

// Let's go!

$results = json_decode(getLocation());

if(!$results->error) {

	$latitude = $results->location->position->latitude;
	$longitude = $results->location->position->longitude;

	if($latitude && $longitude) {

		foreach($locations as $location=>$details) {

			if(calcDistance($latitude, $longitude, $details['cords']['latitude'], $details['cords']['longitude']) < 0.1) {

				$key = "VENUE_".$details['fsq']['venueid'];

				if(getValue($key) != date("Ymd", time())) {

					setValue($key, date("Ymd", time()));
					doCheckin($location);

				}

			}

		}

	}

}

exit;

?>
