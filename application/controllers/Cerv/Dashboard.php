<?php
//local 
class Dashboard extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this -> load -> model('Cerv_model','cerv');
	}
	
	public function vaccination(){
		$dateParam = ($this -> input -> get('date'))?date('Y-m-d',strtotime($this -> input -> get('date'))):date('Y-m-d');
		$data['todaylatlong'] = $this -> cerv -> datewise_latlong($dateParam);
		foreach($data['todaylatlong'] as $key => $latlong){
			$data['latlongvaccination'][$latlong['latitude']] = $this -> cerv -> latlong_vaccination($latlong['latitude'],$latlong['longitude'],$dateParam);
		}
		
		$data['data'] = $data;
		$data['fileToLoad'] = 'cerv/vaccination';
		$data['pageTitle']='CERV Vaccination | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	 
	public function coverage(){
		$fmonth = ($this -> input -> get('fmonth'))?$this -> input -> get('fmonth'):date('Y-m',strtotime('first day of previous month'));
		$yearmonth = explode('-',$fmonth);
		$data['ucmonthlycoverage'] = $this -> cerv -> uc_coverage($yearmonth[0],$yearmonth[1]);
		$data['data'] = $data;
		$data['fileToLoad'] = 'cerv/uccoverage';
		$data['pageTitle']='CERV Coverage | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	
	public function defaulters(){
		$dateParam = ($this -> input -> get('date'))?date('Y-m-d',strtotime($this -> input -> get('date'))):date('Y-m-d');
		$data['defaulters'] = $this -> cerv -> to_date_defaulters($dateParam);
		//echo $this -> db -> last_query();exit;
		$data['data'] = $data;
		$data['fileToLoad'] = 'cerv/defaulters';
		$data['pageTitle']='CERV Defaulters | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	
	public function defaulters_map($uncode=NULL){
		$data['defaulters'] = $this -> cerv -> to_date_defaulters_list($uncode);
		$data['uncode'] = $uncode;
		$data['data'] = $data;
		$data['fileToLoad'] = 'cerv/defaulters_map';
		$data['pageTitle']='CERV Defaulters | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	
	public function kml_generator($uncode){
		$result['row'] = $this -> cerv -> getkmldata($uncode);
		echo $this -> load -> view('cerv/kmlgenerator',$result,TRUE);
	}
	
	public function uc_wise_defaulters_map(){
		$defaulters = $this -> cerv -> uc_wise_to_date_defaulters_count();
		//echo $this -> db -> last_query();exit;
		$serieses = $dataSeries = array();
		$serieses['name'] = "UC Wise Defaulter Childs";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = 'center';
		$i=0;
		foreach($defaulters as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = $row -> cnt;
			$i++;
		}
		array_push($dataSeries,$serieses);
		$map['serieses'] = "".json_encode($dataSeries,JSON_NUMERIC_CHECK)."";
		$map['colorAxis'] = "{
			dataClasses: [{
				to: 9,
				color: '#D7E3F4',
				name: '< 10'
			}, {
				from: 10000,
				to: 30000,
				color: '#AFC6E9', 
				name: '10 - 100'
			}, {
				from: 101,
				to: 500,
				color: '#87AADE',
				name: '101 - 500'
			}, {
				from: 501,
				to: 1000,
				color: '#5F8DD3',
				name: '501 - 1,000'
			}, {
				from: 1001,
				color: '#2C5AA0',
				name: '> 1,000'
			}]
		}";
		$map['heading']['mapName'] = " UC Wise Defaulter Childs";
		//$map['heading']['subtittle'] = "UC Wise map";
		$map['heading']['run'] = true;
		$map['id'] = "defaulters-map";
		$map['ucwisemap'] = "true";
		//$map['fmonth'] = "";
		$data['map'] = $this -> load -> view('thematic_maps/parts_view/map',$map,TRUE);
		$data['data'] = $data;
		$data['fileToLoad'] = 'cerv/uc_wise_defaulters_map';
		$data['pageTitle']='CERV Defaulters | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	
	public function attendence(){
		$fmonth = ($this -> input -> get('fmonth'))?$this -> input -> get('fmonth'):date('Y-m',strtotime('first day of previous month'));
		$yearmonth = explode('-',$fmonth);
		$data['firstDate'] = $firstDate = strtotime(date('Y-m-d',strtotime($fmonth)));
		$data['lastDate'] = $lastDate = strtotime(date('Y-m-t',strtotime($fmonth)));
		$data['attendence'] = $this -> cerv -> attendence($firstDate,$lastDate);
		$data['data'] = $data;
		$data['fileToLoad'] = 'cerv/attendence';
		$data['pageTitle']='CERV Attendence | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	
}
?>