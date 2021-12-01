<?php
class ReviewComparison extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('dashboard/Reviewcomparison_model','review');
	}
	public function index()
	{
		$data['fmonth']='2019-09';
		$data['from_week']='2019-01';
		$data['to_week']='2019-42';
		$data['year']='2019';
		$data['filter']=$this -> input -> get('filter');
		
		$this -> load -> view('review_dashboard/review_comparison',$data);				
	
	}
	/* Coverage Compliances */
		public function compliances_data()
	{		
		$data['filter']=$this -> input -> get('filter');
		if($data['filter']=='monthly'){
			$data['fmonth']='2019-01';
			$data['year']='2019';
			$result=$this->review->compliances_data($year='2019',$monthly=TRUE,$quaterly=NULL);
		}elseif($data['filter']=='quarterly'){
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->compliances_data($year='2019',$monthly=FALSE,$quaterly=TRUE);
		}else{
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->compliances_data($year='2019',$monthly=FALSE,$quaterly=NULL);
		}
		
		unset($data['ym']);
		$data['caption'] =$result['caption'];
		$data['seriese'] =$result['dataseries'];
		$data['xAxisName'] = "Compliances";
		$data['yAxisName'] = "Percentage";
		$data['subCaption'] = "Coverage";
		$data['numberPrefix'] = "";
		echo $this -> load -> view('review_dashboard/graphs/column2d',$data,TRUE);
		
	}
	public function coverage_data()
	{		
			$data['filter']=$this -> input -> get('filter');
			if($data['filter']=='monthly'){
				$data['fmonth']='2019-09';
				$data['year']='2019';
				$result=$this->review->coverage_data($year='2019',$monthly=TRUE,$quaterly=NULL);
			
			}elseif($data['filter']=='quarterly'){
				$data['fmonth']='2019-09';
				$data['year']='2019';
				$result=$this->review->coverage_data($year='2019',$monthly=FALSE,$quaterly=TRUE);
			}else{
				
				$data['fmonth']='2019-09';
				$data['year']='2019';
				$result=$this->review->coverage_data($year='2019',$monthly=FALSE,$quaterly=NULL);
			}
		unset($result['ym']);
		/*	COverage Vaccines */
		$categories[0]['label'] = 'BCG';			
		$categories[1]['label'] ='Penta1';			
		$categories[2]['label'] ='Penta3';			
		$categories[3]['label'] ='Rota2';			
		$categories[4]['label'] = 'Measles1';			
		$data['xAxisname'] = "Vaccines";
		$data['yAxisName'] = "Percentage";
		$data['numberPrefix'] = "";
		$data['serieses'] =$result['dataseries'];
		$data['caption'] =$result['caption'];
		$data['categories'] = json_encode($categories);
		echo $this -> load -> view('review_dashboard/graphs/mscolumn2d',$data,TRUE);
		
	}
	public function dropout_data(){
		$data['filter']=$this -> input -> get('filter');
		if($data['filter']=='monthly'){
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->dropout_data($year='2019',$monthly=TRUE,$quaterly=NULL);
		}elseif($data['filter']=='quarterly'){
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->dropout_data($year='2019',$monthly=FALSE,$quaterly=TRUE);
		}else{
			
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->dropout_data($year='2019',$monthly=FALSE,$quaterly=NULL);
		}
		unset($data['ym']);
		$categories[0]['label'] = 'P1-P3';			
		$categories[1]['label'] ='P1-M1';			
		$categories[2]['label'] ='M1-M2';			
		$categories[3]['label'] = 'TT1-TT2';			
		$startMonth=01;
		$endMonth=03;
		$data['xAxisname'] = "Vaccines";
		$data['yAxisName'] = "Percentage";
		$data['numberPrefix'] = "";
		$data['serieses'] =$result['dataseries'];
		$data['caption'] =$result['caption'];
		$data['categories'] = json_encode($categories);
		echo $this -> load -> view('review_dashboard/graphs/mscolumn2d',$data,TRUE);
		
	}
		public function fullyimmunized_data()
	{
		$data['filter']=$this -> input -> get('filter');
		if($data['filter']=='monthly'){
			$data['fmonth']='2019-01';
			$data['year']='2019';
			$result=$this->review->fullyimmunized_data($year='2019',$monthly=TRUE,$quaterly=NULL);
		}elseif($data['filter']=='quarterly'){
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->fullyimmunized_data($year='2019',$monthly=FALSE,$quaterly=TRUE);
		}else{
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->fullyimmunized_data($year='2019',$monthly=FALSE,$quaterly=NULL);
		}
		
		unset($data['ym']);
		$data['caption'] =$result['caption'];
		$data['seriese'] =$result['dataseries'];
		$data['xAxisName'] = "Fully Immunized";
		$data['yAxisName'] = "Percentage";
		$data['subCaption'] = "Coverage";
		$data['numberPrefix'] = "";
		echo $this -> load -> view('review_dashboard/graphs/column2d',$data,TRUE);
		
	}
		public function childprotectedbirth_data()
	{
		$data['filter']=$this -> input -> get('filter');
		//print_r($data['filter']);exit;
		if($data['filter']=='monthly'){
			$data['fmonth']='2019-01';
			$data['year']='2019';
			$result=$this->review->childprotectedbirth_data($year='2019',$monthly=TRUE,$quaterly=NULL);
		}elseif($data['filter']=='quarterly'){
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->childprotectedbirth_data($year='2019',$monthly=FALSE,$quaterly=TRUE);
		}else{
			$data['fmonth']='2019-09';
			$data['year']='2019';
			$result=$this->review->childprotectedbirth_data($year='2019',$monthly=FALSE,$quaterly=NULL);
		}
		unset($data['ym']);
		//Caption set here 
		$data['caption'] =$result['caption'];
		$data['seriese'] =$result['dataseries'];
		$data['xAxisName'] = "Child Protected Birth";
		$data['yAxisName'] = "Percentage";
		$data['subCaption'] = "Coverage";
		$data['numberPrefix'] = "";
		echo $this -> load -> view('review_dashboard/graphs/column2d',$data,TRUE);
		
	}
	/*Access and Utilization Category wise data */
		public function categorywise_data()
	{		
			$data['filter']=$this -> input -> get('filter');
			if($data['filter']=='monthly'){
				$data['fmonth']='2019-09';
				$data['year']='2019';
				$result=$this->review->categorywise_data($year='2019',$monthly=TRUE,$quaterly=NULL);
			
			}elseif($data['filter']=='quarterly'){
				$data['fmonth']='2019-09';
				$data['year']='2019';
				$result=$this->review->categorywise_data($year='2019',$monthly=FALSE,$quaterly=TRUE);
			}else{
				
				$data['fmonth']='2019-09';
				$data['year']='2019';
				$result=$this->review->categorywise_data($year='2019',$monthly=FALSE,$quaterly=NULL);
			}
		unset($result['ym']);
		/*	Category wise data  */
		$categories[0]['label'] ='Category 1';			
		$categories[1]['label'] ='Category 2';			
		$categories[2]['label'] ='Category 3';			
		$categories[3]['label'] ='Category 4';			
		$data['xAxisname'] = "Categories";
		$data['yAxisName'] = "Percentage";
		$data['numberPrefix'] = "";
		$data['serieses'] =$result['dataseries'];
		$data['caption'] =$result['caption'];
		$data['categories'] = json_encode($categories);
		echo $this -> load -> view('review_dashboard/graphs/mscolumn2d',$data,TRUE);
		
	}
	
}
?>