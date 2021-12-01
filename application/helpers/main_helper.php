

<?php

function tableTopInfo($subTitle,$distcode="",$tcode="",$facode="",$type="",$ind_name="",$year="",$month="",$advRepTitle="",$fmonthFrom="",$fmonthTo="")

{



	

	$ci =& get_instance();

    $ci->load->helper('my_function_helper');

	 //echo  $subTitle.'<br>'.$distcode.'<br>'.$_SESSION['Tehsil'].'<br>'.$_SESSION['Facility'];exit();

//$html=array();

	$html='';

	$html.=  '

	<div class="row">

		<div class="col-xs-3 col-xs-offset-5">

			<h3 style="font-weight: bold;">LHW - MIS</h3>

		</div>

	</div>

	<div style="margin-bottom: -20px;" class="row">

		<div class="col-xs-8 col-xs-offset-4">

			<h4 style="margin-top: 0px; margin-left: 40px; font-weight: bold;">'.$subTitle.'</h4>

		</div>

	</div>

	<hr>

	<div class="row">

		<div class="col-xs-9 col-xs-offset-3">

			<p class="reports-info-p"><span style=""><label class="reports-info-label">Province:</label> Sindh</span></p>';

			//return $html;exit();

			if($distcode=="")

				$distcode=$_SESSION['District'];

			

			if($distcode > 0)



					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">District:</label> '.$ci->DistrictName($distcode).'</span></p>';

			

			if($tcode=="")

				$tcode=$_SESSION['Tehsil'];

			if($tcode > 0)

					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Tehsil:</label> '.$ci->TehsilName($tcode).'</span></p>';

			

			if($facode=="")

				$facode=$_SESSION['Facility'];

			if($facode > 0)

				$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Facility:</label> '.$ci->FacilityName($facode).'</span></p>';

			if($type!="")

			{

				if($type =='lhw')

						$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Report Type:</label> LHW wise</span></p>';

				else

						$html.= '<p class="reports-info-p"><span style=""><label class="reports-info-label">Report Type:</label> Facility wise</span></p>';

			}

			if($advRepTitle != "")

					$html.= '<p class="reports-info-p"><span style=""><label class="reports-info-label">Report :</label> '.$advRepTitle.'</span></p>';

			if($ind_name != "")

					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Indicator:</label> '.$ind_name.'</span></p>';

			

			if($fmonthFrom != "")

					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Month From:</label> '.$fmonthFrom.'</span></p>';

			

			if($fmonthTo != "")

					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Month To:</label> '.$fmonthTo.'</span></p>';

			

			if($year > 0)

					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Year:</label> '.$year.'</span></p>';

			if($month > 0)

					$html.=  '<p class="reports-info-p"><span style=""><label class="reports-info-label">Month:</label> '.$month.'</span></p>';

				$html.=  '

		</div>

	</div>';



	return $html;



}



if(!function_exists('getListingReportTable')){



    function getListingReportTable($allData,$listingFor,$allTotal=NULL){
	print_r($allTotal);exit;


    $count = 0;

    $innerHead = '';

    $insiderow = '';

    $moon = array();

   

    $returnData = '<table width="100%" align="center" border="1" class="listing-report-table">';

    foreach($allData as $key => $value)

    {

        $headerRow = '';

        if($value['total'] )

        {   

            if($insiderow == '' || $insiderow != $value['insiderow'])

            {

                

                $insiderow = $value['insiderow'];

                

                if(count($moon) > 0)

                {   

                    //for section total

                    array_splice($moon, 0, 2);

                    $returnData .= "<tr style='font-weight:bold;'><td></td><td>Total:</td><td>";

                    $returnData .= implode("</td><td>",$moon);      

                    $returnData .= "</td></tr>";

                    $moon = array();

                } 

                $headerRow = "<tr><td colspan='".(count($value)-2)."'><b>$insiderow (Total $listingFor: ".$value['total'].")</td></tr>";

            }

            unset($value['insiderow']);

            unset($value['total']);

        }

        if($count == 0)

        {

            $returnData .= "<thead><tr><th>";

            $returnData .= implode("</th><th>",array_map("ucwords",array_keys($value)));

            $returnData .= "</th></tr></thead><tbody>";

        }       

        $count++;

        $returnData .= $headerRow;

        $returnData .= "<tr><td>";

        $Mcounter = 0;

        $code = '';

        $returnData .= implode("</td><td>", array_map(function($v)use(&$Mcounter, &$code){

                        if($Mcounter==0)

                            $code = $v;

                        if($Mcounter++ < 2)

                            return '<cl class="clickedReport" data-value="'.$code.'">'.$v.'</cl>';

                        return $v;

                    },array_values($value)));

        //$returnData .= implode("</td><td>",$value);       

        $returnData .= "</td></tr>";



        foreach($value as $k => $v)

        {

            

            $moon[$k] = isset($moon[$k]) ? $moon[$k] : 0;

            if(is_numeric($v)) {

                $moon[$k] +=  $v;

            }

        } 

    }

    if(count($moon) > 0 && $allTotal != 'NO')

    {

        //for section total

        array_splice($moon, 0, 2);

        $returnData .= "<tr style='font-weight:bold;'><td></td><td>Total:</td><td>";

        $returnData .= implode("</td><td>",$moon);      

        $returnData .= "</td></tr>";

        $moon = array();

    } 

    //for last row total

    if($allTotal)

    {

        foreach($allTotal as $key => $value)

        {

            $endbody ="<tr style='font-weight:bold;'><td>District Aggregate:</td><td></td><td>";

            $endbody .= implode("</td><td>",$value);

            $endbody .="</td></tr>";

            $returnData .= $endbody;        

        }

    }   

    if($count == 0)

    {

        $returnData .= "<thead><tr><th> No Record Found </th></tr></thead><tbody>";

    }

    return $returnData .= "</tbody></table>";

}

}

if(!function_exists('extract_indicator_query')){

function extract_indicator_query($arrayData, $fmonth, $level, $distcode,$report_table="flcfmr"){





    $formula        = $arrayData[0]["formula"];

    $ind_name       = $arrayData[0]["ind_name"];

    $num_text       = $arrayData[0]["numerator"];

    $den_text       = $arrayData[0]["denominator"];

    $multiple       = $arrayData[0]["multiple"];

    $ind_type       = $arrayData[0]["ind_type"];

    $is_inverse     = $arrayData[0]["is_inverse"];

    $result_text    = $arrayData[0]["result_text"];

    $description    = $arrayData[0]["description"];

    

    $divstr=explode("/",$formula);

    $num=$divstr[0];

    $den=$divstr[1];

    

    $divnumfields=explode("+",$num);

    for($i=0;$i<count($divnumfields);$i++){

        $divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";

    }   

    $numerator=implode("+",$divnumfields);

    

    $divnumfields=explode("+",$den);

    for($i=0;$i<count($divnumfields);$i++){

        $divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";

    }   

    $denominator=implode("+",$divnumfields);

    

    $table="";

    if($den!=""){

        $mul="*$multiple";

    }

    if($level=="district"){

        $hcode="distcode";

        $table=$report_table;//"flcfmr";

        $hname="districtname(distcode)";

    }

    if($level=="facility"){

        $hcode="facode";

        $table=$report_table;//"flcfmr";

        $hname="facilityname(facode)";

    }

    if($is_inverse=="1")

    {

        $orderType = "Asc";

    }else
    {

        $orderType = "Desc";

    }

    $wc="";

    $wc.=($level=="facility"?"and distcode='$distcode'":"");



    $qformula=($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul");

    $extratedquery="select $hcode, $hname, ($numerator::numeric) as \"$num_text\", ($denominator::numeric) as \"$den_text\", round(coalesce($qformula,0)::numeric,2) as \"$result_text\", '$ind_type' as unit from $table where fmonth='$fmonth' $wc group by $hcode order by \"$result_text\" $orderType";

    $tformula=($denominator==""?"sum(\"$num_text\")":"((sum(\"$num_text\"))::numeric//(sum(\"$den_text\"))::numeric)$mul");

    $extratedqueryTotal="select sum(\"$num_text\") as totalNum, sum(\"$den_text\") as totalDeNum, round(coalesce($tformula,0)::numeric,2) as totalAll, '$ind_type' as totalUnit from ($extratedquery) as a";

    return $extratedquery.'-::-'.$extratedqueryTotal.'-::-'.$description;

}

}
 function getComplianceReportTable($allData,$allTotal=NULL){ 
    $count = 0;
    $returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter tbl-lhwmr-compliance" data-filter="#filter" data-filter-text-only="true">
       ';
    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
            $months = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','total');
            $returnData .= "<thead>
            <tr style='background-color: #0072C6;color: #FFF;'><th colspan='2' class='Heading text-center'></th><th colspan='3' class='Heading text-center'>";
                $returnData .= implode("</th><th class='text-center' colspan='3'>",array_map("ucwords",array_values($months)));
                $returnData .= "</th></tr>
                <tr><th>";
                    $counter = 1;
                    $returnData .= implode("</th><th class='text-center'>", array_map(function($v)use(&$counter){
                        if($counter++ > 2)
                            return ucwords(substr($v, 0, -2));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }       
                $count++;
                $body ="<tr><td>";
                $counter = 0;
                $code = '';
                $body .= implode("</td><td>", array_map(function($v)use(&$counter, &$code){
                        if($counter==0)
                            $code = $v;
                        if($counter++ < 2)
                            return '<p class="clickedReport" data-value="'.$code.'">'.$v.'</p>';
                        return $v;
                    },array_values($value)));
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td></td>','<td>0</td>',$body);
    }

    if($allTotal)
    {
        foreach($allTotal as $key => $value)
        {
            $endbody ="<tr class='total-row' style='background-color: #111;color: #FFF;'><td></td><td style='font-weight:bold;'>Total:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$value);
            $endbody .="</td></tr>";//<td>$sumResult</td>
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
        }
    }               
    return $returnData .= "</tbody></table>";
}
function getComplianceFLCFReportTable($allData,$allTotal=NULL,$allTotalDue=NULL){   
    
    $count = 0;
    $returnData = '<table border="1" cellspacing="0" width="100%" align="center" style="text-align:center;" class="table table-bordered col-md-12 report-table">';
    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
            $returnData .= "<thead>";
            $returnData .= "<tr style='background-color: #0072C6;color: #FFF;' ><th class='text-center'>";
            $returnData .= implode("</th><th class='text-center'>", array_map('ucwords',array_keys($value)));
            $returnData .= "</th></tr></thead><tbody>";
            $count++;
        }           
        $body ="<tr><td class='text-center'>";
        $counter = 1;
        $body .= implode("</td><td class='text-center'>",array_map(function($v)use(&$counter,$value){
            if($counter <= 2)
            {
                $counter++;
                return $v;
            }
            if($counter++ == count($value))
                return '<b>'.$v.'</b>';

            return "<img width='20' height='20' src=\"../includes/images/".$v.".png\" />";
        },array_values($value)));       
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'>0</td>',$body);
    }

    if($allTotalDue)
    {
        $endbody ="<tr><td></td><td style='font-weight:bold;'>Total Due:</td>";
        for($ind = 1; $ind<13; $ind++)
        {
            $endbody .= "<td class='text-center'>".$allTotalDue."</td>";
            


        }
        $endbody .="<td class='text-center'>".($allTotalDue*12)."</td></tr>";
        $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);
    }   
    if($allTotal)
    {
        foreach($allTotal as $key => $value)
        {
            $endbody ="<tr style='font-weight:bold;'><td></td><td>Total Submited:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$value);
            $endbody .="</td></tr>";
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
            
        }

    }

    if($allTotalDue){
        
        //print_r($allTotal);
        foreach($allTotal as $key => $value)
        {
            //echo $allTotalDue = $allTotalDue;
            $value13 = $value['total13'];
            $bcb = $allTotalDue*12;
            $value13 = number_format(((intval($value13)/intval($bcb))*100),2);
            $arr_mod = array_map( function($val) use ($allTotalDue) { 
                
                $abc = intval($val)/intval($allTotalDue);
                $perc = number_format($abc*100,2);
                
                return $perc;
            }, $value);
            //print_r($arr_mod);
            $arr_mod['total13'] = $value13;
            $endbody ="<tr style='font-weight:bold ; background-color: #111;color: #FFF;'><td></td><td>Percent Submited:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$arr_mod);
            $endbody .="</td></tr>";
            $returnData .= $endbody;
        }

    }
    return $returnData .= "</tbody></table>";
}


?>