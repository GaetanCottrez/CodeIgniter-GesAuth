<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library GesAuth
 *
 * A Codeigniter library authentification based on Aauth.
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license GNU GENERAL PUBLIC LICENSE
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.0
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */


//last activity check email
class Gesauth {

    public $CI;
    private $config_vars;
    public $errors = array();
    public $infos = array();
    public $file_language = 'gesauth';
    public $gesauth_model;

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

        //language/french/gesauth_lang.php
        $this->CI->lang->load($this->file_language);
    }

    // open sessions
    public function login($id, $pass, $remember = FALSE) {

        // remove cookies first
        setcookie("user", "", time()-3600, '/');

        if( !ctype_alnum($pass) or strlen($pass) < 5 or strlen($pass) > $this->config_vars['max'] ) {
            $this->error($this->CI->lang->line('gesauth_wrong'));
            return false;
        }

        $query = $this->gesauth_model->get_user($id);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            if ( $this->config_vars['dos_protection'] and $row->last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($row->last_login_attempt) ) {
                $this->error($this->CI->lang->line('gesauth_exceeded'));
                return false;
            }
        }

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

            $this->CI->session->set_userdata($data);

            // id remember selected
            if ($remember){
                $expire = $this->config_vars['remember'];
                $today = date("Y-m-d");
                $remember_date = date("Y-m-d", strtotime($today . $expire) );
                $random_string = random_string('alnum', 16);
                $this->update_remember($row->id, $random_string, $remember_date );

                setcookie( 'user', $row->id . "-" . $random_string, time() + 99*999*999, '/');
            }

            // Get group user and built session groups
            $query = $this->gesauth_model->get_user_groups($id);
            if ($query->num_rows() > 0) {
            	$data = array();
            	foreach ($query->result() as $row)
            	{
            		$data[] = array(
		                'id' => $row->id,
		                'name' => $row->name
		            );
            	}
            	$this->CI->session->set_userdata($this->config_vars['prefix_session'].'groups',$data);

            }
            // update last login
            $this->update_last_login($row->id);
            $this->update_activity();

            return TRUE;

        } else {

            $query = $this->gesauth_model->get_user($id);

            $row = $query->row();

            if ($query->num_rows() > 0) {

                if ( $row->last_login_attempt == null or  (strtotime("now") - 600) > strtotime($row->last_login_attempt) )
                {
                    $data = array(
                        'last_login_attempt' =>  date("Y-m-d H:i:s")
                    );

                } else if (!($row->last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($row->last_login_attempt))) {

                    $newtimestamp = strtotime("$row->last_login_attempt + 30 seconds");
                    $data = array(
                        'last_login_attempt' =>  date( 'Y-m-d H:i:s', $newtimestamp )
                    );
                }

                $query = $this->gesauth_model->update_user($id,$data);
            }

            $this->error($this->CI->lang->line('gesauth_wrong'));
            return FALSE;
        }
    }

    // checks if user logged in
    // also checks remember
    public function is_loggedin() {

        if($this->CI->session->userdata($this->config_vars['prefix_session'].'loggedin'))
        {return true;}

        else{
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

    // most important function. it controls if a logged or public user has permiision
    // if no permission, it stops script
    // it also updates last activity every time function called
    // if perm_par is not given just control user logged in or not
    public function control($perm_par = false){

        if(!$perm_par and !$this->is_loggedin()){
            if($this->config_vars['display_no_access'] == true){
            	echo $this->CI->lang->line('gesauth_no_access');
                die();
            }else{
        		return false;
        	}
        }

        $this->update_activity();

        if( !$this->is_allowed(false, $perm_par) ) {
        	if($this->config_vars['display_no_access'] == true){
            	echo $this->CI->lang->line('gesauth_no_access');
                die();
        	}else{
        		return false;
        	}
        }

        return true;

    }

    // do logout
    public function logout() {

        return $this->CI->session->sess_destroy();
    }

    //do login with id
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

            $this->CI->session->set_userdata($data);
        }
    }

    // check if user disabled, return false if disabled or not found user
    public function is_disabled($user_id) {

        $query = $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->where('disabled', 1);

        $query = $this->CI->db->get($this->config_vars['users']);

        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    // updates user's last activity date
    public function update_activity($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->CI->session->userdata($this->config_vars['prefix_session'].'id');

        if($user_id==false){return false;}

        $data['last_activity'] = date("Y-m-d H:i:s");
		$query = $this->CI->db->where('id',$user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // updates last login date and time
    public function update_last_login($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->CI->session->userdata($this->config_vars['prefix_session'].'id');

        $data['last_login'] = date("Y-m-d H:i:s");

        $this->CI->db->where('id', $user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // updates remember time
    public function update_remember($user_id, $expression=null, $expire=null) {

        $data['remember_time'] = $expire;
        $data['remember_exp'] = $expression;

        $query = $this->CI->db->where('id',$user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }


    // group_name or group_id
    public function is_member($group_par) {

        $user_id = $this->CI->session->userdata($this->config_vars['prefix_session'].'id');

        $this->get_group_id($group_par);
        // group_id given
        if (is_numeric($group_par)) {

            $query = $this->CI->db->where('user_id', $user_id);
            $query = $this->CI->db->where('group_id', $group_par);
            $query = $this->CI->db->get($this->config_vars['user_to_group']);

            $row = $query->row();

            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        // group_name given
        else {

            $query = $this->CI->db->where('name', $group_par);
            $query = $this->CI->db->get($this->config_vars['groups']);

            if ($query->num_rows() == 0)
                return FALSE;

            $row = $query->row();
            return $this->is_member($row->id);
        }
    }

    public function is_admin() {
        return $this->is_member($this->config_vars['admin_group']);
    }

    public function get_group_name($group_id) {

        $query = $this->CI->db->where('id', $group_id);
        $query = $this->CI->db->get($this->config_vars['groups']);

        if ($query->num_rows() == 0)
            return FALSE;

        $row = $query->row();
        return $row->name;
    }

    // takes group paramater (id or name) and returns group id.
    public function get_group_id($group_par) {

        if( is_numeric($group_par) ) { return $group_par; }

        $query = $this->CI->db->where('name', $group_par);
        $query = $this->CI->db->get($this->config_vars['groups']);

        if ($query->num_rows() == 0)
            return FALSE;

        $row = $query->row();
        return $row->id;
    }

    // checks if a group has permitions for given permition
    // if group paramater is empty function checks all groups of current user
    // admin authorized for anything
    public function is_allowed($group_par=false, $perm_par){

        $perm_id = $this->get_perm_id($perm_par);

        if($group_par != false){

            $group_par = $this->get_group_id($group_par);

            $query = $this->CI->db->where('perm_id', $perm_id);
            $query = $this->CI->db->where('group_id', $group_par);
            $query = $this->CI->db->get( $this->config_vars['perm_to_group'] );

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

            $query = $this->gesauth_model->get_user_groups( $this->CI->session->userdata($this->config_vars['prefix_session'].'id') );
			foreach ($query->result() as $g ){
				 if($this->is_allowed($g -> id, $perm_id)){
                    return true;
                }
            }


            return false;
        }

    }

    // adds a group to permission table
    public function allow($group_par, $perm_par) {

        $perm_id = $this->get_perm_id($perm_par);

        $query = $this->CI->db->where('group_id',$group_par);
        $query = $this->CI->db->where('perm_id',$perm_id);
        $query = $this->CI->db->get($this->config_vars['perm_to_group']);

        if ($query->num_rows() < 1) {

            $group_par = $this->get_group_id($group_par);
            $data = array(
                'group_id' => $group_par,
                'perm_id' => $perm_id
            );

            return $this->CI->db->insert($this->config_vars['perm_to_group'], $data);
        }
        return true;
    }

    // deny or disallow a group for spesific permition
    // a group which not allowed is already denied.
    public function deny($group_par, $perm_par) {

        $perm_id = $this->get_perm_id($perm_par);

        $group_par = $this->get_group_id($group_par);
        $this->CI->db->where('group_id', $group_par);
        $this->CI->db->where('perm_id', $perm_id);

        return $this->CI->db->delete($this->config_vars['perm_to_group']);
    }

    public function get_perm_id($perm_par) {

        if( is_numeric($perm_par) ) { return $perm_par; }

        $query = $this->CI->db->where('definition', $perm_par);
        $query = $this->CI->db->get($this->config_vars['perms']);

        if ($query->num_rows() == 0)
            return false;

        $row = $query->row();
        return $row->id;
    }

     /////   Updated Error Functions   /////

    public function error($message){

        $this->errors[] = $message;
        $this->CI->session->set_flashdata('errors', $this->errors);
    }

    public function get_errors_array(){

        if (!count($this->errors)==0){
            return $this->errors;
        } else {
            return false;
        }
    }

    public function get_errors($divider = '<br />'){

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

    public function info($message){

        $this->infos[] = $message;
        $this->CI->session->set_flashdata('infos', $this->errors);
    }

    public function get_infos_array(){

        if (!count($this->infos)==0){
            return $this->infos;
        } else {
            return false;
        }
    }

    public function get_infos($divider = '<br />'){

        $msg = '';
        $msg_num = count($this->infos);
        $i = 1;
        foreach ($this->infos as $e) {
            $msg .= $e;

            if ($i != $msg_num)
                $msg .= $divider;

            $i++;
        }
        return $msg;
    }

}

?>