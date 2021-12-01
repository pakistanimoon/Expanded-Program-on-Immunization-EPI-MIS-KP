<?php
$lat = $this -> uri -> segment(3); //exit;
$long = $this -> uri -> segment(4); //exit;
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
		<link href="http://epiict.pacemis.com/includes/assets/img/epi.png" rel="shortcut icon" type="image/png">
		<style>
		  #map {
			
				height:auto;
				min-height:500px;
				width:100%;
		   }
		   .custom-border{
				border: 1px solid #e7e7e7;
				border-radius: 3px;
				box-shadow: 0px 0px 4px 1px #eaeaea
		   }
		   .btn-custom-back{
				float: left;
				margin-top: 15px;
				margin-bottom: 10px;
		   }
		</style>
	</head>
	<body>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 text-center custom-border" style="background: #0c0c85;padding: 2px;border-radius: 5px; color: white;">
				<h3 class="text-warning" style="margin-left: 5px;"><i class="fa fa-map-marker"></i> Location of Hospital where Child is Vaccinated</h3>
				<div id="map"></div>
			</div>
		</div>
		<script>
			// Initialize and add the map
			function initMap() {
				// The location of Uluru 33 37 13.59     73  00   6.91
				var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};
				// The map, centered at Uluru
				var map = new google.maps.Map(document.getElementById('map'), {
						zoom: 16, 
						center: uluru
				});
				// The marker, positioned at Uluru
				var marker = new google.maps.Marker({
					position: uluru, 
					icon:'http://isbhosp.nhsrc.pk/Images/teeku.png', 
					map: map
				});
			}
		</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmTQ-bxSu9wEwPoFhONtXUjeC6cNbIqU8&callback=initMap"></script>
	</body>
</html>
