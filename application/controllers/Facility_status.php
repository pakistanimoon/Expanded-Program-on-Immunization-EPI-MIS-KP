<?php 
class Facility_status extends CI_Controller{

	protected $_sub_module;

	function __construct()
	{
		parent::__construct();
		$this->load->model('Facility_status_model', 'model');
		$this->load->helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
		$this->_sub_module = 'facility_status';
	}

	function fac_status_view()
	{
		$facode = $this->uri->segment(3);
		$data = array();
		$data['data'] = $this->model->fac_status_view($facode, TRUE);
		//echo '<pre>';print_r($data);exit;
		$status = isset($data['data']['status_data'][0]['status']) ? $data['data']['status_data'][0]['status'] : '';
		$epi_w_y = isset($data['data']['status_data'][0]['w_y_from']) ? $data['data']['status_data'][0]['w_y_from'] : '';
		//$data['status_filters'] = $this->status_filters($status);
		$data['epi_w_y_filter'] = $this->epi_week_year_filter($epi_w_y, TRUE, $data['data']['status_data']);
		
		$data['fac_name'] = get_Facility_Name($facode);
		$data['facode'] = $facode;
		$data['fileToLoad']= 'system_setup/facility_status_view';
		$data['pageTitle']='EPI-MIS Facility Status';
		//template_loader('system_setup/facility_status_view',$data, array($this->_sub_module));
		$this->load->view('template/epi_template',$data,array($this->_sub_module));
	}

	function fac_status_save()
	{
		$data = array();
		$ds_save = $this->input->post('ds_save') ? $this->input->post('ds_save') : NULL;
		$vacc_save = $this->input->post('vacc_save') ? $this->input->post('vacc_save') : NULL;
		$data['facode'] = $this->input->post('facode') ? $this->input->post('facode') : NULL;
		$status_vacc = $this->input->post('status_vacc') ? $this->input->post('status_vacc') : NULL;
		$status_ds = $this->input->post('status_ds') ? $this->input->post('status_ds') : NULL;
		$reason_vacc = $this->input->post('reason_vacc') ? $this->input->post('reason_vacc') : NULL;
		$reason_ds = $this->input->post('reason_ds') ? $this->input->post('reason_ds') : NULL;
		$data['m_y_from'] = $this->input->post('m_y_from') ? $this->input->post('m_y_from') : NULL;
		$epi_year = $this->input->post('epi_year') ? $this->input->post('epi_year') : NULL;
		$epi_week = $this->input->post('epi_week') ? $this->input->post('epi_week') : NULL;
		if(isset($epi_year) AND isset($epi_week))
		{
			$data['w_y_from'] = "{$epi_year}-".sprintf("%02d", $epi_week);
		}
		$rec_exist = $this->model->exist_facility_status($data['facode']);
		if(count($rec_exist) != 0)
		{
			//For Weekly Calculation
			if(isset($rec_exist[0]['w_y_from']) && isset($data['w_y_from']) && $rec_exist[0]['w_y_from'] === $data['w_y_from'])
			{
				$data['w_y_to'] = $data['w_y_from'];
			}
			else
			{
				if($epi_week == '1' AND $epi_year != '2016')
				{
					$data_array = $this->epi_week_year_filter('', FALSE);
					$year_index = array_search($epi_year, $data_array['year']);
					$epi_year   = $data_array['year'][$year_index-1];
					$epi_week   = end($data_array['weeks'][$epi_year]);
					$data['w_y_to'] = "{$epi_year}-".sprintf("%02d", $epi_week);
				}
				elseif(isset($data['w_y_from']) && $data['w_y_from'] !== '')
				{
					$epi_week = $epi_week - 1;
					$data['w_y_to'] = "{$epi_year}-".sprintf("%02d", $epi_week);
				}
			}
		}
		if($data['m_y_from'] != '')
		{
			$data['status'] = $status_vacc;
			$data['reason_vacc'] = $reason_vacc;
			$save_to_db = $this->model->fac_status_save($data, 'monthly');
			if($save_to_db)
			{
				syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
				syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
			}
		}
		if($data['w_y_from'] != '')
		{
			$data['status'] = $status_ds;
			$data['reason_ds'] = $reason_ds;
			$save_to_db = $this->model->fac_status_save($data, 'weekly');
			if($save_to_db)
				syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
		}
		if($save_to_db)
		{
			echo "<script> alert('Record Successfully Added!!');</script>";
		}
		else
		{
			echo "<script> alert('An Error occured in inserting record!');</script>";
		}
		redirect(base_url()."Status/View/{$data['facode']}");
	}

	function fac_status_delete()
	{
		$id = $this->uri->segment(3);
		$facode = $this->uri->segment(4);
		$module = $this->uri->segment(5);
		$result = $this->model->fac_status_delete($id, $facode, $module);
		if( ! $result)
		{
			echo "<script> alert('An Error occured by deleting this record!');</script>";
			redirect(base_url()."Status/View/$facode");
		}
		else
		{
			if($module=="vacc")
			{
				syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
				syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
			}else
			{
				syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
			}
			echo "<script> alert('Record Successfully deleted!');</script>";
			redirect(base_url()."Status/View/$facode");
		}
	}

	/*function status_filters($current_status)
	{
		$html = "";
		switch ($current_status) {
			case 'F':
				$html .= '<option value="N">Not Functional</option>
		            		<option value="C">Closed</option>';
				break;
			case 'N':
				$html .= '<option value="F">Functional</option>
		            		<option value="C">Closed</option>';
				break;
			case 'C':
				$html .= '<option value="F">Functional</option>
		            		<option value="N">Not Functional</option>';
				break;
			default:
				$html .= '<option value="F">Functional</option>
		            		<option value="N">Not Functional</option>
		            			<option value="C">Closed</option>';
				break;
		}
		return $html;
	}*/

	function epi_week_year_filter($epi_w_y, $return_json=TRUE, $status_data=NULL)
	{
		$data = array();
		$html_year = '<option value="">--SELECT YEAR--</option>';
		$html_week = '<option value="">--SELECT WEEK--</option>';
		if(isset($status_data) AND $epi_w_y === '')
		{
			$count = count($status_data);
			$first_row = $count;
			foreach($status_data as $data)
			{
				if($first_row === $count)
				{
					$epi_w_y = $data['w_y_from'];
					if( ! empty($epi_w_y))
					{
						$first_row = 0;
						$count = 1;
					}
				}
			}
		}
		if($epi_w_y != '')
		{
			$year_week = explode('-', $epi_w_y);
			$year = $year_week[0];
			$week = $year_week[1];
			$result=get_nextyearweek($year,$week,'next_fmonth');
            //print_r($result); exit;			
			$next_month=(explode("-",$result));   
			$year=$next_month[0];
			$week=$next_month[1];
			$weeks = $this->model->getWeeksOptions($year, $week);
		}
		else
		{
			$weeks = $this->model->getWeeksOptions();
		}
		$unique_year = array_unique(array_column($weeks, 'year'));
		foreach ($unique_year as $key => $value) 
		{
			$data['year'][] = $value;
			$html_year .= '<option value="'.$value.'">'.$value.'</option>';
		}
		foreach ($weeks as $key => $value)
		{
			$year_index = array_search($value['year'], $data['year']);
			$year_key = $data['year'][$year_index];
			if( ! isset($data['html_week_'.$year_key]))
			{
				$data['html_week_'.$year_key] = '<option value="">--SELECT WEEK--</option>';
			}
			$data['weeks']["$year_key"][] = $value['epi_week_numb'];
			$data['html_week_'.$year_key] .= '<option value="'.$value['epi_week_numb'].'">'.$value['epi_week_numb'].'</option>';
		}
		$data['html_year'] = $html_year;
		if($return_json === TRUE)
		{
			$data = json_encode($data);
		}
		return $data;
	}

}
?>