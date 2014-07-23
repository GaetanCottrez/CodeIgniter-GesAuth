<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Users for Gesauth
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

include APPPATH.'controllers/tools_crud.php';
class Users extends Tools_crud {
	protected $table;
	protected $config_vars;
    protected $theme='flexigrid';
	protected $name_class="users";
	protected $title="";

	function __construct()
	{
		 parent::__construct();

		 $this->config_vars = & $this->config->item('gesauth');

         $this->table = PREFIX.'users';
		 $this->lang->load($this->name_class,$this->language);
		 $this->title = $this->lang->line('user_title');

		 $this->load->model('Users_model');

	}

	public function index()
	{
		 if($this->gesauth->control('menu_users') == true){
			$this->list_users();
		 }else{
		 	redirect(site_url());
		 }
	}

	public function list_users()
	{
		// List languages
		$jeditable_language = '';
		$query = $this->Users_model->get_list_languages();

		foreach ($query->result() as $row)
		{
		    $jeditable_language .= "'".$row->id." ".$row->name."':'".$row->name."', ";
		}

		$jeditable_language = "{".substr($jeditable_language,0,-2)."}";

		// List disabled
		$jeditable_disabled = $this->_jeditable_bool();

		$fields = array();
		$relation = 'LEFT JOIN (SELECT user_id, COUNT(user_id) AS NbUse FROM `'.PREFIX.'user_to_role` GROUP BY 1) jb80bb774 ON `jb80bb774`.`user_id` = `'.PREFIX.'users`.`id`';
		$fields[] = 'jb80bb774.NbUse';
		$array_columns = array('id', 'email', 'name', 'firstname', 'disabled', 'last_login', 'last_activity', 'language');
		// GESAUTH CONTROL
		// MODIFY
		if($this->gesauth->control('modify_user') == true){
			$jeditable = "!".$this->table.";email;email;text;unique|".$this->table.";name;name;text|".$this->table.";firstname;firstname;text|".$this->table.";disabled;disabled;select;".$jeditable_disabled."|".$this->table.";language;s8512ae7d;select;".$jeditable_language."!";
		}else{
			$jeditable = '!|!';
		}
		// On charge le titre de la page
		if($this->title != "") $this->template->set_title($this->title);
		// column
		$this->grocery_crud->set_theme($this->theme)
							 // unset action
							 ->unset_read()
		 					 ->set_table($this->table)
							 ->set_subject($this->lang->line('user_user'))
							 ->columns($array_columns)
							  // DISPLAY AS
							 ->display_as('id',$this->lang->line('user_login'))
							 ->display_as('roles',$this->lang->line('user_roles'))
							 ->display_as('password',$this->lang->line('user_password'))
		 					 ->display_as('verify_password',$this->lang->line('user_password_confirm'))
		 					 ->display_as('password_edit',$this->lang->line('user_password'))
		 					 ->display_as('verify_password_edit',$this->lang->line('user_password_confirm'))
		 					 ->display_as('email',$this->lang->line('user_email'))
							 ->display_as('name',$this->lang->line('user_name'))
							 ->display_as('firstname',$this->lang->line('user_firstname'))
							 ->display_as('disabled',$this->lang->line('user_disable'))
		 					 ->display_as('last_login',$this->lang->line('user_last_login'))
		 					 ->display_as('last_activity',$this->lang->line('user_last_activity'))
		 					 ->display_as('language',$this->lang->line('user_language'))
		 					 ->display_as('begin_fieldset_identify',$this->lang->line('tools_fieldset_identify'))
		 					 ->display_as('end_fieldset_identify','')
		 					 ->display_as('begin_fieldset_roles',$this->lang->line('tools_fieldset_internal_organisation'))
		 					 ->display_as('end_fieldset_roles','')
		 					 // FIELDS
		 					 ->add_fields('begin_fieldset_identify', 'id', 'name', 'firstname', 'password','verify_password', 'email', 'language', 'end_fieldset_identify', 'begin_fieldset_roles', 'roles', 'end_fieldset_roles')
		 					 // EDIT FIELDS
		 					 ->edit_fields('begin_fieldset_identify','id', 'name', 'firstname', 'password','verify_password', 'email', 'disabled', 'language', 'end_fieldset_identify', 'begin_fieldset_roles', 'roles', 'end_fieldset_roles')
		 					 // REQUIRED FIELDS
		 					 ->required_fields('email', 'name', 'firstname', 'password', 'verify_password','language', 'roles')
		 					 // CHANGE FIELD TYPE
		 					 ->change_field_type('email', 'alpha_numeric')
							 ->change_field_type('name', 'alpha_numeric')
							 ->change_field_type('firstname', 'alpha_numeric')
							 ->change_field_type('password', 'password')
							 ->change_field_type('verify_password', 'password')
							 ->change_field_type('password_edit', 'password')
							 ->change_field_type('verify_password_edit', 'password')
							 ->change_field_type('disabled', 'true_false')
							 // SET RULE
							 ->set_rules('id', $this->lang->line('user_login'), 'trim|xss_clean|callback__check_unique_user')
							 ->set_rules('name', $this->lang->line('user_name'), 'trim|required|xss_clean')
							 ->set_rules('firstname', $this->lang->line('user_firstname'), 'trim|required|xss_clean')
							 ->set_rules('password', $this->lang->line('user_password'), 'trim|callback_is_require_custom|matches[verify_password]|xss_clean')
							 ->set_rules('verify_password', $this->lang->line('user_password_confirm'), 'trim|callback__is_require_custom|xss_clean')
							 ->set_rules('password_edit', $this->lang->line('user_password'), 'trim|matches[verify_password_edit]|xss_clean')
							 ->set_rules('verify_password_edit', $this->lang->line('user_password_confirm'), 'trim|xss_clean')
							 ->set_rules('email', $this->lang->line('user_email'), 'trim|required|valid_email|callback__check_unique_email|xss_clean')
							 // SET RELATION
							 ->set_relation('language',PREFIX.'languages','Name')
							 ->set_relation_n_n('roles', PREFIX.'user_to_role', PREFIX.'roles', 'user_id', 'role_id', 'name')
							 //->set_relation('id',PREFIX.'user_to_role','user_id')
							 // CALLBACK ADD FIELD
							 ->callback_add_field('password',array($this,'_set_password_input_to_empty'))
 							 ->callback_add_field('verify_password',array($this,'_set_verify_password_input_to_empty'))
 							 ->callback_add_field('begin_fieldset_identify',array($this,'_fake_callback'))
 							 ->callback_add_field('end_fieldset_identify',array($this,'_fake_callback'))
 							 ->callback_add_field('begin_fieldset_roles',array($this,'_fake_callback'))
 							 ->callback_add_field('end_fieldset_roles',array($this,'_fake_callback'))
 							 ->callback_add_field('id',array($this,'_custom_field_id_user'))
 							 // CALLBACK EDIT FIELD
							 ->callback_edit_field('password',array($this,'_set_password_input_to_empty'))
    						 ->callback_edit_field('verify_password',array($this,'_set_verify_password_input_to_empty'))
 							 ->callback_edit_field('begin_fieldset_identify',array($this,'_fake_callback'))
    						 ->callback_edit_field('end_fieldset_identify',array($this,'_fake_callback'))
    						 ->callback_edit_field('begin_fieldset_roles',array($this,'_fake_callback'))
 							 ->callback_edit_field('end_fieldset_roles',array($this,'_fake_callback'))
 							 ->callback_edit_field('id',array($this,'_just_display_value_callback'))
 							 // CALLBACK BEFORE UPDATE
							 ->callback_before_update(array($this,'_encrypt_password_callback'))
							 // CALLBACK BEFORE INSERT
							 ->callback_before_insert(array($this,'_encrypt_password_callback'))
							 // ADD ACTIONS
							 ->add_action('ControlDisplayButton', '', '', 'control_display_action', array($this,'_control_display_action'))
							 ->add_action('JeditableButton', '', $jeditable, 'jeditable_action');
							 // GESAUTH CONTROL
							 // ADD
							 if($this->gesauth->control('create_user') == false){
							 	$this->grocery_crud->unset_add();
							 }
							 // MODIFY
							 if($this->gesauth->control('modify_user') == false){
							  	$this->grocery_crud->unset_edit();
							 }
							 // DELETE
							 if($this->gesauth->control('delete_user') == false){
							  	$this->grocery_crud->unset_delete();
							 }
							 // SET CUSTOM RELATION
			$this->grocery_crud->basic_model->set_custom_relation($relation,$fields);

		 $output = $this->grocery_crud->render();
		 $js['js'][] = 'users/user';
		 $this->_enjoy($this->view,$output,$js);
	}

	/*
	 * Function for display button delete
	 */
	function _control_display_action($primary_key , $row)
	{
		if($row->NbUse > 0) return 'delete_'.str_replace('.','_',$row->id);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/user.php */
?>