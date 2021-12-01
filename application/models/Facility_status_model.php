<?php 
class Facility_status_model extends CI_Model{

	protected $_current_date;
	protected $_current_year;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
		$this->_current_date = date('Y-m-d');
		$this->_current_year = date('Y');
	}

	function fac_status_view($facode, $is_for_view=FALSE)
	{
		$query = "SELECT * FROM facilities_status WHERE facode='$facode' order by substr(id,8,3)::numeric desc";
		$result['status_data'] = $this->db->query($query)->result_array();
		if($is_for_view)
		{
			$query = "SELECT fmonth FROM fac_mvrf_db WHERE facode='$facode' ORDER BY id DESC LIMIT 1";
			$result_var = $this->db->query($query)->result_array();
			$result['last_fmonth'] = (!empty($result_var))?json_encode($result_var):json_encode(array(0=>array('fmonth'=>'2016-01')));
			$query = "SELECT fweek FROM zero_report WHERE facode='$facode' ORDER BY id DESC LIMIT 1";
			$result_var = $this->db->query($query)->result_array();
			$result['last_fweek'] = (!empty($result_var))?json_encode($result_var):json_encode(array(0=>array('fweek'=>'2016-01')));
		}
		return $result;
	}

	function exist_facility_status($facode)
	{
		$query = "SELECT * 
					FROM facilities_status 
					WHERE facode='$facode' 
					ORDER BY id DESC 
					LIMIT 1";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function fac_status_save($data=NULL, $type=NULL)
	{
		$facode = $data['facode'];
		$status_data = $this->fac_status_view($facode);
		$count = count($status_data['status_data']);
		//For checking if a record exists for a facode
		if(count($this->exist_facility_status($facode)) == 0)
		{
			//print_r($data);echo "in 40";exit;
			if($data['status'] == 'F')
			{
				$result = $this->insert_facility_status($data, $facode);
				return $result;
			}
			else
			{
				$this->session->set_flashdata('message', 'First Status Must be Functional');
			}
		}
		//For Updatting and Inserting Record in table
		else
		{
			if($type == 'monthly')
			{
				unset($data['w_y_from']);
				unset($data['w_y_to']);
				$from = 'm_y_from';
				$to = 'm_y_to';
			}
			elseif($type == 'weekly')
			{
				$to_data = $data['w_y_to'];
				unset($data['m_y_from']);
				unset($data['w_y_to']);
				$from = 'w_y_from';
				$to = 'w_y_to';
			}
			$cnt = 0;
			foreach ($status_data['status_data'] as $key => $value) 
			{
				if($value[$from] != '')
				{
					$cnt++;
				}
			}
			if($cnt == 0 AND $data['status'] != 'F')
			{
				return FALSE;
			}
			//print_r($data);exit;
			if($count > 0)
			{
				foreach ($status_data['status_data'] as $key => $value) 
				{
					if(isset($data[$from]))
					{
						if($value['status'] === $data['status'])
						{
							if($value[$from] == '')
							{
								$month_id_from = $value['id'];
								if( ! ($key+1 == $count))
								{
									$month_id_to = $status_data['status_data'][$key+1]['id'];
								}
							}
							else
							{
								$month_id_from = NULL;
								break;
							}
						}
						elseif($value[$from] != '')
						{
							
							if(isset($month_id_from))
							{
								//echo $month_id_from."dsfsf";echo $month_id_to;print_r($data);exit;
								$res1 = $this->update_facility_status($data, $month_id_from);
							}
							else
							{
								//echo $month_id_from."ggggg";echo $month_id_to;print_r($data);exit;
								//print_r($data);echo "in 98";exit;
								$result = $this->insert_facility_status($data, $facode);
								$month_id_to = $status_data['status_data'][$key]['id'];
							}
							if($type == 'monthly')
							{
								$data[$to] = date('Y-m', strtotime($data[$from].' first day of previous month'));
							}
							elseif($type == 'weekly')
							{	
								$data[$to] = $to_data;
							}
							unset($data[$from]);
							unset($data['status']);
							$res1 = $this->update_facility_status($data, $month_id_to);
							return $res1;
						}
					}
				}
			}
			else
			{
				if($data['status'] == 'F')
				{
					$result = $this->insert_facility_status($data, $facode);
					return $result;
				}
				else
				{
					$this->session->set_flashdata('message', 'First Status Must be Functional');
				}
			}
			if(isset($month_id_from))
			{
				unset($data['status']);
				$res1 = $this->update_facility_status($data, $month_id_from);
				return $res1;
			}
		}
	}

	function fac_status_delete($id, $facode, $module)
	{
		$query = "SELECT m_y_from, w_y_from FROM facilities_status WHERE id='$id'";
		$one_result = $this->db->query($query)->result_array();
		//print_r($all_data);exit;
		if($one_result[0]['m_y_from'] == '' AND $one_result[0]['w_y_from'] == '')
		{
			$query = "DELETE FROM facilities_status WHERE id='$id'";
			$result = $this->db->query($query);
		}
		elseif($module == 'vacc')
		{
			$to = 'm_y_to';
			if($one_result[0]['w_y_from'] == '')
			{
				$query = "DELETE FROM facilities_status WHERE id='$id'";
				$result = $this->db->query($query);
			}
			else
			{
				$query = "UPDATE facilities_status 
					SET m_y_from=NULL, 
					m_y_to='', 
					updated_date='{$this->_current_date}' 
					WHERE id='$id'";
				$result = $this->db->query($query);
			}
			$all_data = $this->fac_status_view($facode);
			foreach ($all_data['status_data'] as $key => $value) 
			{
				if($value['m_y_from'] != '')
				{
					$id = $value['id'];
					break;
				}
			}
		}
		elseif($module == 'ds')
		{
			$to = 'w_y_to';
			if($one_result[0]['m_y_from'] == '')
			{
				$query = "DELETE FROM facilities_status WHERE id='$id'";
				$result = $this->db->query($query);
			}
			else
			{
				$query = "UPDATE facilities_status 
					SET w_y_from=NULL, 
					w_y_to='', 
					updated_date='{$this->_current_date}' 
					WHERE id='$id'";
				$result = $this->db->query($query);
			}
			$all_data = $this->fac_status_view($facode);
			foreach ($all_data['status_data'] as $key => $value) 
			{
				if($value['w_y_from'] != '')
				{
					$id = $value['id'];
					break;
				}
			}
		}
		$query = "UPDATE facilities_status 
					SET $to='',  
					updated_date='{$this->_current_date}' 
					WHERE facode='$facode' 
					AND id='$id'";
		$result2 = $this->db->query($query);
		$result3 = $this->update_facilities(NULL, $facode, TRUE);
		return ($result3);
	}

	function update_facilities($status=NULL, $facode=NULL, $is_from_delete=FALSE)
	{
		//update facilities current status
		if($is_from_delete !== FALSE)
		{
			$query = "SELECT status FROM facilities_status WHERE facode='$facode' ORDER BY id DESC LIMIT 1";
			$result = $this->db->query($query)->row();
			$status = $result->status;
		}
		$status_data = $this->fac_status_view($facode);
		//echo "<pre>";print_r($status_data);exit;
		foreach ($status_data['status_data'] as $key => $value) 
		{
			if($value['m_y_from'] != '' AND $value['w_y_from'] != '')
			{
				$status = $value['status'];
				break;
			}
		}
		$query = "UPDATE facilities 
					SET func_status='{$status}', 
					updateddate='{$this->_current_date}' 
					WHERE facode='$facode'";
		$result = $this->db->query($query);
		return $result;
	}

	/**
	 * Create Weeks Option for week Filter
	 *
	 * @access	public
	 * @return	weeks
	 */	
	function getWeeksOptions($year=FALSE, $week=FALSE)
	{
		$wc = array();
		if($year !== FALSE)
		{
			$wc['year >='] = $year;
		}
		if($week !== FALSE)
		{
			$this->db->select('date_from');
			$this->db->from('epi_weeks');
			$this->db->where(array('epi_week_numb' => $week, 'year' => $year));
			$result = $this->db->get()->row();
			$wc['date_from >='] = $result->date_from;
		}
		$wc['year <=']      = $this->_current_year;
		$wc['date_from <='] = $this->_current_date;
		$this->db->select('epi_week_numb, year');
		$this->db->from('epi_weeks');
		$this->db->where($wc);
		$this->db->group_by('year, epi_week_numb');
		$this->db->order_by('year, epi_week_numb asc');
		$result = $this->db->get()->result_array();
		return $result;
	}

	function update_facility_status($data, $id)
	{
		if(substr($id, -1) == '1')
		{
			unset($data['reason_ds']);
			unset($data['reason_vacc']);
		}
		$data['updated_date'] = $this->_current_date;
		foreach ($data as $key => $value) 
		{
			if($value == '')
			{
				$value = NULL;
			}
		}
		$this->db->where('id', $id);
		$result = $this->db->update('facilities_status', $data);
		$result2 = $this->update_facilities($data['status'], $data['facode'], TRUE);
		return ($result AND $result2);
	}

	function insert_facility_status($data, $facode)
	{
		$data['added_date'] = $this->_current_date;
		foreach ($data as $key => $value) 
		{
			if($value == '')
			{
				$value = NULL;
			}
		}
		$query="SELECT id AS statusid FROM facilities_status WHERE facode= '$facode' ORDER BY id DESC LIMIT 1 ";
		$result = $this->db->query($query)->row();
		$id = explode("-",$result->statusid);
		$data['id'] = "{$facode}-".($id[1]+1);
		//inserting new record
		$result = $this->db->insert('facilities_status', $data);
		$result2 = $this->update_facilities($data['status'], $data['facode'], TRUE);
		return ($result AND $result2);
	}

}
?>