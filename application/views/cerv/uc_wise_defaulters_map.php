
<div class="row">
	<div class="col-12" style="position: relative;">
		<div id="defaulters-map"></div>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="//code.highcharts.com/maps/modules/map.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<?php echo (isset($map))?$map:''; ?>

<script type="text/javascript">
	function formatter(e,ucwisemap='false'){
		var text= 'District';
		if(ucwisemap == 'true'){
			text = 'Union Council';
		}
		return text+': <b>' + e.point.name  + '</b><br> Total Defaulters: <b>' + e.point.value + ' </b>';
	}
	function eventHandler(e, run, fmonth){
		var dataId = e.point.id;
		if(run){
        	//var url = 'http://epiict.pacemis.com/Cerv/Dashboard/defaulters_map/'+dataId;
        	//var url = 'http://epikp.pacemis.com/Cerv/Dashboard/defaulters_map/'+dataId;
        	var url = 'http://epimis.cres.pk//Cerv/Dashboard/defaulters_map/'+dataId;
        	window.open(url, '_blank');
		}
	}
</script>