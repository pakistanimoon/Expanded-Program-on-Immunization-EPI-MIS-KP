<?php
class Ajax_hr_management extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');		
		$this -> load -> model('system_setup/hr_management/Ajax_hr_management_model','ajax_hr_model');
	}
	public function hr_list_filter(){
		//print_r($_POST); exit();
		$level = $this-> input-> get('level');
		$utype = $this-> input-> get('utype');
		$status = $this-> input-> get('status');
		$data = $this-> ajax_hr_model-> hr_list_filter($level,$utype,$status);
		echo $data;
	}
	public function hr_list_search(){
		if (($_SESSION['UserLevel']=='3') && $_SESSION['utype']=='DEO')
		{
			$wc = " post_procode = '" . $this-> session -> Province . "' AND post_distcode = '" . $this-> session -> District . "' ";
		}
		elseif(($_SESSION['UserLevel']=='4') && $_SESSION['utype']=='DEO')
		{
			$wc = " post_procode = '" . $this-> session -> Province . "' AND post_distcode = '" . $this-> session -> District . "' AND post_tcode = '" . $this-> session -> Tehsil . "' ";
		}
		elseif(($_SESSION['UserLevel']=='2') && $_SESSION['utype']=='Manager')
		{
			$wc = " post_procode = '" . $this-> session -> Province . "'";
		}
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
		$where = " where " ;
      	$multiple=" id > 0 ";
		if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{  
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if( ! empty($search_value))
      			{
					if($search_value=="Transferred" || $search_value=="Posted"){
						if (($_SESSION['UserLevel']=='3') && $_SESSION['utype']=='DEO')
						{
							$wc="";
							$wc = " pre_procode = '" . $this-> session -> Province . "' AND pre_distcode = '" . $this-> session -> District . "' ";
						}
						elseif(($_SESSION['UserLevel']=='4') && $_SESSION['utype']=='DEO')
						{
							$wc = " pre_procode = '" . $this-> session -> Province . "' AND pre_distcode = '" . $this-> session -> District . "' AND pre_tcode = '" . $this-> session -> Tehsil . "' ";
						}
						elseif(($_SESSION['UserLevel']=='2') && $_SESSION['utype']=='Manager')
						{
							$wc = " pre_procode = '" . $this-> session -> Province . "' ";
						}
							
							$multiple .= " AND " ; 
							$multiple .= "$column='$search_value'" ;
					}else{
						$multiple .= " AND " ; 
						$multiple .= "$column='$search_value'" ;
					}
      			}
      		}
      	}
      	if(isset($search))
      	{ 
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(name) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='3') || ($_SESSION['UserLevel']=='2') )
		{
			$columns_valid = array(
				"serial",
				"name",
				"pre_distcode",
				"post_distcode",
				"pre_level",
				"post_level",
				"pre_hr_sub_type_id",
				"post_hr_sub_type_id",
				"pre_facode",
				"post_facode",
				"pre_uncode",
				"post_uncode",
				"pre_tcode",
				"post_tcode",
				"phone",
				"nic",
				"pre_status",
				"post_status",
				"status_date",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by code,id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by code,id desc,".$columns_valid[$col].' '.$dir;
			
        }
		$query = "SELECT * from (select DISTINCT ON (code) code,id,name,pre_hr_sub_type_id,post_hr_sub_type_id,pre_level,post_level,nic,phone,pre_status,post_status,pre_procode,post_procode,pre_distcode,post_distcode,pre_tcode,post_tcode,pre_uncode,post_uncode,pre_facode,post_facode,status_date,is_deleted from hr_db_history where $search  $order) subquery $where $wc AND $multiple AND is_deleted='0' LIMIT {$length} OFFSET {$start}";   
		$operator = $this->db->query($query);
		$data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='2' || $_SESSION['UserLevel']=='3' || $_SESSION['UserLevel']=='4') && ($_SESSION['utype']=='DEO'))
			{
	       		$data[] = array(
	                "serial" => $i,
					"pre_distcode" => districtname("$r->pre_distcode"),
					"post_distcode" => districtname("$r->post_distcode"),
	                "name" => $r->name,
					"pre_level" => get_level_name("$r->pre_level"),
					"post_level" => get_level_name("$r->post_level"),
	                "pre_hr_sub_type_id" => get_subtype_name("$r->pre_hr_sub_type_id"),
	                "post_hr_sub_type_id" => get_subtype_name("$r->post_hr_sub_type_id"),
					"pre_facode" => get_Facility_Name("$r->pre_facode"),
	                "post_facode" => get_Facility_Name("$r->post_facode"),
	                "pre_uncode" => get_UC_Name("$r->pre_uncode"),
	                "post_uncode" => get_UC_Name("$r->post_uncode"),
					"pre_tcode" => get_Tehsil_Name("$r->pre_tcode"),
					"post_tcode" => get_Tehsil_Name("$r->post_tcode"),
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	                "pre_status" => $r->pre_status,
	                "post_status" => $r->post_status,
	                "status_date" => $r->status_date,
					"id" =>$r->id,
					"code" =>$r->code,
	            );
	     	}
	     	else
			{
	     		$data[] = array(
	                "serial" => $i,
					"pre_distcode" => districtname("$r->pre_distcode"),
					"post_distcode" => districtname("$r->post_distcode"),
	                "name" => $r->name,
					"pre_level" => get_level_name("$r->pre_level"),
					"post_level" => get_level_name("$r->post_level"),
	                "pre_hr_sub_type_id" => get_subtype_name("$r->pre_hr_sub_type_id"),
	                "post_hr_sub_type_id" => get_subtype_name("$r->post_hr_sub_type_id"),
					"pre_facode" => get_Facility_Name("$r->pre_facode"),
	                "post_facode" => get_Facility_Name("$r->post_facode"), 
	                "pre_uncode" => get_UC_Name("$r->pre_uncode"),
	                "post_uncode" => get_UC_Name("$r->post_uncode"),
					"pre_tcode" => get_Tehsil_Name("$r->pre_tcode"),
					"post_tcode" => get_Tehsil_Name("$r->post_tcode"),
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	                "pre_status" => $r->pre_status,
	                "post_status" => $r->post_status,
	                "status_date" => $r->status_date,
					"id" =>$r->id,
					"code" =>$r->code,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num from (select DISTINCT ON (code) code,id,name,pre_hr_sub_type_id,post_hr_sub_type_id,
		pre_level,post_level,nic,phone,pre_status,post_status,pre_procode,post_procode,pre_distcode,post_distcode,pre_tcode,post_tcode,pre_uncode,post_uncode,pre_facode,post_facode,status_date,is_deleted
		from hr_db_history where $search $order) subquery $where $wc AND $multiple AND is_deleted='0'";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function sub_type_options(){
		$type_val = $this-> input-> post('type_val');
		$data = $this-> ajax_hr_model-> sub_type_options($type_val);
		echo $data;
        exit();
	}
	public function gl_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(name) LIKE '$keyword%' OR 
      					lower(label) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"name",
				"label",
				"created_date",
				"created_by",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by created_date".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select id,name,label,created_date,created_by from lookup_master where $search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "name" => $r->name,
					"label" => $r->label,
	                "created_by" => $r->created_by,
	                "created_date" => $r->created_date,
					"id" =>$r->id,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM lookup_master WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function user_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(username) LIKE '$keyword%' OR 
      					lower(utype) LIKE '$keyword%' OR
						lower(fullname) LIKE '$keyword%' OR
						lower(level) LIKE '$keyword%' OR
						lower(distcode) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"username",
				"utype",
				"district",
				"fullname",
				"level",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by addeddate".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select username, utype, districtname(distcode) AS District, fullname, level FROM epiusers where $search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "username" => $r->username,
					"utype" => $r->utype,
	                "district" => $r->district,
	                "fullname" => $r->fullname,
	                "level" => $r->level,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM epiusers WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function menu_list_search()
	{
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
		$columns = $this->input->get("columns");
		//print_r($columns); exit();
		//echo json_encode($_GET);exit;
		$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
				//print_r($column); 
      			$column = str_replace('userlevel_description', 'level', $column);
      			$column = str_replace('usertype', 'type', $column);
				if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
		//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(b.menu_item) LIKE '$keyword%' OR 
      					lower(userlevel_description) LIKE '$keyword%' OR
						lower(usertype) LIKE '$keyword%') ";
			$search_ = "(lower(menu.menu_item) LIKE '$keyword%' OR 
						lower(userlevel_description) LIKE '$keyword%' OR
					  lower(usertype) LIKE '$keyword%') ";
      	}
      	else
      	{
			  $search = "";
			  $search_ = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

		$columns_valid = array(
			"serial",
			"id",
			"rol_id",
			"menu_item",
			"menu_url",
			"parent",
			"userlevel_description",
			"usertype",
		);
		
		if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by rol_id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
		}

		$query = "SELECT roles_menu.id as rol_id, menu.id, menu.menu_item, menu.menu_url, '#' as parent, user_level_db.userlevel_description, user_types_db.usertype
		FROM menu 
		INNER JOIN roles_menu ON roles_menu.menu_id=menu.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		WHERE menu.parent_id = '#' and $search_ $multiple_search
		
		UNION ALL
		
		SELECT roles_menu.id as rol_id, b.id, b.menu_item, b.menu_url, a.menu_item as parent, user_level_db.userlevel_description, user_types_db.usertype
		FROM menu a
		INNER JOIN menu b on b.parent_id = a.id::text
		INNER JOIN roles_menu ON roles_menu.menu_id=b.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		where $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";

        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
		$i=$start+1;
		//print_r($operator); exit();
        foreach($operator->result() as $r) 
        {
        	$data[] = array(
				"serial" => $i,
				"id" => $r->id,
				"rol_id" => $r->rol_id,
				"menu_item" => $r->menu_item,
				"menu_url" => $r->menu_url,
				"parent" => $r->parent,
				"userlevel_description" => $r->userlevel_description,
	            "usertype" => $r->usertype,
	        );
	     	$i++;
		}
		//print_r($data); exit();
		$query = "SELECT COUNT(*) AS num
		FROM menu a
		INNER JOIN menu b on b.parent_id = a.id::text
		INNER JOIN roles_menu ON roles_menu.menu_id=b.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		where $search $multiple_search ";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function item_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(item.description) LIKE '$keyword%' OR 
						lower(get_item_categories(item.item_category_id)) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"description",
				"number_of_doses",
				"item_category_id",
				"pk_id",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by item.pk_id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select item.pk_id,item.description,get_item_categories(item.item_category_id) as item_category_id,array_to_string(array_agg(size.number_of_doses order by size.number_of_doses),',') as number_of_doses from epi_items item join epi_item_pack_sizes size on item.pk_id=size.item_id where $search group by item.pk_id $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "description" => $r->description,
					"number_of_doses" => $r->number_of_doses,
					"item_category_id" => $r->item_category_id,
					"pk_id" => $r->pk_id,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num from epi_items item join epi_item_pack_sizes size on item.pk_id=size.item_id WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function role_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(role_name) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"role_name",
				"utype",
				"utype_description",
				"level",
				"id",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "SELECT id, (select usertype from user_types_db where id = user_roles.type) as utype, (select usertype_description from user_types_db where id = user_roles.type) as utype_description,level, active, role_name FROM user_roles where $search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "role_name" => $r->role_name,
					"utype" => $r->utype,
					"utype_description" => $r->utype_description,
	                "level" => get_UserLevel_Description("$r->level"),
	                "id" => $r->id,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM user_roles WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function suppliers_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(stakeholder_name) LIKE '$keyword%' OR 
						lower(get_stakeholder_type(stakeholder_type_id)) LIKE '$keyword%' OR 
						lower(get_stakeholder_sectors(stakeholder_sector_id)) LIKE '$keyword%' OR 
						lower(get_activity_name(stakeholder_activity_id)) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"stakeholder_name",
				"get_stakeholder_type",
				"get_stakeholder_sectors",
				"get_activity_name",
				"pk_id",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by pk_id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select pk_id,stakeholder_name,get_stakeholder_type(stakeholder_type_id),get_stakeholder_sectors(stakeholder_sector_id),get_activity_name(stakeholder_activity_id)  FROM epi_stakeholders where $search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "stakeholder_name" => $r->stakeholder_name,
					"get_stakeholder_type" => $r->get_stakeholder_type,
					"get_stakeholder_sectors" => $r->get_stakeholder_sectors,
					"get_activity_name" => $r->get_activity_name,
					"pk_id" => $r->pk_id,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num from epi_stakeholders WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function donors_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(name) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"name",
				"id",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select id,name  FROM epi_funding_source where $search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "name" => $r->name,
					"id" => $r->id,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num from epi_funding_source WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function stakeholder_activities_list_search(){
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = "(lower(activity) LIKE '$keyword%') ";
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin') )
		{
			$columns_valid = array(
				"serial",
				"activity",
				"pk_id",
			);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by pk_id".' '.$dir;// "order by ".$columns_valid[$col].' '.$dir;
        }
        else
		{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select *  FROM epi_stakeholder_activities where $search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
	    $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='99') && ($_SESSION['utype']=='Admin'))
			{
	       		$data[] = array(
	                "serial" => $i,
	                "activity" => $r->activity,
					"pk_id" => $r->pk_id,
	            );
	     	}
            $i++;
        }
		$query = "SELECT COUNT(*) AS num from epi_stakeholder_activities WHERE $search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
}
	