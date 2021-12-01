<div class="container bodycontainer">
	<div class="row cst-heading-row">
		<div class="col-lg-12 heading-cst-col">
			<h3 class="heading-cst">Date wise Vaccination Details</h3>
		</div>
	</div>
	<div class="row cst-search-row">
		<div class="col-md-4 col-md-offset-4">
			<input type="text" id="vaccination-date" class="form-control dp" data-date-format="yyyy-mm-dd" placeholder="Select Date">
		</div>
		<div class="col-md-4">
			<button type="button" id="get-vaccination" onclick="getVaccination();" class="btn btn-succes">Submit</button>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div id="map" style="height:500px;"></div>
		</div>
	</div>
</div>
<script>
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
	//fro isb
	 /* function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 33.6160373, lng: 72.9460229},
			zoom: 10
		});  */
	//fro peshawar
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 34.0151, lng: 71.5249},
			zoom: 9.8       
		});
			
		//map.data.loadGeoJson('https://nominatim.openstreetmap.org/search.php?q=Peshawar,KhyberPakhtunkhwa%20Pakistan&polygon_geojson=1&format=geojson');
		map.data.loadGeoJson(base_url+'assets/cerv/districtkmlp.php');
		
		<?php
		foreach($todaylatlong as $key => $val){
		?>
		var marker<?php echo $key; ?> = new google.maps.Marker({
			position: {lat: <?php echo (isset($val['latitude']))?$val['latitude']:34; ?>, lng: <?php echo (isset($val['longitude']))?$val['longitude']:71; ?>},
			map: map,
			icon: base_url+'assets/cerv/vaccination-red.svg',
			title: 'Information for all children vaccinated for selected date' 
		});
		var $infocontent<?php echo $key; ?> = `
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
		<?php
		foreach($latlongvaccination[$val['latitude']] as $skey => $child){
		?>
		$infocontent<?php echo $key; ?> += `
							<tr>
								<td><?php echo $skey+1; ?></td>
								<td>
									<!--<img style="height: 40px; border-radius: 2px;" src="<?php echo (file_exists("./webapis/cerv/assets/childs/{$child['child_registration_no']}.jpg"))?'http://islamabad.epimis.pk/webapis/cerv/assets/childs/'.$child['child_registration_no'].'.jpg':'http://epiict.pacemis.com/webapis/cerv/assets/childs/default.png'; ?>">-->
									<img style="height: 40px; border-radius: 2px;" src="<?php echo (file_exists("./webapis/cerv/assets/childs/{$child['child_registration_no']}.jpg"))?'http://islamabad.epimis.pk/webapis/cerv/assets/childs/'.$child['child_registration_no'].'.jpg':'http://epikp.pacemis.com/webapis/cerv/assets/childs/default.png'; ?>">
								</td>
								<td><?php echo $child['nameofchild']; ?></td>
								<td><?php echo $child['fathername']; ?></td>
								<td><?php echo $child['vaccinator']; ?></td>
								<td><?php echo $child['villagemohallah']; ?></td>
								<td><a target="_blank" href="<?php echo base_url().'childs/Reports/child_cardview?cardno='.$child['child_registration_no']; ?>">View Detail</a></td>
							</tr>`;
			
		<?php
		}
		?>
		$infocontent<?php echo $key; ?> += `</tbody>
				</table>
			</div>
		</div>`;
		var infowindow<?php echo $key; ?> = new google.maps.InfoWindow({
			content: $infocontent<?php echo $key; ?>
		});
		marker<?php echo $key; ?>.addListener('click', function() {
			infowindow<?php echo $key; ?>.open(map, marker<?php echo $key; ?>);
		});
		<?php } ?>
	}
	function getVaccination(){
		var $vaccinationDate = $('#vaccination-date').val();
		if($vaccinationDate != ''){
			window.location.href = base_url+'Cerv/Dashboard/vaccination?date='+$vaccinationDate;
		}else{
			alert('Please select a date to proceed!');
		}
	}
	
	
	
	
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuUJa9F40swmKWlO5Y2rCAn7eW1A3-vqA&callback=initMap&libraries=places"></script>