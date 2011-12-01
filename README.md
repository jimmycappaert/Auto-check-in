# Auto check-in

## Do automatic Foursquare check-ins based on your current location.

Full README to come, just a quick setup guide now. I didn't want to use MongoDB, MySQL, Redis, ... for storing some things right now, so I wrote two basic keyval functions that do just that. They use a local database file.

You'll need:

- an iPhone 3G, 3GS, 4 or 4S
- Geoloqi iOS application and account
- a Foursquare account

How you can set it up:

1) Edit 'config/tokens.php' and add your Geoloqi auth token. Also create your own Foursquare app and get an oAuth token for it, and fill in the details in the same file.
2) Edit config/locations.php and add your locations you want to be automatically checked in to. You need to fill in the coordinates, Foursquare venue ID and how we should push the check-in (default is public and Twitter, supposing you have it linked to your Foursquare account).
3) Run 'autocheckin.php'.
4) Do a happy dance.

Cheers.
