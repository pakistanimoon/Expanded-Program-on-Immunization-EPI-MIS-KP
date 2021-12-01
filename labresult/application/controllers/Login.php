<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Login_model','login');
    }
	public function index()
	{
			
		$this->load->view('index');		
	}
	public function login()
	{
		$username = $this -> input -> post('username');
		$password  = $this -> input -> post('password');
		$result = $this -> login -> authenticate($username);
		if(!empty($result['username'])){
		if(md5($password) == $result['password'])
		{
			//$result = $this-> login-> create_session($result['userid']);
			$user_array = array(
				'username' => $result['username'],
				'level' => $result['level'],
				'utype' => $result['utype'],
				'distcode' => $result['distcode'],
				'procode' => $result['procode'],
				'addedby' => $result['addedby'],
				'addeddate' => $result['addeddate'],
				'updateddate' => $result['updateddate'],
				'facode' => $result['facode'],
				'tcode' => $result['tcode'],
				'uncode' => $result['uncode'],
				'batch_status' => $result['batch_status'],
				'fullname' => $result['fullname'],
				'designation' => $result['designation'],
				'name' => $result['name'],
				'department' => $result['department'],
				'email' => $result['email'],
				'cell_no' => $result['cell_no'],
				'active' => $result['active'],
				'labuser' => $result['labuser'],
				'logged_in' => TRUE
			);
			//print_r($user_array);exit;
			$this -> session -> set_userdata($user_array);
			redirect(base_url("Measles_Case/search_by_epid"));
		}
		else{
			
			$this->session->set_flashdata('message', 'Wrong User Password!!'); 
			redirect(base_url());
		}
		}else{
			$this->session->set_flashdata('message', 'No such Username exists!'); 
			redirect(base_url());
		}
	}
	public function logout()
	{
		$this -> session -> sess_destroy();
		redirect(base_url());
	}
	
	
}
 