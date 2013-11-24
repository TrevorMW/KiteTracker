<?php
$permalink = basename($_SERVER['REQUEST_URI']);
$permalink = str_replace('.php','',$permalink);
if($permalink == 'recentSightings'){
	$bodyLoad = 'onLoad=";"';
} else if($permalink == 'reportSighting'){ } else {}; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>KiteTracker</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Fjord+One|PT+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="assets/scripts/cookie.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAurG7BXBQXqdyRebvS68YZ8-GkfFp3WDE&amp;sensor=true">
</script>
</head>
<body onLoad="load_map_utilities();">
<div class="wrapper header">
		<nav class="navbar navbar-inverse" role="navigation">
			<form class="navbar-form navbar-right" role="search" id="changeZip">
		      <div class="form-group">
		        <input type="text" class="form-control"  placeholder="Enter a new zipcode">
		      </div>
		      <button type="submit" class="btn btn-default btn-primary">Submit</button>
		    </form>
			<ul class="nav navbar-nav  pull-right">
				<li><a href="/KiteTracker/">About Swallow-tailed Kites</a></li>
				<li><a href="/KiteTracker/recentSightings.php">Recent sightings</a></li>
				<li><a href="/KiteTracker/reportSighting.php">Report a sighting</a></li>
			</ul>
			<a class="navbar-brand" href="#">KiteTracker</a>
		</nav>
	</div>