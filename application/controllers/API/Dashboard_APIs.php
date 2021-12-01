<?php
class Dashboard_APIs extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this -> load -> model('maps/Maps_model','map');
	}
	
	public function main_func()
	{
		$url = base_url().'thematic_maps/AccessToHealthServices/getUC_detailData';
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		
		$aray = http_build_query(
									array
									(
										'services' => 'outreach',
										'reportType' => 'yearly',
										'vaccineId' => '2',
										'vaccineBy' => 'All',
										'year' => '2018'
									)
								);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		// receive server response ...
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		echo  "<!DOCTYPE html>
							<html>" .
								$this -> load -> view('thematic_template/style', "",TRUE) .
								"<body>
									<div class=\"flypanels-container preload\">" .
										$this -> load -> view('thematic_template/main_menu',"", TRUE);
		echo $server_output;
		echo "
					<div class=\"footer_copyrights\">
						<i class=\"fa fa-copyright\" aria-hidden=\"true\"></i> CopyRight All Rights Reserve.Health Department Government of Khyber Pakhtunkhwa.
					</div>
				</body>
			</html>";
	}
}
?>