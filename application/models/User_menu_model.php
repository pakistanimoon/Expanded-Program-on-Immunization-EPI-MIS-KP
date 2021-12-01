<?php
class User_menu_model extends CI_Model 
{
    public function __construct() 
    {
		parent:: __construct();
		$this->load->model('Common_model');
		$this->load->library('breadcrumbs');
		$this->load->model('Filter_model');
		$this->load->helper('my_functions_helper');
		$this->load->helper('epi_reports_helper');
		error_reporting(0);
    }

    public function menu() //done works_fine
    {
		//$procode = isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Menu Form', '/User_menu/menu');

		$query="SELECT userlevel, userlevel_description FROM user_level_db ORDER BY userlevel";
		$query=$this->db->query($query);
		$data['resultLevel']=$query->result_array();

		$query="SELECT id, usertype, usertype_description FROM user_types_db ORDER BY id";
		$query=$this->db->query($query);
		$data['resultTypes']=$query->result_array();

		if(isset($_REQUEST['menu'])){			
			$menu = $_REQUEST['menu'];
			$query = "SELECT * FROM menu WHERE id = '$menu' "; 
			$resource = $this->db->query($query);
			$data['menu'] = $resource->result_array();
		}
		return $data;
	}

	public function save_menu($data) //done works_fine
	{
		$this->db->insert('menu', $data);
	}

//code for tree structure 
	public function getMenu($menu_temp) //done works_fine
	{
		if ($menu_temp == 'main')
		{
			$query = $this->db->query("
			SELECT menu.id, menu.parent_id as parent, menu.menu_item \"text\"
			FROM menu where menu.template = '$menu_temp' ORDER BY menu.id");
		}
		else if ($menu_temp == 'dashboard')
		{
			$query = $this->db->query("
			SELECT menu.id, '#' as parent, menu.menu_item \"text\"
			FROM menu where menu.template = '$menu_temp' ORDER BY menu.id");
		}
	
		$data = $query->result_array();
		$result_json = json_encode($data, true);
		echo $result_json;
	}

	public function getUsers() //done works_fine
	{
		$query = $this->db->query("
		SELECT user_level_db.userlevel::text as id, coalesce('#','0')::text as parent, user_level_db.userlevel_description as \"text\" 
		FROM user_level_db
		UNION ALL
		SELECT user_level_db.userlevel||'-'||user_types_db.id , user_level_db.userlevel::text as parent, user_types_db.usertype \"text\"
		FROM user_types_db
		INNER JOIN user_roles ON user_roles.type = user_types_db.id 
		INNER JOIN user_level_db ON user_roles.level = user_level_db.userlevel
		ORDER BY id
		");
	
		$data = $query->result_array();
		$result_json = json_encode($data, true);
		echo $result_json;
	}

	public function getID($utypeArray, $levelArray) //done works_fine
	{
		$wc = array();
		$q = $this->db->query("SELECT * FROM user_roles");
		$data_ = $q->result_array();

		for ($i=0; $i < count($utypeArray); $i++)
		{
			$utype = $utypeArray[$i];
			$level = $levelArray[$i];

			for($j=0; $j <= count($data_); $j++)
			{
				$temp[$j] = $data_[$j]['level'].'-'.$data_[$j]['type'];
				if($temp[$j] == $utypeArray[$i])
				{
					$utype_value = $data_[$j]['type'];
					$level_value = $data_[$j]['level'];

					$query = "SELECT user_roles.id FROM user_roles 
					INNER JOIN user_level_db ON user_level_db.userlevel = user_roles.level
					INNER JOIN user_types_db ON user_types_db.id = user_roles.type
					WHERE user_roles.level = '$level_value' AND user_roles.type = '$utype_value'";

					$result = $this->db->query($query);
					$data[] = $result->result_array();
				}
			}	
		}
		return $data;
	}

	public function getMenuID() //done works_fine
	{
		$query = $this->db->query("SELECT MAX(id) FROM menu");
		$data = $query->result_array();
		return $data;
	}

	public function saveRolesMenu($status) //done works_fine
	{
		for($i=0; $i<count($status['role_id']); $i++)
		{
			$role = $status['role_id'][$i];
			$menu = $status['menu_id'];
			$active = $status['active'];
			$q = $this->db->query("
			INSERT INTO roles_menu (role_id, menu_id, active)
			VALUES ('$role', '$menu', '$active')			
			");	
		}
	}
	
	public function menu_list($per_page, $startpoint) //done works_fine
	{
		$this->breadcrumbs->push('Home', '/');
		$this->breadcrumbs->push('Manage EPI-MIS Menu', '/User_menu/menu_list');
		
		$wc = getWC();
		$query="SELECT userlevel, userlevel_description FROM user_level_db ORDER BY userlevel";
		$query=$this->db->query($query);
		$data['resultLevel']=$query->result_array();
		
		$query="SELECT id, usertype, usertype_description FROM user_types_db ORDER BY id";
		$query=$this->db->query($query);
		$data['resultTypes']=$query->result_array();

		$query="SELECT roles_menu.id as rol_id, menu.id, menu.menu_item, menu.menu_url, '#' as parent, user_level_db.userlevel_description, user_types_db.usertype
		FROM menu 
		INNER JOIN roles_menu ON roles_menu.menu_id=menu.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		WHERE menu.parent_id = '#'
		
		UNION ALL
		
		SELECT roles_menu.id as rol_id, b.id, b.menu_item, b.menu_url, a.menu_item as parent, user_level_db.userlevel_description, user_types_db.usertype
		FROM menu a
		INNER JOIN menu b on b.parent_id = a.id::text
		INNER JOIN roles_menu ON roles_menu.menu_id=b.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		order by rol_id LIMIT {$per_page} OFFSET {$startpoint}	
		";
		$menu_data = $this->db->query($query);
		$data['menu_data'] = $menu_data->result_array();
		//print_r($data['menu_data']); exit();

		return $data;
	}

	public function delete_by_id($id) //work_in_progress
	{
		$this->db->where('menu_id', $id);
		$this->db->delete('roles_menu');
			
		$this->db->where('id', $id);
		$this->db->delete('menu');
	}

	public function delete_by_role($id, $role) //work_in_progress
	{
		$tmp = $this->db->query("select count(menu_id) from roles_menu where menu_id = '$id'");
		$a = $tmp->result_array();
		$val = $a[0]['count'];
		if ($val > 1)
		{
			$this->db->where('id', $role);
			$this->db->delete('roles_menu');
		}
		else if($val == 1)
		{
			$this->db->where('id', $role);
			$this->db->delete('roles_menu');
			
			$this->db->where('id', $id);
			$this->db->delete('menu');
		}	
	}

	public function edit_menu($menu, $menu_temp) //done works_fine
	{
		if ($menu_temp == 'main')
		{
			$query = "
			SELECT menu.id, menu.parent_id as parent, menu.menu_item \"text\",
			CASE WHEN (
			SELECT menu_id as id from roles_menu rol where menu.id='$menu' and rol.menu_id=menu.id  LIMIT 1):: integer > 0
			THEN 'selectedtrue' ELSE 'selectedfalse' END as 
			state FROM menu where menu.template = '$menu_temp'  ORDER BY menu.id
			";
		}
		else if ($menu_temp == 'dashboard')
		{
			$query = "
			SELECT menu.id, '#' as parent, menu.menu_item \"text\",
			CASE WHEN (
			SELECT menu_id as id from roles_menu rol where menu.id='$menu' and rol.menu_id=menu.id  LIMIT 1):: integer > 0
			THEN 'selectedtrue' ELSE 'selectedfalse' END as 
			state FROM menu where menu.template = '$menu_temp'  ORDER BY menu.id
			";
		}

		$result = $this->db->query($query);
		$newArr = $result = $result-> result_array();
		$trueobj = array("selected"=>true);
		$falseobj = array("selected"=>false);

		array_walk($result, function ($item, $key) use (&$newArr,$trueobj,$falseobj) {			
			$newArr[$key]["state"] = ($item["state"] === "selectedtrue") ? $trueobj : $falseobj;
		});

		echo json_encode($newArr);
	}

	public function editUsers($menu) //done_works_fine
	{	
		$query = "
		SELECT user_level_db.userlevel::text as id, coalesce('#','0')::text as parent, user_level_db.userlevel_description as \"text\",
		CASE WHEN (SELECT role_id FROM roles_menu role join user_roles ON role.role_id = user_roles.id WHERE  menu_id='$menu' 
		AND user_roles.level = user_level_db.userlevel LIMIT 1)::integer < 0 THEN 'selectedtrue' ELSE 'selectedfalse' END as state
		FROM user_level_db
		
		UNION ALL
		
		SELECT user_level_db.userlevel||'-'||user_types_db.id , user_level_db.userlevel::text as parent, user_types_db.usertype \"text\",
		CASE WHEN (SELECT role_id FROM roles_menu role join user_roles ON role.role_id = user_roles.id WHERE  menu_id='$menu'
		AND user_roles.type= user_types_db.id AND user_roles.level= user_level_db.userlevel LIMIT 1)::integer > 0 THEN 'selectedtrue' ELSE 'selectedfalse' END as state
		FROM user_types_db
		INNER JOIN user_roles ON user_roles.type = user_types_db.id
		INNER JOIN user_level_db ON user_roles.level = user_level_db.userlevel
		";
		
		$result = $this->db->query($query);
		$newArr = $result = $result-> result_array();
		$trueobj = array("selected"=>true);
		$falseobj = array("selected"=>false);

		array_walk($result, function ($item, $key) use (&$newArr,$trueobj,$falseobj) {			
			$newArr[$key]["state"] = ($item["state"] === "selectedtrue") ? $trueobj : $falseobj;
		});

		echo json_encode($newArr);
	}

	function pagination($query,$per_page=100,$page=1,$url='?',$GroupId = NULL)
	{ 
		$query = "select count(*) as num  FROM {$query} ";
	    $rs=$this->db->query($query);
	    $row=$rs->row_array();
	    $total = $row['num'];
	    $adjacents = "2"; 
	    $prevlabel = "&lsaquo; Prev";
	    $nextlabel = "Next &rsaquo;";
	    $lastlabel = "Last &rsaquo;&rsaquo;";
	    $page = ($page == 0 ? 1 : $page);
	    $start = ($page - 1) * $per_page;
	    $prev = $page - 1;
	    $next = $page + 1;
	    $lastpage = ceil($total/$per_page);
	    //$lastpageid = $lastpage + 1;
	    $lpm1 = $lastpage - 1; // //last page minus 1
	    $pagination = "";
		if($lastpage > 1)
		{
        	$pagination .= '<div class="row"><div align="center" class="col-sm-12"><ul class="pagination">';
        	//$pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
            if ($page > 1) $pagination.= "<li><a id='$prev' class='paginateMe' href='{$url}page={$prev}'>{$prevlabel}</a></li>";
		if ($lastpage < 7 + ($adjacents * 2))
		{   
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
                if ($counter == $page)
                    $pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
                else
                    $pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
            }
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a  id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a id='$lpm1' class='paginateMe'  href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a id='$lastpage' class='paginateMe'  href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
                $pagination.= "<li><a id='1' class='paginateMe'  href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a  id='2' class='paginateMe'  href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
                    else
                        $pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a id='$lpm1' class='paginateMe'  href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a id='$lastpage' class='paginateMe'  href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
			}
			else
			{
                $pagination.= "<li><a id='1' class='paginateMe'  href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a id='2' class='paginatemM'  href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a>{$counter} <span class=\"sr-only\">(current)</span></a></li>";
                    else
                        $pagination.= "<li><a id='$counter' class='paginateMe'  href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
			if ($page < $counter - 1)
			{
				$pagination.= "<li><a id='$next' class='paginateMe'  href='{$url}page={$next}'>{$nextlabel}</a></li>";
				$pagination.= "<li><a id='$lastpage' class='paginateMe'  href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
			}
			$pagination.= "</ul></div></div>";        
    	}
    	return $pagination;
	}
}
?>