<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library GesAuth
 *
 * A Codeigniter library authentification based on Aauth.
 *
 * Copyright (C) 2014-2015 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014-2015, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1.4
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */


class Gesauth {

    public $CI;
    private $config_vars;
    public $errors = array();
    public $infos = array();
    public $file_language = 'gesauth';
    public $gesauth_model;
	private $session;
	private $mysql_auth;
    private $ldap_auth;
    private $ldap_connect;
    private $ldap_temporarily_unavailable = false;
    public $array_gesauth_mode = array();
    private $is_loggedin = false;
    public function __construct() {
    	// delete all errors at first :)
        $this->errors = array();

        $this->CI = & get_instance();

        // config/gesauth.php
        $this->CI->config->load('gesauth');

        // the array which came from gesauth config file
        // $this->config_vars
        $this->config_vars = & $this->CI->config->item('gesauth');
        // Load model in the library and instance $this->gesauth_model with the model
        // for an easy utilisation
        $this->CI->load->model('gesauth_model');
    	$this->gesauth_model = new gesauth_model();

    	// dependancies
        // Uncomment or delete this line if autoload this library and helper
        //$this->CI->load->library('session');
        //$this->CI->load->library('email');
        //$this->CI->load->database();
        //$this->CI->load->helper('url');
        //$this->CI->load->helper('string');
        //$this->CI->load->helper('email');
    	//$this->CI->load->helper('gesauth');

        //language/french/gesauth_lang.php
        $this->CI->lang->load($this->file_language);

        // Get Session
        $this->session = $this->CI->session;

        // Clean session close browser
        $this->clean_session_user_agent_close();
		 // Clean session with activity expired
        $this->clean_session_for_expiration();

       // this user data is used for security DDOS
        if( ! $this->session->userdata('last_login_attempt') ){
        	$this->session->set_userdata('last_login_attempt', $this->session->userdata('last_activity'));
        }

    	// this user data is used for clean session close browser
        if( ! $this->session->userdata($this->config_vars['prefix_session'].'agent_close') ){
        	$this->session->set_userdata($this->config_vars['prefix_session'].'agent_close', 0);
        }

        // gesauth authentification mode
        switch($this->config_vars['gesauth_mode']){
        	case 'mysql':
        		$this->mysql_auth = true;
        		$this->ldap_auth = false;
        		$this->array_gesauth_mode = array( 'mysql' => 'MySQL' );
        		break;

        	case 'ldap':
        		$this->mysql_auth = false;
        		$this->ldap_auth = true;
        		$this->extension_ldap_loaded();
        		$this->array_gesauth_mode = array( 'ldap' => 'Windows' );
        		break;

        	case 'mysql/ldap':
        		$this->mysql_auth = true;
        		$this->ldap_auth = true;
        		$this->extension_ldap_loaded();
        		$this->array_gesauth_mode = array( 'mysql' => 'MySQL', 'ldap' => 'Windows' );
        		break;

        	default:
        		$this->mysql_auth = true;
        		$this->ldap_auth = false;
        		$this->array_gesauth_mode = array( 'mysql' => 'MySQL' );
        }

        $this->gesauth_mode_default = $this->config_vars['gesauth_mode_default'];

        $this->etablish_connection_ldap();
    }

    /**
     *	Create a line log in the file log codeigniter
     *
     *	@access private
	 *	@param string $type is the type of log
     *	@param string $message is the message of log
     */

    private function gesauth_logs_message($type,$message){
    	if($this->config_vars['logs_gesauth']){
    		log_message($type, $message);
    	}
    }

    /**
     *	Get status server
     *
     *	@access public
	 *	@return bool
	 */

     public function get_status_server(){
    	return $this->ldap_temporarily_unavailable;
    }

    /**
     *	etablish a connection ldap with the DC
     *
     *	@access private
	 */

     private function etablish_connection_ldap(){
    	if($this->ldap_auth){
    		$this->ldap_connect = ldap_connect ( $this->config_vars['LDAP_DC'], $this->config_vars['LDAP_PORT_DC'] );
			if (!$this->ldap_connect) {
    			$this->ldap_temporarily_unavailable = true;
    			$this->gesauth_logs_message('ERROR', 'gesauth ldap info : '.sprintf($this->CI->lang->line('gesauth_unable_to_connect_server_ldap'), $this->config_vars['LDAP_DC']));
    		}

			// if you use OpenLDAP_2.x.x, test etablish connection with a valid account for verify available LDAP
			if($this->config_vars['OpenLDAP_2.x.x']){
				$bind = @ldap_bind ( $this->ldap_connect, $this->config_vars['LDAP_AD_USER'], $this->config_vars['LDAP_AD_USER_PASSWORD'] );
				if (! $bind) {
					$this->ldap_temporarily_unavailable = true;
					$this->gesauth_logs_message('ERROR', 'gesauth ldap info : '.sprintf($this->CI->lang->line('gesauth_unable_to_connect_server_ldap'), $this->config_vars['LDAP_DC']));
				}
			}
		}
    }

    /**
	 *	change value user_agent_close to field userdata
	 *
	 *	@access public
	 *	@param bool $close_browser is the value user_agent_close
	 */

	public function close_browser($close_browser=0){
    	$this->session->set_userdata($this->config_vars['prefix_session'].'agent_close', $close_browser);
    }

    /**
	 *	clean all session close user agent
	 *
	 *	@access private
	 */

	private function clean_session_user_agent_close(){
    	if ($this->config_vars['clean_session_user_agent_close'] != true)
    	{
    		return;
    	}
    	$timestamp = time() - $this->config_vars['time_to_clean_session_user_agent_close'];
    	$this->gesauth_model->clean_session_user_agent_close($timestamp);

    }

    /**
	 *	clean all session close user agent
	 *
	 *	@access private
	 */

	private function clean_session_for_expiration(){
    	if ($this->config_vars['clean_session_for_expiration'] == false)
    	{
    		return;
    	}
    	// fix clean expiration session user load this treatment
    	if($this->session->userdata('last_activity') +$this->config_vars['time_to_clean_session_for_expiration'] < time()){
    		$this->new_session('gesauth_session_expired');
    	}
    	$timestamp = time() - $this->config_vars['time_to_clean_session_for_expiration'];
    	$error_message['errors_gesauth'][] = $this->CI->lang->line('gesauth_session_expired');
    	$data['user_data'] = serialize($error_message);
    	$this->gesauth_model->clean_session_for_expiration($timestamp, $data);

    }

    /**
	 *	check extension loaded in the server
	 *
	 *	@access private
	 */

	private function extension_ldap_loaded(){
    	if (!extension_loaded('ldap')){
    		$this->gesauth_logs_message('ERROR', 'gesauth ldap error : '.$this->CI->lang->line('gesauth_ldap_not_support'));
    		echo $this->CI->lang->line('gesauth_ldap_not_support');
    		die();
    	}
    }

    /**
	 *	primary verification before connection
	 *	security dos attack
	 *	check disabled user
	 *
	 *	@access private
	 *	@param string $id is the id user
	 *	@return bool
	 */

	private function primary_verification_before_connection($id){
    	// remove cookies first
    	setcookie("user", "", time()-3600, '/');

    	// if user exist
    	$query = $this->gesauth_model->get_user($id);
		if ($query->num_rows() > 0) {
    		$row = $query->row();
    		$last_login_attempt = $row->last_login_attempt;
    	}else{
    		$last_login_attempt = $this->session->userdata('last_login_attempt');
    	}

    	// security dos attack
    	if ( $this->config_vars['dos_protection'] and $last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($last_login_attempt) ) {
    		$this->error($this->CI->lang->line('gesauth_exceeded'));
    		// if active logs authentification
    		if($this->config_vars['active_logs_authentification']){
    			$datalog = array(
    					'user_id' => $id,
    					'date' => date('Y-m-d H:i:s'),
    					'ip_address' => $this->session->userdata('ip_address'),
    					'user_agent' => $this->session->userdata('user_agent'),
    					'type' => 'error',
    					'informations_log' => $this->CI->lang->line('gesauth_exceeded'),
    					'authentification' => 'MySQL'
    			);
    			$this->gesauth_model->insert_logs_authentification($datalog);
    		}
    		return false;
    	}

    	// check disabled user
    	$query = null;
    	$query = $this->gesauth_model->is_disabled($id);
    	if ($query->num_rows() > 0) {
    		$this->error($this->CI->lang->line('gesauth_disabled'));
    		// if active logs authentification
    		if($this->config_vars['active_logs_authentification']){
    			$datalog = array(
    					'user_id' => $id,
    					'date' => date('Y-m-d H:i:s'),
    					'ip_address' => $this->session->userdata('ip_address'),
    					'user_agent' => $this->session->userdata('user_agent'),
    					'type' => 'error',
    					'informations_log' => $this->CI->lang->line('gesauth_disabled'),
    					'authentification' => 'MySQL'
    			);
    			$this->gesauth_model->insert_logs_authentification($datalog);
    		}
    		return false;
    	}

    	return true;
    }

	/**
	 *	login the user
	 *
	 *	@access public
	 *	@param string $id is the id user
	 *	@param string $pass is the id user
	 *	@param bool $remember is the remember user
	 *	@param string $gesauth_mode is the gesauth mode
	 *	@return bool
	 */

	public function login($id, $pass, $remember = FALSE, $gesauth_mode='') {
    	if($gesauth_mode == '') $gesauth_mode = $this->config_vars['gesauth_mode_default'];

    	switch($gesauth_mode){
    		case 'mysql':
    			$login = $this->login_mysql($id, $pass, $remember);
    			break;

    		case 'ldap':
    			$login = $this->login_ldap($id, $pass, $remember);
    			break;

    		default:
    			$login = $this->login_mysql($id, $pass, $remember);

    	}

    	if($login){
    		// disconnect other session contain this user_id
			$this->disconnect_session($id);
    	}

    	return $login;
    }

     /**
	 *	encode array
	 *
	 *	@access public
	 *	@param array $array array to encode
	 *	@return array
	 */

	private function encode_array($array){
		foreach($array as $key => $value)
		{
			if(is_array($value))
			{
				$array[$key] = $this->encode_array($value);
			}
			else
			{
				$array[$key] = iconv("ISO-8859-1",$this->CI->config->item('charset'),$value);
			}
		}

		return $array;
	}

	/**
	 *	login ldap the user
	 *
	 *	@access private
	 *	@param string $id is the id user
	 *	@param string $pass is the id user
	 *	@param bool $remember is the remember user
	 *	@return bool
	 */
	 
	private function login_ldap($id, $pass, $remember = FALSE){

		$this->etablish_connection_ldap();
		// if ldap is temporarily unavailable, stop the script
    	if($this->ldap_temporarily_unavailable){
			$this->error($this->CI->lang->line('gesauth_no_etablish_connection_ldap'));
			return false;
		}

		// primary verification before connection
		$primary_verification_before_connection = $this->primary_verification_before_connection($id);
		if(!$primary_verification_before_connection){
			return false;
		}

		$array = explode ( '@', $id );

		// build id user by server version
		if ($this->config_vars['PREVIOUS_WIN2K'])
			$id_ldap = $array [0];
		else
			$id_ldap = $array [0] . '@' . $this->config_vars['LDAP_DOMAIN'];

		//build a filter by version server
		if ($this->config_vars['PREVIOUS_WIN2K'])
			$filter = "(samAccountName=" . $id_ldap . ")";
		else
			$filter = "(userPrincipalName=" . $id_ldap . ")";

		//this is an array from the AD
		$justthese = array( "ou", "sn", "givenname", "cn", "mail", "displayName", "uid", "title", "telephonenumber", "mobile", "userAccountControl");

		//start the search ldap
		$search = ldap_search ( $this->ldap_connect, $this->config_vars['LDAP_AD_OU'], $filter, $justthese );
		// get value user
		$res = ldap_get_entries ( $this->ldap_connect, $search );
		if ($res ["count"] != 1) {
			$this->error($this->CI->lang->line('gesauth_no_result_to_search_ldap'));
			return false;
		}else{
			$res = $this->encode_array($res);
		}
		

		/*
		 * Normal Day to Day Values:
		===========================
			512 - Enable Account
			514 - Disable account
			544 - Account Enabled - Require user to change password at first logon
			4096 - Workstation/server
			66048 - Enabled, password never expires
			66050 - Disabled, password never expires
			262656 - Smart Card Logon Required
			532480 - Domain controller

			All Other Values:
		===========================
			1 - script
			2 - accountdisable
			8 - homedir_required
			16 - lockout
			32 - passwd_notreqd
			64 - passwd_cant_change
			128 - encrypted_text_pwd_allowed
			256 - temp_duplicate_account
			512 - normal_account
			2048 - interdomain_trust_account
			4096 - workstation_trust_account
			8192 - server_trust_account
			65536 - dont_expire_password
			131072 - mns_logon_account
			262144 - smartcard_required
			524288 - trusted_for_delegation
			1048576 - not_delegated
			2097152 - use_des_key_only
			4194304 - dont_req_preauth
			8388608 - password_expired
			16777216 - trusted_to_auth_for_delegation
		 */

		// this a simple check user account control
		if($res[0]["useraccountcontrol"][0] != 512 ){
			if($res[0]["useraccountcontrol"][0] == 514){
				$this->error($this->CI->lang->line('gesauth_disabled'));
				return false;
			}

			if($res[0]["useraccountcontrol"][0] == 8388608){
				$this->error($this->CI->lang->line('gesauth_password_expired_ldap'));
				return false;
			}
		}

		// get user by id into database
		$query = null;
		$query = $this->gesauth_model->get_user($id);
		$row = $query->row();
		if ($query->num_rows() > 0) {

			$data = array(
					$this->config_vars['prefix_session'].'id' => $id,
					$this->config_vars['prefix_session'].'name' => $res[0]["sn"][0],
					$this->config_vars['prefix_session'].'firstname' => $res[0]["givenname"][0],
					$this->config_vars['prefix_session'].'email' => $res[0]["mail"][0],
					$this->config_vars['prefix_session'].'language' => $row->value_language,
					$this->config_vars['prefix_session'].'last_login' => $row->last_login,
					//$this->config_vars['prefix_session'].'title' => $res[0]["title"][0],
					//this->config_vars['prefix_session'].'phone' => $res[0]["telephonenumber"][0],
					//$this->config_vars['prefix_session'].'mobile' => $res[0]["mobile"][0],
					$this->config_vars['prefix_session'].'loggedin' => TRUE
			);
			$this->session->set_userdata($data);
			// id remember selected
			if ($remember){
				$expire = $this->config_vars['remember'];
				$today = date("Y-m-d");
				$remember_date = date("Y-m-d", strtotime($today . $expire) );
				$random_string = random_string('alnum', 16);
				$this->update_remember($id, $random_string, $remember_date );

				setcookie( 'user', $id . "-" . $random_string, time() + 99*999*999, '/');
			}

			// Get role user and built session roles
			$query = null;
			$query = $this->gesauth_model->get_user_roles($id);
			if ($query->num_rows() > 0) {
				$data = array();
				foreach ($query->result() as $row)
				{
					$data[] = array(
							'id' => $row->id,
							'name' => $row->name
					);
				}
				$this->session->set_userdata($this->config_vars['prefix_session'].'roles',$data);

			}
			// update last login
			$this->update_last_login($id);
			$this->update_activity();

			if($this->config_vars['active_logs_authentification']){
				$datalog = array(
						'user_id' => $id,
						'date' => date('Y-m-d H:i:s'),
						'ip_address' => $this->session->userdata('ip_address'),
						'user_agent' => $this->session->userdata('user_agent'),
						'type' => 'success',
						'informations_log' => 'login success',
						'authentification' => 'LDAP'
				);
				$this->gesauth_model->insert_logs_authentification($datalog);
			}

			return TRUE;

		}else{

			// check last login attempt and set the session user
			$last_login_attempt = $this->session->userdata('last_login_attempt');

			if ( $last_login_attempt == null or  (strtotime("now") - 600) > strtotime($last_login_attempt) )
			{
				$data = array(
						'last_login_attempt' =>  date("Y-m-d H:i:s")
				);

				$last_login_attempt_session = date("Y-m-d H:i:s");

			} else if (!($last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($last_login_attempt))) {

				$newtimestamp = strtotime("$last_login_attempt + 30 seconds");
				$data = array(
						'last_login_attempt' =>  date( 'Y-m-d H:i:s', $newtimestamp )
				);

				$last_login_attempt_session = date( 'Y-m-d H:i:s', $newtimestamp );
			}

			$this->session->set_userdata('last_login_attempt', $last_login_attempt_session);

			$this->error($this->CI->lang->line('gesauth_wrong'));
			// if active logs authentification
			if($this->config_vars['active_logs_authentification']){
				$datalog = array(
						'user_id' => $id,
						'date' => date('Y-m-d H:i:s'),
						'ip_address' => $this->session->userdata('ip_address'),
						'user_agent' => $this->session->userdata('user_agent'),
						'type' => 'error',
						'informations_log' => $this->CI->lang->line('gesauth_wrong'),
						'authentification' => 'LDAP'
				);
				$this->gesauth_model->insert_logs_authentification($datalog);
			}
			return FALSE;
		}

    }

    /**
	 *	login mysql the user
	 *
	 *	@access private
	 *	@param string $id is the id user
	 *	@param string $pass is the id user
	 *	@param bool $remember is the remember user
	 *	@return bool
	 */

	private function login_mysql($id, $pass, $remember = FALSE){

    	// primary verification before connection
		$primary_verification_before_connection = $this->primary_verification_before_connection($id);
    	if(!$primary_verification_before_connection){
    		return false;
    	}

    	// check user/password into database
    	$query = null;
    	$query = $this->gesauth_model->login_user($id,$pass);

    	$row = $query->row();

    	if ($query->num_rows() > 0) {

    		// if email and pass matches
    		// create session
    		$data = array(
    				$this->config_vars['prefix_session'].'id' => $row->id,
    				$this->config_vars['prefix_session'].'name' => $row->name,
    				$this->config_vars['prefix_session'].'firstname' => $row->firstname,
    				$this->config_vars['prefix_session'].'email' => $row->email,
    				$this->config_vars['prefix_session'].'language' => $row->language,
    				$this->config_vars['prefix_session'].'last_login' => $row->last_login,
    				$this->config_vars['prefix_session'].'loggedin' => TRUE
    		);

    		$this->session->set_userdata($data);

    		// id remember selected
    		if ($remember){
    			$expire = $this->config_vars['remember'];
    			$today = date("Y-m-d");
    			$remember_date = date("Y-m-d", strtotime($today . $expire) );
    			$random_string = random_string('alnum', 16);
    			$this->update_remember($row->id, $random_string, $remember_date );

    			setcookie( 'user', $row->id . "-" . $random_string, time() + 99*999*999, '/');
    		}

    		// Get role user and built session roles
    		$query = $this->gesauth_model->get_user_roles($id);
    		if ($query->num_rows() > 0) {
    			$data = array();
    			foreach ($query->result() as $row)
    			{
    				$data[] = array(
    						'id' => $row->id,
    						'name' => $row->name
    				);
    			}
    			$this->session->set_userdata($this->config_vars['prefix_session'].'roles',$data);

    		}
    		// update last login
    		$this->update_last_login($id);
    		$this->update_activity();

    		if($this->config_vars['active_logs_authentification']){
    			$datalog = array(
    					'user_id' => $id,
    					'date' => date('Y-m-d H:i:s'),
    					'ip_address' => $this->session->userdata('ip_address'),
    					'user_agent' => $this->session->userdata('user_agent'),
    					'type' => 'success',
    					'informations_log' => 'login success',
    					'authentification' => 'MySQL'
    			);
    			$this->gesauth_model->insert_logs_authentification($datalog);
    		}

			return TRUE;

    	} else {
			// get user by id
    		$query = $this->gesauth_model->get_user($id);

    		$row = $query->row();

    		// check last login attempt and set the session user
    		if ($query->num_rows() > 0) {
    			$last_login_attempt = $row->last_login_attempt;
    		}else{
    			$last_login_attempt = $this->session->userdata('last_login_attempt');
    		}

    		if ( $last_login_attempt == null or  (strtotime("now") - 600) > strtotime($last_login_attempt) )
    		{
    			$data = array(
    					'last_login_attempt' =>  date("Y-m-d H:i:s")
    			);

    			$last_login_attempt_session = date("Y-m-d H:i:s");

    		} else if (!($last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($last_login_attempt))) {

    			$newtimestamp = strtotime("$last_login_attempt + 30 seconds");
    			$data = array(
    					'last_login_attempt' =>  date( 'Y-m-d H:i:s', $newtimestamp )
    			);

    			$last_login_attempt_session = date( 'Y-m-d H:i:s', $newtimestamp );
    		}


    		if ($query->num_rows() > 0) {
    			$this->gesauth_model->update_user($id,$data);
    		}else{
    			$this->session->set_userdata('last_login_attempt', $last_login_attempt_session);
    		}

    		$this->error($this->CI->lang->line('gesauth_wrong'));
    		// if active logs authentification
    		if($this->config_vars['active_logs_authentification']){
    			$datalog = array(
    					'user_id' => $id,
    					'date' => date('Y-m-d H:i:s'),
    					'ip_address' => $this->session->userdata('ip_address'),
    					'user_agent' => $this->session->userdata('user_agent'),
    					'type' => 'error',
    					'informations_log' => $this->CI->lang->line('gesauth_wrong'),
    					'authentification' => 'MySQL'
    			);
    			$this->gesauth_model->insert_logs_authentification($datalog);
    		}
    		return FALSE;
    	}
    }

    /**
	 *	disconnect all other session of this user
	 *
	 *	@access public
	 *	@param string $user_id is the id user
	 */

	public function disconnect_session($user_id=''){
    	if($user_id == '') $user_id = $this->session->userdata($this->config_vars['prefix_session'].'id');
    	$userdata = array(
    			'user_data' => '',
    			'errors_gesauth' => array( 0 => $this->CI->lang->line('gesauth_disconnect_by_other_user'))
    	);
		$data = array(
    			'user_data' => serialize($userdata),
    	);

		$this->gesauth_model->disconnect_session($data, $user_id, $this->session->userdata('session_id'));

    }

    /**
	 *	checks if user logged in
	 *	also checks remember
	 *
	 *	@access public
	 *	@param string $user_id is the id user
	 *	@return bool
	 */

	public function is_loggedin() {
		if($this->is_loggedin){
			return true;
		}
		// Is there a corresponding session in the DB?
    	$query = $this->gesauth_model->get_session_in_db();

    	$row = $query->row();
    	// Does the IP Match?
		if ($this->config_vars['match_ip'] == TRUE && ($row->ip_address != $this->CI->input->ip_address()))
		{
			$this->new_session('gesauth_ip_address_change');

			return false;
		}

    	//refresh userdata user_agent_close when user refresh page
		if($this->session->userdata($this->config_vars['prefix_session'].'agent_close') == 1){
        	$this->close_browser();
        }
        if($this->session->userdata($this->config_vars['prefix_session'].'loggedin')){
        	// update activity session
        	$this->update_activity();
        	// unset the userdata errors_gesauth
        	$this->session->unset_userdata('errors_gesauth');
        	// save url visited
        	$this->session->set_userdata($this->config_vars['prefix_session'].'last_url_visited', current_url());
        	$this->is_loggedin = true;
        	return true;
        } else{
        	if( !array_key_exists('user', $_COOKIE) ){
                return false;
            }else{
                $cookie = explode('-', $_COOKIE['user']);
                if(!is_numeric( $cookie[0] ) or strlen($cookie[1]) < 13 ){return false;}
                else{
                    $query = $this->gesauth_model->get_user_by_id_and_remember_exp($cookie[0],$cookie[1]);

                    $row = $query->row();

                    if ($query->num_rows() < 1) {
                        $this->update_remember($cookie[0]);
                        return false;
                    }else{

                        if(strtotime($row->remember_time) > strtotime("now") ){
                            $this->login_fast($cookie[0]);
                            $this->is_loggedin = true;
        					return true;
                        }
                        // if time is expired
                        else {
                            return false;
                        }
                    }
                }

            }
        }
        return false;
    }

    /**
     *	create a new session with some user_data
     *
     *	@access private
     *	@param string $perm_par is the perm
     */

    private function new_session($error_message ='', $last_url_visited = true){
    	// save userdata last_url_visited
    	if($last_url_visited){
    		$set_last_url_visited = $this->session->userdata($this->config_vars['prefix_session'].'last_url_visited');
    	}

    	// destroy old session and create new session
    	$this->session->sess_destroy();
    	$this->session->sess_create();

    	// set last_url_visited if exist
    	if(isset($set_last_url_visited)){
    		$this->session->set_userdata($this->config_vars['prefix_session'].'last_url_visited', $set_last_url_visited);
    	}

    	// set error_message if exist
    	if($error_message != ''){
    		$this->error($this->CI->lang->line($error_message));
    	}
    }

    /**
	 *	most important function. it controls if a logged or public user has permiision
	 *	if no permission, it stops script
	 *	it also updates last activity every time function called
	 *	if perm_par is not given just control user logged in or not
	 *
	 *	@access public
	 *	@param string $perm_par is the perm
	 *	@return bool
	 */

	public function control($perm_par = false){

        if(!$perm_par and !$this->is_loggedin()){
        	// if active perms authentification
        	if($this->config_vars['active_logs_perms']){
        		$datalog = array(
        				'user_id' => $this->session->userdata($this->config_vars['prefix_session'].'id'),
        				'date' => date('Y-m-d H:i:s'),
        				'ip_address' => $this->session->userdata('ip_address'),
        				'user_agent' => $this->session->userdata('user_agent'),
        				'type' => 'no_access',
        				'url' => current_url(),
        				'informations_log' => $perm_par
        		);
        		$this->gesauth_model->insert_logs_perms($datalog);
        	}
            if($this->config_vars['display_no_access'] == true){
            	echo $this->CI->lang->line('gesauth_no_access');
                die();
            }else{
        		return false;
        	}
        }

        if( !$this->is_allowed(false, $perm_par) ) {
        	// if active perms authentification
        	if($this->config_vars['active_logs_perms']){
        		$datalog = array(
        				'user_id' => $this->session->userdata($this->config_vars['prefix_session'].'id'),
        				'date' => date('Y-m-d H:i:s'),
        				'ip_address' => $this->session->userdata('ip_address'),
        				'user_agent' => $this->session->userdata('user_agent'),
        				'type' => 'no_access',
        				'url' => current_url(),
        				'informations_log' => $perm_par
        		);
        		$this->gesauth_model->insert_logs_perms($datalog);
        	}
        	if($this->config_vars['display_no_access'] == true){
            	echo $this->CI->lang->line('gesauth_no_access');
                die();
        	}else{
        		return false;
        	}
        }

        return true;

    }

    /**
	 *	do logout
	 *
	 *	@access public
	 *	@param string $perm_par is the perm
	 *	@return
	 */

	public function logout() {
    	// if active logs authentification
    	if($this->config_vars['active_logs_authentification']){
    		$datalog = array(
    				'user_id' => $this->session->userdata($this->config_vars['prefix_session'].'id'),
            		'date' => date('Y-m-d H:i:s'),
    				'ip_address' => $this->session->userdata('ip_address'),
    				'user_agent' => $this->session->userdata('user_agent'),
    				'type' => 'disconnect',
    				'informations_log' => 'user disconnect',
    				'authentification' => 'MySQL'
    		);
    		$this->gesauth_model->insert_logs_authentification($datalog);
    	}

    	$this->new_session('gesauth_disconnect');
    }

    /**
	 *	do login with id
	 *
	 *	@access public
	 *	@param string $user_id is the user
	 */

	public function login_fast($user_id){
        $query = $this->gesauth_model->login_user($user_id,'',true);
        $row = $query->row();

        if ($query->num_rows() > 0) {

            // if id matches
            // create session
            $data = array(
                $this->config_vars['prefix_session'].'id' => $row->id,
                $this->config_vars['prefix_session'].'name' => $row->name,
                $this->config_vars['prefix_session'].'email' => $row->email,
                $this->config_vars['prefix_session'].'loggedin' => TRUE
            );

	        // if active logs authentification
	    	if($this->config_vars['active_logs_authentification']){
	    		$datalog = array(
	    				'user_id' => $row->id,
            			'date' => date('Y-m-d H:i:s'),
	    				'ip_address' => $this->session->userdata('ip_address'),
	    				'user_agent' => $this->session->userdata('user_agent'),
	    				'type' => 'fast_success',
	    				'informations_log' => 'fast login success',
	    				'authentification' => 'MySQL'
	    		);
	    		$this->gesauth_model->insert_logs_authentification($datalog);
	    	}

            $this->session->set_userdata($data);
        }
    }


    /**
	 *	updates user's last activity date
	 *
	 *	@access public
	 *	@param string $user_id is the user
	 */

	public function update_activity($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->session->userdata($this->config_vars['prefix_session'].'id');

        if($user_id==false){return false;}

        $data = array(
        	'last_activity' => date("Y-m-d H:i:s")
        );

        $this->gesauth_model->update_user($user_id, $data);
    }

    /**
	 *	updates last login date and time
	 *
	 *	@access public
	 *	@param string $user_id is the user
	 */

	public function update_last_login($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->session->userdata($this->config_vars['prefix_session'].'id');

    	if($user_id==false){return false;}

        $data = array(
        	'last_login' => date("Y-m-d H:i:s")
        );

        $this->gesauth_model->update_user($user_id, $data);
    }

    /**
	 *	updates remember time
	 *
	 *	@access public
	 *	@param string $user_id is the user
	 *	@param string $expression is the remember_exp
	 *	@param string $expire is the remember_time
	 */

	public function update_remember($user_id, $expression=null, $expire=null) {

    	if($user_id==false){return false;}

    	$data = array(
        	'remember_time' => $expire,
        	'remember_exp' => $expression
        );

    	$this->gesauth_model->update_user($user_id, $data);
    }


    /**
	 *	role_name or role_id
	 *
	 *	@access public
	 *	@param string $role_par is the user role
	 *	@return bool
	 */

	public function is_member($role_par) {

        $user_id = $this->session->userdata($this->config_vars['prefix_session'].'id');

        $this->get_role_id($role_par);
        // role_id given
        if (is_numeric($role_par)) {

            $query = $this->gesauth_model->check_user_is_member($user_id, $role_par);

            $row = $query->row();

            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        // role_name given
        else {

            $query = $this->gesauth_model->get_role_id($role_par);

            if ($query->num_rows() == 0)
                return FALSE;

            $row = $query->row();
            return $this->is_member($row->id);
        }
    }

    /**
	 *	check user is in admin role
	 *
	 *	@access public
	 *	@return bool
	 */

	public function is_admin() {
        return $this->is_member($this->config_vars['admin_role']);
    }

    /**
	 *	takes role paramater (id or name) and returns role id.
	 *
	 *	@access public
	 *	@param string $role_par is the user role
	 *	@return int id role
	 */

	public function get_role_id($role_par) {

        if( is_numeric($role_par) ) { return $role_par; }

        $query = $this->gesauth_model->get_role_id($role_par);

        if ($query->num_rows() == 0)
            return FALSE;

        $row = $query->row();
        return $row->id;
    }


    /**
	 *	checks if a role has permitions for given permition
	 *	if role paramater is empty function checks all roles of current user
	 *	admin authorized for anything
	 *
	 *	@access public
	 *	@param string $role_par is the user role
	 *	@param string $perm_par is the perm role
	 *	@return int id role
	 */

	public function is_allowed($role_par=false, $perm_par){

        $perm_id = $this->get_perm_id($perm_par);

        if($role_par != false){

            $role_par = $this->get_role_id($role_par);
            $query = $this->gesauth_model->check_perm_affected_to_role($perm_id, $role_par);

            if( $query->num_rows() > 0){
                return true;
            } else {
                return false;
            }
        }
        else {

        	if (!$this->is_loggedin()){return false;}

            // all doors open to admin :)
            if ( $this->is_admin() ) {return true;}

            $query = $this->gesauth_model->get_user_roles( $this->session->userdata($this->config_vars['prefix_session'].'id') );
			foreach ($query->result() as $g ){
				 if($this->is_allowed($g -> id, $perm_id)){
                    return true;
                }
            }


            return false;
        }

    }

    /**
	 *	get the perm id
	 *
	 *	@access public
	 *	@param string $perm_par is the perm role
	 *	@return int id role
	 */

	public function get_perm_id($perm_par) {

        if( is_numeric($perm_par) ) { return $perm_par; }

        $query = $this->gesauth_model->get_perm_id( $perm_par );

		if ($query->num_rows() == 0)
            return false;

        $row = $query->row();
        return $row->id;
    }

     /////   Updated Error Functions   /////

    public function error($message){

        $this->errors[] = $message;
        $this->session->set_userdata('errors_gesauth', $this->errors);
    }

    public function get_errors($divider = '<br />'){
		if(count($this->errors) == 0){
			return false;
		}

    	$msg = '';
    	$msg_num = count($this->errors);
    	$i = 1;
    	foreach ($this->errors as $e) {
    		$msg .= $e;

    		if ($i != $msg_num)
    			$msg .= $divider;

    		$i++;
    	}
    	return $msg;
    }

}

?>