<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Models GesAuth
 *
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

class gesauth_model extends CI_Model
{
	public $CI;
    public $config_vars;
    public $errors = array();
    public $infos = array();
    public $file_language = 'gesauth';

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
        $this->config_vars = & $this->CI->config->item('gesauth');
    }

    /**
	 *	Get information user.
	 *
	 *	@param string $id 	id of table user
	 *	@return object		result of request
	 */
	public function get_user($id)
	{
		 return $this->CI->db->where('id', $id)
         					 ->get($this->config_vars['users']);
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
	public function login_user($id,$password='',$fast=FALSE)
	{
		 $this->CI->db->select($this->config_vars['users'].'.`id`, '.$this->config_vars['users'].'.`email`, '.$this->config_vars['users'].'.`name`,
		 '.$this->config_vars['users'].'.`firstname`, '.$this->config_vars['users'].'.`disabled`, '.$this->config_vars['languages'].'.value AS `language`,
		 '.$this->config_vars['users'].'.`last_login`')
		 			  ->join($this->config_vars['languages'], $this->config_vars['join_users_languages'])
		 			  ->where($this->config_vars['users'].'.id', $id);
		 if($fast == FALSE) $this->CI->db->where('password', sha1($this->config_vars['gesauth_salt'].$password));
		 return $this->CI->db->where('disabled', 0)
							 ->get($this->config_vars['users']);
	}

	/**
	 *	update information user.
	 *
	 *	@param string $id 	id of table user
	 *	@param array $data 	table data user
	 *	@return object		result of request
	 */
	public function update_user($id,$data)
	{
		$this->CI->db->where('id', $id)
					 ->update($this->config_vars['users'], $data);
	}


	/**
	 *	Get groups by user.
	 *
	 *	@param string $user_id 	id of table user
	 *	@return object		result of request
	 */
	public function get_user_groups($user_id = false){

		if ($user_id==false) { $user_id = $this->CI->session->userdata($this->config_vars['prefix_session'].'id'); }

		return $this->CI->db->select('id, name')
							->from($this->config_vars['user_to_group'])
							->join($this->config_vars['groups'], "id = group_id")
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
	 *	@param array $user_id is the id user
	 *	@return object		result of request
	 */
	public function is_disabled($user_id) {

		return $this->CI->db->where('id', $user_id)
							->where('disabled', 1)
							->get($this->config_vars['users']);
	}

	/**
	 *	takes group paramater (id or name) and returns group id.
	 *
	 *	@param array $group_par is the id or name group
	 *	@return object		result of request
	 */
	public function get_group_id($group_par) {

		return $this->CI->db->where('name', $group_par)
							  ->get($this->config_vars['groups']);

	}

	/**
	 *	Clean session close browser in databases
	 *
	 *	@param array $timestamp is the timestamp for the last_activity
	 */
	public function clean_session_user_agent_close($timestamp) {

		$this->CI->db->where("last_activity < ", $timestamp)
					 ->like("user_data",'"user_agent_close";i:1')
					 ->delete($this->CI->session->sess_table_name);

	}

	/**
	 *	Clean session close browser in databases
	 *
	 *	@return object		result of request
	 */
	public function get_session_in_db() {

		return $this->CI->db->where('session_id', $this->CI->session->userdata('session_id'))
						   ->get($this->CI->session->sess_table_name);

	}

	/**
	 *	check user is member to group
	 *
	 *	@param array $user_id is the id user
	 *	@param array $group_par is the id or name group
	 *	@return object		result of request
	 */
	public function check_user_is_member($user_id, $group_par) {

		return $this->CI->db->where('user_id', $user_id)
							->where('group_id', $group_par)
						  	->get($this->config_vars['user_to_group']);

	}

	/**
	 *	check perm affected to group
	 *
	 *	@param array $perm_id is the id perm
	 *	@param array $group_par is the id or name group
	 *	@return object		result of request
	 */
	public function check_perm_affected_to_group($perm_id, $group_par) {

		return $this->CI->db->where('perm_id', $perm_id)
							->where('group_id', $group_par)
							->get( $this->config_vars['perm_to_group'] );

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

		return $this->CI->db->where("session_id != ", $session_id)
							->where("user_data LIKE ", '%"user_id";s:'.strlen($user_id).':"'.$user_id.'"%')
							->update($this->CI->session->sess_table_name, $data);

	}

}


/* End of file gesauth_model.php */
/* Location: ./application/models/gesauth_model.php */