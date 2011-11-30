<?php

/*
 *	Auto check-in
 *	Do automatic Foursquare check-ins based on your current location.
 * 	https://github.com/jimmycappaert/Auto-check-in
 *
 *	Jimmy Cappaert
 * 	<jimmy@cappaert.com>
 */

// Init 

require_once("lib/fsq/FoursquareAPI.class.php");
require_once("lib/redis/redis.php");
require_once("lib/redis/redis.pool.php");
require_once("lib/redis/redis.peer.php");
require_once("includes/functions.php");
require_once("config/locations.php");
require_once("config/tokens.php");

// Let's go!

$results = json_decode(getLocation());
$latitude = $results->location->position->latitude;
$longitude = $results->location->position->longitude;

// Loop known locations to see if a check-in is needed

foreach($locations as $location=>$details) {

	if(calcDistance($latitude, $longitude, $details['cords']['latitude'], $details['cords']['longitude']) < 0.1) {

		if(getValue("VENUE_".$location) != date("Ymd", time())) {

			setValue("VENUE_".$location, date("Ymd", time()));
			doCheckin($location);

		}

	}

}

?>
