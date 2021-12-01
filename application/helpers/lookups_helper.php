<?php
/*
@ Author:        		Usama Hadi
@ Email:         		usama.hadi@pace-tech.com
@ Function:      		general_config
@ Description:   		Returns html of options depending upon data in parameter(array)
@ Required Parameters:	table_name, value_col(id), label_col(name), active(1 or 0), select_only in data db_param(array)
						selected(value), createoption(true or false), return_result(true or false) in data outlook(array)
*/

if(!function_exists('general_config'))
{
	function general_config($db_param,$outlook=array())
	{
		$option ='';
		if(isset($db_param) && isset($db_param['table_name']))
		{
			extract($db_param); extract($outlook); 
			$value_col = (isset($value_col)) ? $value_col : 'id' ;
			$label_col = (isset($label_col)) ? $label_col : 'name' ;
			$createoption = (isset($createoption)) ? $createoption : TRUE ;
			$return_result = (isset($return_result)) ? $return_result : TRUE ;
			$CI = & get_instance();
			$CI -> db -> select('*');
			$CI -> db -> from($table_name);
			if(isset($select_only)){
				$CI -> db -> where($value_col,$select_only);
			}
			if(isset($active)){
				$CI -> db -> where('is_active',$active);
			}
			$CI -> db -> order_by($value_col, 'ASC');
			$result = $CI -> db -> get() -> result_array();
			////placement of loop is wrong should b change discuss with moon
			if(isset($createoption))
			{			
				foreach($result as $key => $value)
					{
						$select='';
						if(isset($selected) && $selected==$value[$value_col])//discus this === with moon
						{
							$select = 'selected="selected"';
						}
						$option .= '<option value="' . $value[$value_col] . '"'.$select.'>' . $value[$label_col] .'</option>';
					}	
			}
			else
			{
				$option = $result;
			}
			if($return_result != TRUE)
			{
				return $option;
			}else{
				echo $option;
			}
		}
		else
		{
			echo "please Enter table name";
		}
	}
}
/*
@ Author:        			Usama Hadi
@ Email:         			usama.hadi@pace-tech.com
@ Moderator/Architecture	Imran Qamer (rajaimranqamer@gmail.com)
@ Function:      			general_lookups
@ Description:   			Returns html of Dropbox or dropbox depending upon data in parameters.
@ Required Parameters:		lookup_name(dropdown name), active(1, 0) in data lookup_name(array)
							create(option or dropdown), selected(value), select_only(value),return_result(true or false) in data outlook(array),id_att,name_att,dataid_att,class_att
							prototype general_lookups(array("lookup_name"=>"marital_status"),array("create"=>"dropdown"));
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
Protoype:

array("lookup_name"=>"status","active"=>"1"),array("create"=>"dropdown","selected"=>"Retired","return_result"=>FALSE,"custom_attr"=>array("id"=>"year1","name"=>"year","class"=>"dp year form-control"),"data_attr"=>array("id"=>"pk_id","name"=>"code","moon"=>"anyColumFromDb"))

Field									Description
--------------------------------------------------------------------------------------------------------------------------------
First ParameterI(array)
-----------------------
lookup_name								Unique Name of the lookup required for option or dropdown From the table(lookup_master).
(String)


activity								Activity Status of the lookup option. By default set to 1(active).
(integer)
(1,0)
(optional)

Second Parameter(array)
-----------------------
create									Create Will return html of options or dropdown depends upon requirement. options will
(string)								will return option for dropbox. dropdown will return the html of dropdown.
(options or dropdown)
(optional)

selected								Select the option(value) in dropdown.
(string)
(optional)

select_only								Select the only given option(value) in dropdown.
(string)
(optional)

return_result							Return the result if TRUE is passed. By default set to FALSE.
(bool)

custom_attr								custom_attr will set the attributes to dropbox(select).
(array)
(optional)

data_attr								data_attr will set the attributes to <option> and will set the values from database table lookup_detail
(array)									and lookup_master
(optional)										
	 	 				
*/
if(!function_exists('general_lookups'))
{
	function general_lookups($lookup_name,$outlook=array())
	{
		$option =''; $create_option ='';
		if(isset($lookup_name))
		{
			//print_r($lookup_name); exit;
			extract($lookup_name); extract($outlook);
			$active = (isset($active)) ? $active : '1' ;
			$return_result = (isset($return_result)) ? $return_result : FALSE;
			//echo $select_att; exit;
			$CI = & get_instance();
			$CI -> db -> select('d.pk_id, m.name, m.label,  d.value, d.caption, d.master_id, d.created_date, d.created_by, d.is_active');
			$CI -> db -> from('lookup_master as m');
			$CI -> db ->join("lookup_detail as d","m.id = d.master_id");
			$CI -> db ->where('m.name',$lookup_name);
			$CI -> db -> where('is_active',$active);
			if(isset($select_only)){
				$CI -> db -> where('d.value',$select_only);
			}
			$result = $CI -> db -> get() -> result_array();
			if(isset($create))
			{
				foreach($result as $key => $value)
				{		
					$select='';
					if(isset($selected) && $selected==$value['value'])
					{
						$select = 'selected="selected"';
					}
					$data_custom= '';
					if(isset($data_attr)){
						foreach($data_attr as $key => $data_val)
						{
							$data_custom .= 'data-'.$key.' = "'.$value[$data_val] .'" ';
						}
					}
					$option .= '<option '.$data_custom.' value="'.$value['value'].'"'.$select.'>' . $value['caption'] .'</option>';
				}
				if($create == "dropdown")
				{
					$custom = '';
					if(isset($custom_attr)){
						if(isset($custom_attr["name"])){
							$custom .= 'name= "'.$custom_attr["name"].'" ';
							unset($custom_attr["name"]);
						}else{
							$custom .= 'name= "'.$lookup_name.'" ';
						}
						if(isset($custom_attr["class"])){
							$custom .= 'class= "'.$custom_attr["class"].'" ';
							unset($custom_attr["class"]);
						}else{
							$custom .= 'class="form-control" ';
						}
						foreach($custom_attr as $key => $attr)
						{
							$custom .= $key.' = "'.$attr .'" ';
						}
					}else{
						$custom .= 'name = "'.$lookup_name.'" class="form-control" ';
					}
					$create_option .= '<select '.$custom.'>';
					$create_option .= $option;
					$create_option .='</select>';
				}
				else
				{
					$create_option .= $option;
				}
			}
			else
			{
				$create_option = $result;
			}
			if($return_result == FALSE)
			{
				echo $create_option;
			}else{
				return $create_option;
			}
		}else{
			echo "Please Enter Valid Lookup Name!";
		}
	}
}
