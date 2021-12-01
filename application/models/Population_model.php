<?php
class Population_model extends CI_model{

	public function getDistricts()
	{		
		$query=$this->db->query("select distcode,district,addeddate,
			(select population from districts_population where distcode=districts.distcode and year='".(string)(date("Y")-1)."') as previous,
			(select population from districts_population where distcode=districts.distcode and year='".(string)(date("Y"))."') as current,
			(select population from districts_population where distcode=districts.distcode and year='".(string)(date("Y")+1)."') as next
			 from districts where distcode='".$_SESSION['District']."' order by district");
		return $query->result();
	}

	public function getTehsil()
	{			
		$wc = getWC();
		$query=$this->db->query("select tcode,tehsil,
			(select population from tehsil_population where tcode=tehsil.tcode and year='".(string)(date("Y")-1)."') as previous,
			(select population from tehsil_population where tcode=tehsil.tcode and year='".(string)(date("Y"))."') as current,
			(select population from tehsil_population where tcode=tehsil.tcode and year='".(string)(date("Y")+1)."') as next
			 from tehsil where $wc order by tehsil");
		return $query->result();
	}

	public function getUC()
	{			
		$wc = getWC();
		$query=$this->db->query("select  uncode,un_name,tcode,
			(select distinct  population  from unioncouncil_population where uncode=unioncouncil.uncode and year='".(string)(date("Y")-1)."') as previous,
			(select distinct  population from unioncouncil_population where uncode=unioncouncil.uncode and year='".(string)(date("Y"))."') as current,
			(select distinct  population from unioncouncil_population where uncode=unioncouncil.uncode and year='".(string)(date("Y")+1)."') as next
			from unioncouncil where $wc order by un_name");
		return $query->result();
	}

	public function getFacilities()
	{		
		$wc = getWC();
		$query=$this->db->query("select facode,tcode,distcode,uncode,fac_name,
			(select population from facilities_population where facode=facilities.facode and year='".(string)(date("Y")-1)."') as previous,
			(select population from facilities_population where facode=facilities.facode and year='".(string)(date("Y"))."') as current,
			(select population from facilities_population where facode=facilities.facode and year='".(string)(date("Y")+1)."') as next
			 from facilities where hf_type='e' and $wc order by fac_name");
		return $query->result();
	}

	public function getVillages()
	{		
		$wc = getWC();
		$query=$this->db->query("select unname(uncode) as unname,vcode, tcode, distcode, unname(uncode) as unioncouncil, facode, uncode,village,added_date,
			(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y")-1)."') as previous,
			(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y"))."') as current,
			(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y")+1)."') as next
			 from villages where $wc order by uncode");		 
		return $query->result();
	} 

	public function setFacilities($data,$distcode)
	{
		$k = count($data['facode']);
		$this->db->delete('facilities_population',array(
			'year'=>date("Y"),
			'distcode' => $distcode
		));
		for ($i=0; $i<$k; $i++)
		{
			if ($data['current'][$i] != null)
			{
				$obj['facode']=$data['facode'][$i];
				$obj['uncode']=$data['uncode'][$i];
				$obj['tcode']=$data['tcode'][$i];
				$obj['distcode']=$data['distcode'][$i];
				$obj['year']=date("Y");
				$obj['population']=$data['current'][$i];
				$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
				$obj['update_date']=date("Y-m-d");
				$obj['update_by']=$_SESSION['username'];
				$this->db->insert('facilities_population',$obj);
			}
			if(isset($data['next']) && $data['next'][$i]!=null)
			{
				$obj['facode']=$data['facode'][$i];
				$obj['uncode']=$data['uncode'][$i];
				$obj['tcode']=$data['tcode'][$i];
				$obj['distcode']=$data['distcode'][$i];
				$obj['year']=(string)(date("Y")+1);
				$obj['population']=$data['next'][$i];
				$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
				$obj['update_date']=date("Y-m-d");
				$obj['update_by']=$_SESSION['username'];
				$this->db->delete('facilities_population',array(
					'facode'=> $data['facode'][$i],
					'year'=>(string)(date("Y")+1)
				));
				$this->db->insert('facilities_population',$obj);	
			}
		}
		if(isset($data['next']))
			$year = (string)(date("Y")+1);
		else
			$year = (string) (date("Y"));
		$this->db->delete('unioncouncil_population', array(
			'distcode'=> $distcode,
			'year'=>$year
		));
		$this->db->delete('tehsil_population', array(
			'distcode'=> $distcode,
			'year'=>$year
		));
		$this->db->delete('districts_population', array(
			'distcode'=> $distcode,
			'year'=>$year
		));
		$this->db->trans_begin();
		$unioncouncilQuery = "insert into unioncouncil_population(distcode,uncode,tcode,population,year) select distcode,uncode,tcode,sum(population::integer),year from facilities_population where uncode like '$distcode%' and year = '$year' group by distcode,tcode,uncode,year";
		$this->db->query($unioncouncilQuery);
		$unioncouncilUpdateQuery= "update unioncouncil_population set distcode='$distcode' where uncode like '$distcode%'";
		$this->db->query($unioncouncilUpdateQuery);
		$tehsilQuery = "insert into tehsil_population(distcode,tcode,population,year) select distcode,tcode,sum(population::integer),year from unioncouncil_population where tcode like '$distcode%' and year = '$year' group by distcode,tcode,year";
		$this->db->query($tehsilQuery);
		$tehsilUpdateQuery = "update tehsil_population set distcode='$distcode' where tcode like '$distcode%'";
		$this->db->query($tehsilUpdateQuery);
		$districtQuery = "insert into districts_population (distcode,population,year) select distcode,sum(population::integer),year from tehsil_population where distcode = '$distcode' and year = '$year' group by distcode,year";
		$this->db->query($districtQuery);
		sendPopulationUpdatesToFederalDashboard($year);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit(); 
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully');
	}
	public function setvillages($data,$distcode,$tcodes,$uncodes,$facode){
		//print_r($facode);exit;		
		$k = count($data['village']);
		$currentYear = (string) date("Y");
		$nextYear = (string) date("Y")+1;
		if($uncodes != '' AND $uncodes > 0){			
			/* $wc_previousYear= array(
				'year'=>(string) (date("Y")-1),
				'distcode' => $distcode,
				'uncode' => $uncodes,
			);  */ 
			$wc_currentYear= array(
				'year'=>(string) date("Y"),
				'distcode' => $distcode,
				'uncode' => $uncodes,
			);
			
			$wc_nextYear= array(
				'year'=>''. (string) date("Y")+1 .'',
				'distcode' => $distcode,
				'uncode' => $uncodes,
			);
		}
		//print_r($wc_nextYear);exit;
		///////////
		$this->db->trans_start();
		//$this -> db -> delete('villages_population',$wc_previousYear);
		$this -> db -> delete('villages_population',$wc_currentYear);
		if(isset($data['next']))
		{
			$this -> db -> delete('villages_population',$wc_nextYear);			
			/* 
			$yearCondition = " and year in ('{$currentYear}','{$nextYear}') ";
			$this -> db -> delete('villages_population',array(
				'year' => "$wc_nextYear",
				'distcode' => $uncodes */
			//));
		}
		for ($i=0; $i<$k; $i++)
		{	
			/* if ($data['previous'][$i] != null)
			{
				$obj['vcode']=$data['village'][$i];
				$obj['uncode']=$data['uncode'][$i];
				//$obj['tcode']=$data['tcode'][$i];
				$obj['distcode']=$data['distcode'][$i];
				$obj['year']=(string)(date("Y")-1);
				$obj['population']=$data['previous'][$i];
				$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
				$obj['update_date']=date("Y-m-d");
				$obj['update_by']=$_SESSION['username'];
				$this->db->insert('villages_population',$obj);
			} */
			if ($data['current'][$i] != null)
			{
				$obj['vcode']=$data['village'][$i];
				$obj['uncode']=$data['uncode'][$i];
				$obj['facode']=$data['facode'][$i];
				//$obj['tcode']=$data['tcode'][$i];
				$obj['distcode']=$data['distcode'][$i];
				$obj['year']=date("Y");
				$obj['population']=$data['current'][$i];
				$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
				$obj['update_date']=date("Y-m-d");
				$obj['update_by']=$_SESSION['username'];
				$this->db->insert('villages_population',$obj);
				
				$this -> db -> update('villages',array('facode'=>$obj['facode']),array('vcode'=>$obj['vcode']));
			}
			if(isset($data['next']) && $data['next'][$i]!=null)
			{
				$obj['vcode']=$data['village'][$i];
				$obj['uncode']=$data['uncode'][$i];
				$obj['facode']=$data['facode'][$i];
				$obj['tcode']=$data['tcode'][$i];
				$obj['distcode']=$data['distcode'][$i];
				$obj['year']=(string)(date("Y")+1);
				$obj['population']=$data['next'][$i];
				$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
				$obj['update_date']=date("Y-m-d");
				$obj['update_by']=$_SESSION['username'];
				/* $this->db->delete('villages_population',array(
					'vcode'=> $data['village'][$i],
					'year'=>(string)(date("Y")+1)
				)); */
				$this->db->insert('villages_population',$obj);	
			}
		}		
		$this->db->trans_complete();
		$this -> session -> set_flashdata('message','Record Saved Successfully');
	}

/* 	public function setDistricts($data)
	{
	 for ($i=0; $i<count($data['distcode']);$i++)
	 	{
	 		 if ($data['current'][$i]!=null)
	 		 {
		 		$obj['distcode']=$data['distcode'][$i];
		 		$obj['year']=date("Y");
		 		$obj['population']=$data['current'][$i];
		 		$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
		 		$obj['update_date']=date("Y-m-d");
		 		$obj['update_by']=$_SESSION['username'];
				
		 		$this->db->select('*');
		 		$this->db->from('districts_population');
				$this->db->where(array(
					'distcode'=> $data['distcode'][$i],
					'year'=>date("Y")
					));
				$record=$this->db->get()->result();
				if (empty($record))
				{
					$this->db->insert('districts_population',$obj);
				}
				else
				{
					$this->db->where(array(
					'distcode'=> $data['distcode'][$i],
					'year'=>date("Y")
					));
					$this->db->update('districts_population', $obj);
				}
				
			 }
			 if(isset($data['next']) && $data['next'][$i]!=null)
			 {
			 	$obj['distcode']=$data['distcode'][$i];
		 		$obj['year']=(string)(date("Y")+1);
		 		$obj['population']=$data['next'][$i];
		 		$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
		 		$obj['update_date']=date("Y-m-d");
		 		$obj['update_by']=$_SESSION['username'];
		 		$this->db->select('*');
		 		$this->db->from('districts_population');
				$this->db->where(array(
					'distcode'=> $data['distcode'][$i],
					'year'=>(string)(date("Y")+1)
					));
				$record=$this->db->get()->result();
				if (empty($record))
				{
					$this->db->insert('districts_population', $obj);
				}
				else
				{
					$this->db->where(array(
					'distcode'=> $data['distcode'][$i],
					'year'=>(string)(date("Y")+1)
					));
					$this->db->update('districts_population', $obj);
				}				
			 }
	 	}
	 }

	public function setTehsil($data)
		{
	 	for ($i=0; $i<count($data['tcode']);$i++)
	 	{
	 		 if ($data['current'][$i]!=null)
	 		 {
		 		$obj['tcode']=$data['tcode'][$i];
		 		$obj['year']=date("Y");
		 		$obj['population']=$data['current'][$i];
		 		$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
		 		$obj['update_date']=date("Y-m-d");
		 		$obj['update_by']=$_SESSION['username'];
				
		 		$this->db->select('*');
		 		$this->db->from('tehsil_population');
				$this->db->where(array(
					'tcode'=> $data['tcode'][$i],
					'year'=>date("Y")
					));
				$record=$this->db->get()->result();
				if (empty($record))
				{
					$this->db->insert('tehsil_population',$obj);
				}
				else
				{
					$this->db->where(array(
					'tcode'=> $data['tcode'][$i],
					'year'=>date("Y")
					));
					$this->db->update('tehsil_population', $obj);
				}
				
			 }
			 if(isset($data['next']) && $data['next'][$i]!=null)
			 {
			 	$obj['tcode']=$data['tcode'][$i];
		 		$obj['year']=(string)(date("Y")+1);
		 		$obj['population']=$data['next'][$i];
		 		$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
		 		$obj['update_date']=date("Y-m-d");
		 		$obj['update_by']=$_SESSION['username'];
		 		$this->db->select('*');
		 		$this->db->from('tehsil_population');
				$this->db->where(array(
					'tcode'=> $data['tcode'][$i],
					'year'=>(string)(date("Y")+1)
					));
				$record=$this->db->get()->result();
				if (empty($record))
				{
					$this->db->insert('tehsil_population', $obj);
				}
				else
				{
					$this->db->where(array(
					'tcode'=> $data['tcode'][$i],
					'year'=>(string)(date("Y")+1)
					));
					$this->db->update('tehsil_population', $obj);
				}				
			 }
	 		}

		}
	public function setUC($data,$distcode)
	{
		$k= count($data['uncode']);
		for ($i=0; $i<$k; $i++)
	 	{
	 		 if ($data['current'][$i]!=null)
	 		 {
		 		$obj['uncode']=$data['uncode'][$i];
		 		$obj['year']=date("Y");
		 		$obj['population']=$data['current'][$i];
		 		$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
		 		$obj['update_date']=date("Y-m-d");
		 		$obj['update_by']=$_SESSION['username'];
		 		
			    $this->db->select('*');
		 		$this->db->from('unioncouncil_population');
				$this->db->where(array(
					'uncode'=> $data['uncode'][$i],
					'year'=>date("Y")
					));
				$record=$this->db->get()->result();
				if (empty($record))
				{
					$this->db->insert('unioncouncil_population',$obj);
				}
				else
				{
					$this->db->where(array(
					'uncode'=> $data['uncode'][$i],
					'year'=>date("Y")
					));
					$this->db->update('unioncouncil_population', $obj);
				}
			}
			if(isset($data['next']) && $data['next'][$i]!=null)
			{
			 	$obj['uncode']=$data['uncode'][$i];
		 		$obj['year']=(string)(date("Y")+1);
		 		$obj['population']=$data['next'][$i];
		 		$obj['created_date']=isset($data['addeddate'][$i])?date("Y-m-d"):$data['addeddate'][$i];
		 		$obj['update_date']=date("Y-m-d");
		 		$obj['update_by']=$_SESSION['username'];
					
				$this->db->select('*');
		 		$this->db->from('unioncouncil_population');
				$this->db->where(array(
					'uncode'=> $data['uncode'][$i],
					'year'=>(string)(date("Y")+1)
					));
				$record=$this->db->get()->result();
				if (empty($record))
				{
					$this->db->insert('unioncouncil_population', $obj);
				}
				else
				{
					$this->db->where(array(
					'uncode'=> $data['uncode'][$i],
					'year'=>(string)(date("Y")+1)
					));
					$this->db->update('unioncouncil_population', $obj);
				}
			 }
	 	}		
			
		$this -> session -> set_flashdata('message','Record Saved Successfully!');
	} */
}
?>