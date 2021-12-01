<?php
class Cerv_reports_model extends CI_Model {
	
	public function zero_dose($distcode, $tcode, $uncode){
		$this -> db -> select('uc.uncode, unname(uc.uncode), SUM(CASE WHEN bcg IS NULL AND penta1 IS NULL AND NOW() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS "# of Zero Dose Children"');
		$this -> db -> from('unioncouncil uc');
		$this -> db -> join('cerv_child_registration cerv','uc.uncode=cerv.uncode','LEFT');
		$this -> db -> where('uc.distcode', $distcode);
		if($tcode)
			$this -> db -> where('uc.tcode', $tcode);
		if($uncode)
			$this -> db -> where('uc.uncode', $uncode);
		$this -> db -> group_by('uc.uncode');
		return $this -> db -> get() -> result_array();
	}
	
	public function getTotalZeroDoseChildren($innerQuery){
		$this -> db -> select('sum("# of Zero Dose Children") total');
		$this -> db -> from("({$innerQuery}) as a");
		return $this -> db -> get() -> row_array();
	}
	
	public function dropouts_inner_query($distcode, $tcode, $uncode, $dropout_type){
		if($dropout_type == 'bcg-penta1')
			$this -> db -> select('uc.uncode, unname(uc.uncode), SUM(CASE WHEN bcg IS NOT NULL AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS bcg, SUM(CASE WHEN bcg IS NOT NULL AND penta1 IS NOT NULL AND now() > cerv.dateofbirth + INTERVAL \'43 days\' AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS penta1');
		else if($dropout_type == 'penta1-penta3')
			$this -> db -> select('uc.uncode, unname(uc.uncode), SUM(CASE WHEN penta1 IS NOT NULL AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS penta1, SUM(CASE WHEN penta1 IS NOT NULL AND penta2 IS NOT NULL AND now() > cerv.penta2 + INTERVAL \'29 days\' AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS penta3');
		else if($dropout_type == 'penta1-measles1')
			$this -> db -> select('uc.uncode, unname(uc.uncode), SUM(CASE WHEN penta1 IS NOT NULL AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS penta1, SUM(CASE WHEN penta1 IS NOT NULL AND measles1 IS NOT NULL AND now() > cerv.dateofbirth + INTERVAL \'9 months\' AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS measles1');
		else if($dropout_type == 'measles1-measles2')
			$this -> db -> select('uc.uncode, unname(uc.uncode), SUM(CASE WHEN measles1 IS NOT NULL AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS measles1, SUM(CASE WHEN measles1 IS NOT NULL AND measles2 IS NOT NULL AND now() > cerv.measles1 + INTERVAL \'29 days\' AND now() > cerv.dateofbirth + INTERVAL \'1 year\' + INTERVAL \'3 months\' AND now() < cerv.dateofbirth + INTERVAL \'2 years\' THEN 1 ELSE 0 END) AS measles2');
		$this -> db -> from('unioncouncil uc');
		$this -> db -> join('cerv_child_registration cerv','uc.uncode=cerv.uncode','LEFT');
		$this -> db -> where('uc.distcode', $distcode);
		if($tcode)
			$this -> db -> where('uc.tcode', $tcode);
		if($uncode)
			$this -> db -> where('uc.uncode', $uncode);
		$this -> db -> group_by('uc.uncode');
		return $this -> db -> get() -> result_array();
	}
	
	public function dropout_outer_query($innerQuery,$dropout_type){
		switch($dropout_type){
			case 'bcg-penta1':
				$first = 'bcg';
				$second = 'penta1';
				break;
			case 'penta1-penta3':
				$first = 'penta1';
				$second = 'penta3';
				break;
			case 'penta1-measles1':
				$first = 'penta1';
				$second = 'measles1';
				break;
			case 'measles1-measles2':
				$first = 'measles1';
				$second = 'measles2';
				break;
		}
		$this -> db -> select("a.uncode, a.unname, {$first}, {$second}, round((({$first}-${second})*100/NULLIF(${first},0)::double precision)::numeric) as dropout");
		$this -> db -> from("({$innerQuery}) as a");
		return $this -> db -> get() -> result_array();
	}
	
	public function dropout_total_query($outerQuery, $dropout_type){
		switch($dropout_type){
			case 'bcg-penta1':
				$first = 'bcg';
				$second = 'penta1';
				break;
			case 'penta1-penta3':
				$first = 'penta1';
				$second = 'penta3';
				break;
			case 'penta1-measles1':
				$first = 'penta1';
				$second = 'measles1';
				break;
			case 'measles1-measles2':
				$first = 'measles1';
				$second = 'measles2';
				break;
		}
		$this -> db -> select("sum({$first}) as {$first}, sum({$second}) as {$second}, round(((sum({$first})-sum({$second}))*100/NULLIF(sum({$first}),0)::double precision)::numeric) as total_dropout");
		$this -> db -> from("({$outerQuery}) as a");
		return $this -> db -> get() -> result_array();
	}
	
	public function asdquery(){
		$this -> load -> model('Filter_model');
			$this -> load -> library('reportfilters');		
			$reportPeriod = array("month-from-to-previous");
			//$reportPath = base_url()."Reports/vaccine_demand";
			$reportTitle = "Vaccine Consumption Report";
			//$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			//$allvaccines = array_column(getVaccines_options(true,1,true),"item_name","itemid");
			//$allvaccines['0'] = 'Product';
			/* $customDropDown1 = array(
				array(
					'0' => 'Indicator',
					'used_vials' => 'Vials Used',
					'used_doses' => 'Doses Used',
					'unused_vials' => 'Unusable Vials',
					'unused_doses' => 'Unusable Doses', 
					'closing_vials' => 'Closing Vials',
					'closing_doses' => 'Closing Doses',
				),
				$allvaccines
			);  */
			
				$dataHtml = $this->reportfilters->createReportFilters(true,true,true,false,$reportPeriod,false,NULL,NULL,"No","No",NULL);	
			
			$datArray['listing_filters'] = $dataHtml;
					 
			$link="Cerv/Reports/asd";		 
			$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() .$link.'/');
		//echo "<pre>"; print_r($datArray); exit;					 
		//return $datArray;		 
					 
					 
					 
					 
					 
					 
					 
					 
					 
		return $datArray;
	}
	
}