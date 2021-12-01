<?php 
function createMoonMenu(){
	$menuarr = fetchmenuitemsfromdb();
	$menuhtml = '
		
		<aside class="main-sidebar">
			<section class="sidebar">
				';
	$menuhtml .= fetchMenuItems($menuarr);		
	$menuhtml .='
			</section>
			<!-- /.sidebar -->
		</aside>
	';
	echo $menuhtml;
}
function fetchMenuItems($menuarr,$key=NULL){
	foreach($menuarr as $url){
		if($url=='#'){
			foreach($menuarr as $singlearr){
				$id = isset($singlearr["id"])?$singlearr["id"]:"";
				$key1 = isset($singlearr["name"])?$singlearr["name"]:"";
				$url = isset($singlearr["url"])?$singlearr["url"]:"";
				$icon = isset($singlearr["icon"])?$singlearr["icon"]:"";
				$innerarr = fetchmenuitemsfromdb($id);
				$allitems .= '<li class="parent-uk '.(is_array($innerarr)?'treeview':'').'">
					<a '.(is_array($innerarr)?'':'class="anchor-uk"').' href="'.(is_array($innerarr)?base_url($url):'#').'"> '.(is_array($innerarr)?$icon:'').' '.(is_array($innerarr)?$key1:'<span>'.$key1.'</span>').' '.(($singlearr["url"]=='#')?'<i class="fa fa-angle-left pull-right"></i>':'').'</a>';
					if(is_array($innerarr)){ 
						$allitems .= fetchMenuItems($innerarr,$key1);
					}
				$allitems .= '</li>';
			}
			return $allitems; 
		}else{
			$allitems = '<ul class="'.($key===NULL?'sidebar-menu':'treeview-menu').'">';
			foreach($menuarr as $singlearr){
				$id = isset($singlearr["id"])?$singlearr["id"]:"";
				$key1 = isset($singlearr["name"])?$singlearr["name"]:"";
				$url = isset($singlearr["url"])?$singlearr["url"]:"";
				$icon = isset($singlearr["icon"])?$singlearr["icon"]:"";
				$innerarr = fetchmenuitemsfromdb($id);
				$allitems .= '<li class="parent-uk '.(is_array($innerarr)?'treeview':'').'">';
				 if($id==149 || $id==9){
					$allitems .= '<a '.(is_array($innerarr)?'class="anchor-uk"':'').' target="_blank" href="'.(is_array($innerarr)?base_url($url):'#').'"> '.(is_array($innerarr)?$icon:'').' '.(is_array($innerarr)?'<span>'.$key1.'</span>':$key1).' '.(($singlearr["url"]=='#')?'<i class="fa fa-angle-left pull-right"></i>':'').'</a>'; 
				 }else{
					$allitems .= '<a '.(is_array($innerarr)?'class="anchor-uk"':'').' href="'.(is_array($innerarr)?base_url($url):'#').'"> '.(is_array($innerarr)?$icon:'').' '.(is_array($innerarr)?'<span>'.$key1.'</span>':$key1).' '.(($singlearr["url"]=='#')?'<i class="fa fa-angle-left pull-right"></i>':'').'</a>';
				 }
					if(is_array($innerarr)){ 
						$allitems .= fetchMenuItems($innerarr,$key1);
					}
				$allitems .= '</li>';
			}
			$allitems .= '</ul>';
			return $allitems; 
		}
	}
}
function fetchmenuitemsfromdb($parentid = NULL){
	$CI =& get_instance();
	$utype	= $CI -> session -> utype;
	$ulevel = $CI -> session -> UserLevel;
	$whrpostfix = "";
	if($parentid){
		$whrpostfix = " and menu.parent_id='$parentid'";
	}else{
		$whrpostfix = " and menu.parent_id ='#'";
	}
	$query="select menu.id,menu.menu_item as name,menu.menu_url as url,menu.icon,menu.parent_id from roles_menu join menu on roles_menu.menu_id=menu.id 
		join user_roles on roles_menu.role_id=user_roles.id join user_types_db on user_roles.type=user_types_db.id 
		where user_types_db.usertype='$utype' and user_roles.level='$ulevel' and template='main' and roles_menu.active='1' $whrpostfix ORDER BY menu.id";
	$result = $CI -> db -> query($query);	
	return $result-> result_array();
}

?>
