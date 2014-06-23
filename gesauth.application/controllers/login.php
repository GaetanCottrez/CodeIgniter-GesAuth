<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Login for Gesauth
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	Gesauth
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license
 * @version    	1.0
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 *
 *
 */

class Login extends CI_Controller {

	private $title="";
	private $name_class="login";
	private $var = array();
	private $language = '';
	public function __construct()
	{
		//	Obligatoire
		parent::__construct();

		//Set du titre
		$this->language = GetLanguageVistor();
		$this->lang->load($this->name_class,$this->language);
		$this->title = $this->lang->line('welcome_title');
		$this->var['output'] = '';
		$this->var['class'] = '';
		$this->var['javascript'] = '';

	}

	public function is_loggedin(){
		if(isset($this->session->userdata['user_loggedin'])
		&& $this->session->userdata['user_loggedin'] == TRUE
		&& isset($this->session->userdata['user_id'])
		&& $this->session->userdata['user_id'] != ""){
			redirect(site_url());
		}
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
		$this->is_loggedin();
		$data = array();

		$data['lang']['welcome_title'] = $this->lang->line('welcome_title');
		$data['lang']['login_title'] = $this->lang->line('login_title');
		$data['lang']['login_paragraph1'] = $this->lang->line('login_paragraph1');
		$data['lang']['login_input_login'] = $this->lang->line('login_input_login');
		$data['lang']['login_input_password'] = $this->lang->line('login_input_password');
		$data['lang']['login_submit_login'] = $this->lang->line('login_submit_login');

		// On charge le titre de la page
		if($this->title != "") $this->template->set_title($this->title);

		$this->template->view('login/login',$data);

	}

	public function logout(){
		$this->gesauth->logout();
		redirect(site_url());
	}

	public function ajax_check() {
		if($this->input->post('ajax') == '1') {
			$this->form_validation->set_rules('login', 'nom d\'utilisateur', 'trim|required|xss_clean|callback_login_required');
			$this->form_validation->set_rules('password', 'mot de passe', 'trim|required|xss_clean|callback_password_required');
			$this->form_validation->set_message('required', $this->lang->line('login_field_required'));
			if($this->form_validation->run() == FALSE) {
				$this->var['output'] = validation_errors();
				$this->var['class'] = "alert alert-danger alert-dismissable";

				$this->var['javascript'] .= "$('#login').removeClass('has-success');";
				$this->var['javascript'] .= "$('#password').removeClass('has-success');";

				$this->var['javascript'] .= "$('#login').addClass('has-error');";
				$this->var['javascript'] .= "$('#password').addClass('has-error');";

			} else {
				if ($this->gesauth->login($this->input->post('login'),$this->input->post('password'), false)){
	           		$this->var['output'] = $this->lang->line('login_success');
					$this->var['class'] = "alert alert-success alert-dismissable";

					$this->var['javascript'] .= "$('#login').removeClass('has-error');";
					$this->var['javascript'] .= "$('#password').removeClass('has-error');";

					$this->var['javascript'] .= "$('#login').addClass('has-success');";
					$this->var['javascript'] .= "$('#password').addClass('has-success');";

					$this->var['javascript'] .=javascript_code_redirect(site_url(), 'top', 2000);

				}else{
		        	$this->var['output'] = $this->gesauth->get_errors();
		       		$this->var['class'] = "alert alert-danger alert-dismissable";

		       		$this->var['javascript'] .= "$('#login').removeClass('has-success');";
		       		$this->var['javascript'] .= "$('#password').removeClass('has-success');";

		       		$this->var['javascript'] .= "$('#login').addClass('has-error');";
		       		$this->var['javascript'] .= "$('#password').addClass('has-error');";

				}
			}

			$this->load->view('login/login_message',$this->var);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */