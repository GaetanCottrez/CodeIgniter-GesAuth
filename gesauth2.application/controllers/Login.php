<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Login for Gesauth
 *
 * A Codeigniter library authentification based on Aauth.
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */

include APPPATH.'controllers/Tools_template.php';
class Login extends Tools_template {

	private $title="";
	private $name_class="login";
	private $var = array();
	private $config_vars = array();
	private $language = '';
	public function __construct()
	{
		//	Obligatoire
		parent::__construct();

		//Set du titre
		$this->CI =& get_instance();
		$this->config_vars = $this->CI->config->item('gesauth');
		$this->language = GetLanguageVistor($this->input->server('HTTP_ACCEPT_LANGUAGE'));
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
		//$this->is_loggedin();
		$data = array();

		$data['lang']['welcome_title'] = $this->lang->line('welcome_title');
		$data['lang']['login_title'] = $this->lang->line('login_title');
		$data['lang']['login_paragraph1'] = $this->lang->line('login_paragraph1');
		$data['lang']['login_input_login'] = $this->lang->line('login_input_login');
		$data['lang']['login_input_password'] = $this->lang->line('login_input_password');
		$data['lang']['login_submit_login'] = $this->lang->line('login_submit_login');
		$data['lang']['gesauth_authentification_mode'] = $this->lang->line('gesauth_authentification_mode');
		// On charge le titre de la page
		if($this->title != "") $this->template->set_title($this->title);
		if($this->session->userdata('errors_gesauth')){
			$data['errors'] = $this->session->userdata('errors_gesauth');
		}
		if($this->gesauth->get_status_server()){
			unset($this->gesauth->array_gesauth_mode['ldap']);
			$data['errors'][] = $this->lang->line('gesauth_authentification_ldap_temporarily_unavailable');
		}
		$data['options'] = $this->gesauth->array_gesauth_mode;
		$data['option_selected'] = $this->gesauth->gesauth_mode_default;


		$this->template->view('login/login',$data);
	}

	public function logout(){
		$this->gesauth->logout();
		redirect(site_url());
	}

	public function ajax_check() {
		if($this->input->post('ajax') == '1') {
			$this->form_validation->set_rules('login', 'nom d\'utilisateur', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'mot de passe', 'trim|required|xss_clean');
			$this->form_validation->set_message('required', $this->lang->line('login_field_required'));
			if($this->form_validation->run() == FALSE) {
				$this->var['output'] = validation_errors();
				$this->var['class'] = "alert alert-danger alert-dismissable";

				$this->var['javascript'] .= "$('#login').removeClass('has-success');";
				$this->var['javascript'] .= "$('#password').removeClass('has-success');";

				$this->var['javascript'] .= "$('#login').addClass('has-error');";
				$this->var['javascript'] .= "$('#password').addClass('has-error');";

			} else {
				if ($this->gesauth->login($this->input->post('login'),$this->input->post('password'), false, $this->input->post('gesauth_mode'))){
	           		$this->var['output'] = $this->lang->line('login_success');
					$this->var['class'] = "alert alert-success alert-dismissable";

					$this->var['javascript'] .= "$('#login').removeClass('has-error');";
					$this->var['javascript'] .= "$('#password').removeClass('has-error');";

					$this->var['javascript'] .= "$('#login').addClass('has-success');";
					$this->var['javascript'] .= "$('#password').addClass('has-success');";
					if($this->CI->session->userdata($this->config_vars['prefix_session'].'last_url_visited'))
						$this->var['javascript'] .=javascript_code_redirect($this->CI->session->userdata($this->config_vars['prefix_session'].'last_url_visited'), 'top', 2000);
					else
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

	public function ajax_close_browser() {
		$this->gesauth->close_browser(1);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */