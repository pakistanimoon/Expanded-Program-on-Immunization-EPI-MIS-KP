<style>
	#defaulters-map{
		display: inline-table;
		width: 100%;
		height: 500px;
	}
</style>
<div class="row">
	<div class="col-12" style="position: relative;">
		<div id="defaulters-map"></div>
	</div>
</div>

<!-- Replace the value of the key parameter with your own API key. -->

<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var map;
	var goldStar = {
					path: 'M10,20v-6h4v6h5v-8h3L12,3 2,12h3v8z',
					fillColor: '#154e9b',
					fillOpacity: 0.8,
					scale:1,
					strokeColor: '#154e9b',
					strokeWeight : 2
				};
				
	//var src = 'http://epiict.pacemis.com/Cerv/Dashboard/kml_generator/'+'<?php echo $uncode; ?>';
	var src = 'http://epikp.pacemis.com/Cerv/Dashboard/kml_generator/'+'<?php echo $uncode; ?>';

function initMap() {
		map = new google.maps.Map(document.getElementById('defaulters-map'), {
			//center: {lat: 33.700635, lng: 73.064077},
			zoom: 10.5
		});
		//alert(map.getCenter());
		var geocoder = new google.maps.Geocoder();
		var intervalSeconds = 1.5;
		var on = true;
		<?php
		$i=1;
		foreach($defaulters as $skey => $child){
			?>
			var $infocontent<?php echo $i; ?> = `
								<div class="row" style="margin: 0px;">
									<div class="col-lg-12">
										<table class="table table-bordered table-striped table-hover table-custom-popup">
											<thead>
												<tr>
													<th>S.#</th>
													<th>Image</th>
													<th>Child Name</th>
													<th>Child Father Name</th>
													<th>Vaccinator Name</th>
													<th>Address</th>
													<th>Action</th>
												</tr>
											</thead>
										<tbody>`;
			$infocontent<?php echo $i; ?> += `
							<tr>
								<td><?php echo $skey+1; ?></td>
								<td>
									<img style="height: 40px; border-radius: 2px;" src="<?php echo (file_exists("./webapis/cerv/assets/childs/{$child['child_registration_no']}.jpg"))?'http://islamabad.epimis.pk/webapis/cerv/assets/childs/'.$child['child_registration_no'].'.jpg':'http://epiict.pacemis.com/webapis/cerv/assets/childs/default.png'; ?>">
								</td>
								<td><?php echo $child['nameofchild']; ?></td>
								<td><?php echo $child['fathername']; ?></td>
								<td><?php echo $child['vaccinator']; ?></td>
								<td><?php echo $child['housestreet'].' '.$child['villagemohallah'].', '.$child['unioncouncil'].', '.$child['district']; ?></td>
								<td><a target="_blank" href="<?php echo base_url().'childs/Reports/child_cardview?cardno='.$child['child_registration_no']; ?>">View Detail</a></td>
							</tr>`;
			$infocontent<?php echo $i; ?> += `</tbody>
						</table>
					</div>
				</div>`;
			//geocodeAddress(geocoder, map);
			var address<?php echo $i; ?> = "<?php echo $child['housestreet'].' '.$child['villagemohallah'].', '. $child['unioncouncil']; ?>";
			geocoder.geocode({'address': address<?php echo $i; ?>}, function(results, status) {
				if (status === 'OK') {
					//resultsMap.setCenter(results[0].geometry.location);
					var marker<?php echo $i; ?> = new google.maps.Marker({
						map: map,
						icon: 	{
									path: google.maps.SymbolPath.CIRCLE,
									scale: 3,
									fillColor: 'red',
									fillOpacity: 0.8,
									strokeColor: 'red',
									strokeWeight : 2 ,
								},
						title: "<?php echo $child['nameofchild']; ?>",
						position: results[0].geometry.location
					});
					var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
						content: $infocontent<?php echo $i; ?>
					});
					marker<?php echo $i; ?>.addListener('click', function() {
						infowindow<?php echo $i; ?>.open(map, marker<?php echo $i; ?>);
					});
					//wait = true;
					//setTimeout("wait = true", 2000);
				} else {
					console.log('Geocode was not successful for the following reason: ' + status);
				}
			});
		<?php
			$i++;
		} ?>
		var kmlLayer = new google.maps.KmlLayer(src,{
			suppressInfoWindows: true,
			preserveViewport: false,
			map: map
		});
		google.maps.event.addListener(kmlLayer, 'defaultviewport_changed', function() {
			var getCenter = kmlLayer.getDefaultViewport().getCenter();
			map.setCenter(getCenter);
		});
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuUJa9F40swmKWlO5Y2rCAn7eW1A3-vqA&callback=initMap&libraries=places"></script>