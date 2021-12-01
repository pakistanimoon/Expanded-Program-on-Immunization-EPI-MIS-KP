<?php
class User_menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('epi_functions_helper');
    authentication();
    $this->load->model('User_menu_model');
    $this->load->model('Common_model');
  }

  public function menu($data=NULL) //done works_fine
  {
    $data = $this->User_menu_model->menu($data);
    if ($data != 0)
    {        
      $data['data'] = $data;
      $data['fileToLoad'] = 'user_menu/add_menu';
      $data['pageTitle'] = 'EPI-MIS | Create Menu';
      $this->load->view('template/epi_template', $data);
    }
    else
    {
      $data['message'] = "You must have rights to access this page.";
      $this->load->view("message", $data);
    }
  }

  public function menu_list() //done works_fine
  {
    $page = (int)(!($this->input->get('page')) ? 1 : $this->input->get('page'));
    if ($page <= 0)
    {
      $page = 1;
    }
    $per_page = 30;
    $startpoint = ($page * $per_page) - $per_page;
    $statement = "roles_menu";
    $data = $this->User_menu_model->menu_list($per_page, $startpoint);
    $data['pagination'] = $this->User_menu_model->pagination($statement, $per_page, $page, $url = '?');
    $data['UserLevel'] = $this->session->UserLevel;
    $data['startpoint'] = ($page * $per_page) - $per_page;
      
    if ($data != 0)
    {        
      $data['data'] = $data;
      $data['fileToLoad'] = 'user_menu/menu_list';
      $data['pageTitle'] = 'EPI-MIS | Menu';
      $this->load->view('template/epi_template', $data);
    }
    else
    {
      $data['message'] = "You must have rights to access this page.";
      $this->load->view("message", $data);
    }
  }

  public function save_menu() //work_in progress
  {
    if(isset($_REQUEST['AddMenu']))
		{ 
      $location = base_url(). "User_menu/menu_list";
      $this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
      $this->form_validation->set_rules('menu_item', 'Menu Item', 'required');
      $this->form_validation->set_rules('menu_url', 'Menu Url', 'required');
      $this->form_validation->set_rules('template', 'Template', 'required');

      $utypeArray = $_REQUEST['jsfields_id'];
      $utypeArray = explode(',', $utypeArray);
      $utypeArray = array_unique($utypeArray);

      $levelArray = $_REQUEST['jsfields_parent'];
      $levelArray = explode(',', $levelArray);
      $levelArray = array_unique($levelArray);

      $data['menu_item']  = $_REQUEST['menu_item'];
      $data['menu_url']   = $_REQUEST['menu_url'];
      $data['icon']       = $_REQUEST['menu_icon'];
      $data['parent_id']  = $_REQUEST['node_id'];
      $data['template']   = $_REQUEST['menu_temp'];
        
      $this->User_menu_model->save_menu($data);
        
      $userRoleID = $this->User_menu_model->getID($utypeArray, $levelArray);
      $menuID     = $this->User_menu_model->getMenuID();
      $count_id   = count($userRoleID);
      $status     = [];

      for ($i=0; $i<$count_id; $i++)
      {
        $status['role_id'][$i] = $userRoleID[$i][0]['id'];
        $status['menu_id'] =$menuID[0]['max'];
        $status['active'] = $_REQUEST['active'];
      }
      $this->User_menu_model->saveRolesMenu($status);
      redirect($location);
    }

    if(isset($_REQUEST['UpdateMenu']))
    {
      $location = base_url(). "User_menu/menu_list";
      $this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
      $this->form_validation->set_rules('menu_item', 'Menu Item', 'required');
      $this->form_validation->set_rules('menu_url', 'Menu Url', 'required');
      $this->form_validation->set_rules('template', 'Template', 'required');

      $utypeArray = $_REQUEST['jsfields_id'];
      $utypeArray = explode(',', $utypeArray);
      $utypeArray = array_unique($utypeArray);

      $levelArray = $_REQUEST['jsfields_parent'];
      $levelArray = explode(',', $levelArray);
      $levelArray = array_unique($levelArray);

      if($_REQUEST['id'] == $_REQUEST['node_id'])
      {
        $data['id']         = $_REQUEST['id'];
        $data['menu_item']  = $_REQUEST['menu_item'];
        $data['menu_url']   = $_REQUEST['menu_url'];
        $data['icon']       = $_REQUEST['menu_icon'];
        $data['parent_id']  = $_REQUEST['node_Parent_id'];
        $data['template']   = $_REQUEST['menu_temp'];
      }
      else
      {
        $data['id']         = $_REQUEST['id'];
        $data['menu_item']  = $_REQUEST['menu_item'];
        $data['menu_url']   = $_REQUEST['menu_url'];
        $data['icon']       = $_REQUEST['menu_icon'];
        $data['parent_id']  = $_REQUEST['node_id'];
        $data['template']   = $_REQUEST['menu_temp'];
      }

      $id = $data['id'];
      $this->User_menu_model->delete_by_id($id); 
      $this->User_menu_model->save_menu($data);

      $userRoleID = $this->User_menu_model->getID($utypeArray, $levelArray);
      // $menuID     = $this->User_menu_model->getMenuID(); menuID[0]['max']
      $count_id   = count($userRoleID);
      $status     = [];
      //print_r($userRoleID);
      //exit();

      for ($i=0; $i<$count_id; $i++)
      {
        $status['role_id'][$i] = $userRoleID[$i][0]['id'];
        $status['menu_id'] = $id;
        $status['active'] = $_REQUEST['active'];
      }
      $this->User_menu_model->saveRolesMenu($status);
      redirect($location);
    }
  }

  public function getMenu() //done works_fine
  {
    $data = $this->User_menu_model->getMenu($this->input->post('menu_temp'));	
    echo $data;	
  }

  public function getUsers() //done works_fine
  {
    $data = $this->User_menu_model->getUsers();	
    echo $data;	
  }

  public function delete_by_id($id) //work_in_progress
  {
    $this->User_menu_model->delete_by_id($id);
    echo "Done"; 
    //exit;
  }

  public function delete_by_role($id=NULL, $role=NULL) //work_in_progress
  {
    $menu_id =  $this->uri->segment(3);
    $rol_id =  $this->uri->segment(4);
    $this->User_menu_model->delete_by_role($menu_id, $rol_id);
    echo "done";
  }

  public function edit_menu()
  {
    $menu       = $this->input->get_post('menu');
    $menu_temp  = $this->input->get_post('menu_temp');
		$data       = $this->User_menu_model->edit_menu($menu, $menu_temp);	
		echo $data;	
  }

  public function editUsers()
  {
    $menu = $this->input->get_post('menu');
		$data = $this->User_menu_model->editUsers($menu);	
		echo $data;	
  }
}
?>