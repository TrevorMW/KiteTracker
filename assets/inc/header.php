<?php $permalink = basename($_SERVER['REQUEST_URI']);
$permalink = str_replace('.php','',$permalink);?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>KiteTracker</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="assets//css/style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="assets/scripts/cookie.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAurG7BXBQXqdyRebvS68YZ8-GkfFp3WDE&amp;sensor=false">
</script>
</head>
<body onLoad="load_map_utilities();">
<div class="wrapper header">
	<nav class="navbar navbar-inverse" role="navigation">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">KiteTracker</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav pull-right">
                <li><a href="/KiteTracker/">About Swallow-tailed Kites</a></li>
                <li><a href="/KiteTracker/recentSightings.php">Recent sightings</a></li>
                <li><a href="/KiteTracker/reportSighting.php">Report a sighting</a></li>
            </ul>
        </div>

	</nav>
</div>


