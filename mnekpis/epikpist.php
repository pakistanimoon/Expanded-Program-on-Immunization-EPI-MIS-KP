<?php 
ob_start();
session_start(); 
include("databaseFunctions.php");
$dbf = new DatabaseFunctions;
/*
2710550606	Percent of Children 12-23 months immunized (Received Measle-II)
2710550295	TT2 Coverage

*/

$ind1=isset($_REQUEST['ind'])?$_REQUEST['ind']:'';
switch($ind1){
	case '2710550606' : $ind='imz';
						break;
	case '2710550295' : $ind='tt2';
						break;
}
$fmonth=isset($_REQUEST['fmonth'])?$_REQUEST['fmonth']:'';
$distcode=isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';
$year = substr($fmonth, 3,4);
$month = substr($fmonth, 0,2);
$ffmonth=$year."-".$month;
		switch($ind){
			case 'imz' : $title="Percentage of Children 12-23 months immunized (Received Measle-II)";
						$c1title="Children 12-23 months received Measle-II";
						$c2title="Childern of Age 12-23 Years";
						$inddef = "Percentage of Children 12-23 months immunized (Received Measle-II)";
						$query1="select facode, facilityname(facode) as facility, coalesce(cri_r25_f18,0)+coalesce(cri_r26_f18,0) as imz, coalesce(round(NULLIF(getmonthly_survivinginfants(facode,'facility')::numeric,0),0),0) as den  from fac_mvrf_db where fmonth = '$ffmonth' and distcode='$distcode'";
						
						break;
			case 'tt2' : $title="Percentage of Pregnant Women received TT2 vaccine";
						$c1title="Pregnant Women received TT2";
						$c2title="Pregnant Women";
						$inddef = "Percentage of Pregnant Women received TT2 vaccine";
						$query1="select facode, facilityname(facode) as facility, coalesce(ttri_r9_f2,0) as tt2, round(NULLIF(getmonthly_plwomen_target(facode,'')::numeric,0),0) as den from fac_mvrf_db where fmonth = '$ffmonth' and distcode='$distcode'";
						
						break;
		}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>KPIs Indicator</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
<link type="text/css" rel="stylesheet" href="styles/jquery-ui-1.10.4.custom.min.css">
<link type="text/css" rel="stylesheet" href="styles/font-awesome.min.css">
<script language="JavaScript" src="Charts/FusionCharts.js"></script>
<script src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
function openmr(facode){
      window.open("http://epimis.kphealth.pk/FLCF-MVRF1/View/"+facode+"/<?php echo $year; ?>-<?php echo $month; ?>");
}
</script>
<style>
#mtable {
	margin: 10px auto;
	width: 100%;
}

#mtable, #mtable td {
	border: 1px solid #000; 
	border-collapse: collapse;
	padding: 5px;
}

.fmonth {
	width:100%;
}

.fmonth td{
	text-align: center;
}

.fmonth td a:link {
	text-decoration: none;
	color:black;	
}

.selectedmonth {
	background:#E4E4E4;
	color:white;
}

#htable {
	margin: 0 auto;
	width:100%;
}

table, tr, td{
	border: 1px solid #000; 
	border-collapse: collapse;
	padding: 5px;
}
th{
	border: 1px solid #000;
	background:#858AB6;
	color:white;
}

#epi{
	width:100%;
	float:left;
}


.green{
	color:green;
}

.red{
	color:red;
}
</style>
</head>

<body>
<?php
			$query="select district from districts where distcode='$distcode'";
			$result=$dbf->queryDB("psql",$query,"Forms");
			$row=$dbf->returnDBarray("psql",$result);
		?>
<div style="margin:10px; text-align:center; font-size:18px; font-weight:bold;">District: <?php echo $row['district']; ?></div>
<table class="fmonth"><tr> 
	<td <?php echo ($month=='01')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=01-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Jan <?php echo $year; ?></a></td>
	<td <?php echo ($month=='02')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=02-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Feb <?php echo $year; ?></a></td>
	<td <?php echo ($month=='03')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=03-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Mar <?php echo $year; ?></a></td>
	<td <?php echo ($month=='04')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=04-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Apr <?php echo $year; ?></a></td>
	<td <?php echo ($month=='05')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=05-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">May <?php echo $year; ?></a></td>
	<td <?php echo ($month=='06')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=06-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Jun <?php echo $year; ?></a></td>
	<td <?php echo ($month=='07')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=07-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Jul <?php echo $year; ?></a></td>
	<td <?php echo ($month=='08')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=08-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Aug <?php echo $year; ?></a></td>
	<td <?php echo ($month=='09')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=09-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Sep <?php echo $year; ?></a></td>
	<td <?php echo ($month=='10')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=10-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Oct <?php echo $year; ?></a></td>
	<td <?php echo ($month=='11')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=11-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Nov <?php echo $year; ?></a></td>
	<td <?php echo ($month=='12')?"class='selectedmonth'":""; ?>><a href="epikpist.php?ind=<?php echo $ind1; ?>&fmonth=12-<?php echo $year; ?>&distcode=<?php echo $distcode; ?>">Dec <?php echo $year; ?></a></td>
</tr></table>
<table id="htable">
  <tr>
    <th>KPI</th><td colspan="6"><?php echo $title; ?></td>
  </tr>
  <tr>
    <th>KPI Definition</th><td colspan="6"><?php echo $inddef; ?></td>
  </tr>
</table>

    <div id="epi" align="left">Chart will load here</div>
        <script type="text/javascript">
            var JanChart = new FusionCharts("Charts/Column2D.swf", "JanChartId", "100%", "300", "0", "1");
            var url="epiind.php?ind=<?php echo $ind; ?>&fmonth=<?php echo $ffmonth; ?>&distcode=<?php echo $distcode; ?>";
			JanChart.setXMLUrl(url);
      		JanChart.render("epi");
      	</script>

<table id="mtable">
  <tr>
    <th>S#</td>
    <th>EPI Center Code</th>
    <th>EPI Center Name</th>
    <th><?php echo $c1title; ?></th>
    <th><?php echo $c2title; ?></th>
  </tr>
  <?php
		$result=$dbf->queryDB("psql",$query1,"Forms");
		$i=1;
		while($row=$dbf->returnDBarray("psql",$result)){
		?>
		  <tr onClick="openmr('<?php echo $row['facode']; ?>', '<?php echo $ffmonth; ?>')" style="cursor: pointer;">
			<td><?php echo $i; ?></td>
			<td><div><?php echo $row['facode']; ?></div></td>
			<td><div><?php echo $row['facility']; ?></div></td>
			<td><div><?php echo $row[$ind]; ?></div></td>
			<td><div><?php echo $row['den']; ?></div></td>
		  </tr>
			<?php
			$i++;
		}
  ?>
 </table>
</body>
</html>
