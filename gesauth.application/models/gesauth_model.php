<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Models GesAuth
 *
 *
 * Copyright (C) 2014-2015 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014-2015, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	2.0
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */

class gesauth_model extends CI_Model
{
	private $CI;
    private $config_vars;
    private $errors = array();
    private $infos = array();
    private $file_language = 'gesauth';
    private $name_table_session;
	private $last_activity;
	private $user_data;
	private $session_id;


	public function __construct() {

        // delete all errors at first :)
        $this->errors = array();

        $this->CI = & get_instance();

        // config/gesauth.php
        $this->CI->config->load('gesauth');

        //language/french/gesauth_lang.php
        $this->CI->lang->load($this->file_language);


        // the array which came from gesauth config file
        // $this->config_vars
        $this->config_vars = $this->CI->config->item('gesauth');
       
        switch(substr(CI_VERSION,0,1)){
        	case 3:
        		$this->name_table_session = $this->CI->config->item('sess_save_path');
        		$this->last_activity = 'timestamp';
        		$this->user_data = 'data';
        		$this->session_id = 'id';
        	break;

        	case 2:
        		$this->name_table_session = $this->CI->config->item('sess_table_name');
        		$this->last_activity = 'last_activity';
        		$this->user_data = 'user_data';
        		$this->session_id = 'session_id';
        	break;
        
        }
    }

    /**
	 *	Get information user.
	 *
	 *	@param string $login 	login of table user
	 *	@return object		result of request
	 */
	public function get_user($login)
	{
		 return $this->CI->db->select($this->config_vars['users'].'.*, '.$this->config_vars['languages'].'.value AS `value_language`')
							 ->from($this->config_vars['users'])
						     ->join($this->config_vars['languages'], $this->config_vars['join_users_languages'])
						     ->where($this->config_vars['users'].'.login', $login)
						     ->get();
	}

	/**
	 *	Get information user.
	 *	by id and remember_exp
	 *
	 *	@param string $id 	id of table user
	 *	@param string $password 	password of table user
	 *	@return object		result of request
	 */
	public function get_user_by_id_and_remember_exp($id,$remember_exp)
	{
		 return $this->CI->db->where('id', $id)
		 					 ->where('remember_exp', $remember_exp)
		 					 ->get($this->config_vars['users']);

	}

	/**
	 *	Get information user.
	 *	security password is sha1 and salt concatenate
	 *
	 *	@param string $id 	id of table user
	 *	@param string $password 	password of table user
	 *	@return object		result of request
	 */
	public function login_user($login,$password='',$fast=FALSE)
	{
		 $this->CI->db->select($this->config_vars['users'].'.`id`, '.$this->config_vars['users'].'.`email`, '.$this->config_vars['users'].'.`name`,
		 '.$this->config_vars['users'].'.`firstname`, '.$this->config_vars['users'].'.`disabled`, '.$this->config_vars['languages'].'.value AS `language`,
		 '.$this->config_vars['users'].'.`last_login`')
		 ->join($this->config_vars['languages'], $this->config_vars['join_users_languages']);
		 if($this->config_vars['authentification_by_email']){
			$this->CI->db->where('('.$this->config_vars['users'].'.login = "'.$login.'" OR '.$this->config_vars['users'].'.email = "'.$login.'")');
		 }else{
			$this->CI->db->where($this->config_vars['users'].'.login', $login);
		 }
		 if($fast == FALSE) $this->CI->db->where('password', sha1($this->config_vars['gesauth_salt'].$password));
		 return $this->CI->db->where('disabled', 0)
							 ->get($this->config_vars['users']);
	}

	/**
	 *	update information user.
	 *
	 *	@param string $id_user 	id of table user
	 *	@param array $data 	table data user
	 *	@return object		result of request
	 */
	public function update_user($id_user,$data)
	{
		$this->CI->db->where('id', $id_user)
					 ->update($this->config_vars['users'], $data);
	}


	/**
	 *	Get roles by user.
	 *
	 *	@param string $user_id 	id of table user
	 *	@return object		result of request
	 */
	public function get_user_roles($user_id = false){

		if ($user_id==false) { $user_id = $this->CI->session->userdata($this->config_vars['prefix_session'].'id'); }

		return $this->CI->db->select('id, name')
							->from($this->config_vars['user_to_role'])
							->join($this->config_vars['roles'], "id = role_id")
							->where('user_id', $user_id)
							->get();
	}

	/**
	 *	insert logs authentification.
	 *
	 *	@param array $data 	table data user
	 */
	public function insert_logs_authentification($data)
	{
		$this->CI->db->insert($this->config_vars['logs_authentification'], $data);
	}

	/**
	 *	insert logs perms.
	 *
	 *	@param array $data 	table data user
	 */
	public function insert_logs_perms($data)
	{
		$this->CI->db->insert($this->config_vars['logs_perms'], $data);
	}

	/**
	 *	check if user disabled, return false if disabled or not found user
	 *
	 *	@param array $login is the login user
	 *	@return object		result of request
	 */
	public function is_disabled($login) {

		return $this->CI->db->where('login', $login)
							->where('disabled', 1)
							->get($this->config_vars['users']);
	}

	/**
	 *	takes role paramater (id or name) and returns role id.
	 *
	 *	@param array $role_par is the id or name role
	 *	@return object		result of request
	 */
	public function get_role_id($role_par) {

		return $this->CI->db->where('name', $role_par)
							  ->get($this->config_vars['roles']);

	}

	/**
	 *	Clean session close browser in databases
	 *
	 *	@param array $timestamp is the timestamp for the last_activity
	 */
	public function clean_session_user_agent_close($timestamp) {

		$this->CI->db->where($this->last_activity." < ", $timestamp)
					 ->like($this->user_data,'"user_agent_close";i:1')
					 ->delete($this->name_table_session);

	}

	/**
	 *	Clean session close browser in databases
	 *
	 *	@param array $timestamp is the timestamp for the last_activity
	 */
	public function clean_session_for_expiration($timestamp, $data) {

		$this->CI->db->where($this->last_activity." < ", $timestamp)
					 ->update($this->name_table_session, $data);

	//	echo $this->CI->db->last_query();

	}
	
	/**
	 *	Clean old session
	 *
	 *	@param array $timestamp is the timestamp for the last_activity
	 */
	public function clean_old_session($timestamp) {
	
		$this->CI->db->where($this->last_activity." < ", $timestamp)
		->delete($this->name_table_session);
	}

	/**
	 *	Clean session close browser in databases
	 *
	 *	@return object		result of request
	 */
	public function get_session_in_db() {

		return $this->CI->db->where($this->session_id, $this->CI->session->userdata($this->session_id))
						   ->get($this->name_table_session);

	}

	/**
	 *	check user is member to role
	 *
	 *	@param array $user_id is the id user
	 *	@param array $role_par is the id or name role
	 *	@return object		result of request
	 */
	public function check_user_is_member($user_id, $role_par) {

		return $this->CI->db->where('user_id', $user_id)
							->where('role_id', $role_par)
						  	->get($this->config_vars['user_to_role']);

	}

	/**
	 *	check perm affected to role
	 *
	 *	@param array $perm_id is the id perm
	 *	@param array $role_par is the id or name role
	 *	@return object		result of request
	 */
	public function check_perm_affected_to_role($perm_id, $role_par) {

		return $this->CI->db->where('perm_id', $perm_id)
							->where('role_id', $role_par)
							->get( $this->config_vars['perm_to_role'] );

	}

	/**
	 *	get perm id
	 *
	 *	@param array $perm_par is the definition perm
	 *	@return object		result of request
	 */
	public function get_perm_id($perm_par) {

		return $this->CI->db->where('definition', $perm_par)
									 ->get($this->config_vars['perms']);

	}

	/**
	 *	Clean session close browser in databases
	 *
	 *	@return object		result of request
	 */
	public function disconnect_session($data, $user_id, $session_id) {

		return $this->CI->db->where($this->session_id." != ", $session_id)
							->where($this->user_data." LIKE ", '%"user_id";s:'.strlen($user_id).':"'.$user_id.'"%')
							->update($this->name_table_session, $data);

	}

}


/* End of file gesauth_model.php */
/* Location: ./application/models/gesauth_model.php */