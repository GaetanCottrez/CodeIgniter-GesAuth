<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Roles for Gesauth
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
class Roles extends Tools_crud {
	protected $table;
	protected $config_vars;
    protected $theme='flexigrid';
	protected $name_class="roles";
	protected $array_columns;
	protected $add_fields;
	protected $edit_fields;
	protected $required_fields;
	protected $control_menu="menu_roles";
	protected $control_create="create_role";
	protected $control_modify="modify_role";
	protected $control_delete="delete_role";
	protected $js = 'roles/role';
	protected $title="";

	function __construct()
	{
		 parent::__construct();

		 $this->config_vars = $this->config->item('gesauth');

         $this->table = PREFIX.'roles';
		 $this->lang->load($this->name_class,$this->language);
		 $this->title = $this->lang->line('role_title');

		 $this->load->model('Roles_model');

		 $this->array_columns = array('name');
		 $this->add_fields = array('begin_fieldset_identify', 'name', 'begin_fieldset_roles', 'perms', 'end_fieldset_roles', 'CreatedBy', 'CreatedDate', 'ModifiedBy', 'ModifiedDate', 'end_fieldset_identify');
		 $this->edit_fields = array('begin_fieldset_identify', 'name', 'begin_fieldset_roles', 'perms', 'end_fieldset_roles', 'ModifiedBy', 'ModifiedDate', 'end_fieldset_identify');
		 $this->required_fields = array('name');


	}

	public function index()
	{
		 if($this->gesauth->control($this->control_menu) == true){
		 	$this->list_crud();
		 }else{
		 	redirect(site_url());
		 }
	}

	public function list_crud()
	{
		$fields = array();
		$relation = 'LEFT JOIN (SELECT role_id, COUNT(role_id) AS NbUse FROM `'.PREFIX.'user_to_role` GROUP BY 1) jb80bb774 ON `jb80bb774`.`role_id` = `'.PREFIX.'roles`.`id`';
		$fields[] = 'jb80bb774.NbUse';
		// GESAUTH CONTROL
		// MODIFY
		if($this->gesauth->control($this->control_modify) == true){
			$jeditable = "!".$this->table.";name;name;text!";
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
							 ->set_subject($this->lang->line('role_role'))
							 ->columns($this->array_columns)
							  // DISPLAY AS
							 ->display_as('name',$this->lang->line('role_name'))
							 ->display_as('perms',$this->lang->line('role_perms'))
							 ->display_as('begin_fieldset_identify',$this->lang->line('tools_fieldset_identify'))
		 					 ->display_as('end_fieldset_identify','')
		 					 ->display_as('begin_fieldset_roles',$this->lang->line('tools_fieldset_internal_organisation'))
		 					 ->display_as('end_fieldset_roles','')
		 					 // FIELDS
		 					 ->add_fields($this->add_fields)
		 					 // EDIT FIELDS
		 					 ->edit_fields($this->edit_fields)
		 					 // REQUIRED FIELDS
		 					 ->required_fields($this->required_fields)
		 					 // CHANGE FIELD TYPE
		 					 ->change_field_type('name', 'alpha_numeric')
							 ->change_field_type('CreatedBy', 'hidden')
							 ->change_field_type('CreatedDate', 'hidden')
							 ->change_field_type('ModifiedBy', 'hidden')
							 ->change_field_type('ModifiedDate', 'hidden')
							 // SET RULE
							 ->set_rules('name', $this->lang->line('user_name'), 'trim|required|xss_clean')
							 // SET RELATION
							 ->set_relation_n_n('perms', PREFIX.'perm_to_role', PREFIX.'perms', 'role_id', 'perm_id', 'name')
							 // CALLBACK ADD FIELD
							 ->callback_add_field('CreatedBy',array($this,'_createdby_callback'))
 							 ->callback_add_field('CreatedDate',array($this,'_createddate_callback'))
 							 ->callback_add_field('ModifiedBy',array($this,'_modifiedby_callback'))
 							 ->callback_add_field('ModifiedDate',array($this,'_modifieddate_callback'))
 							 ->callback_add_field('begin_fieldset_identify',array($this,'_fake_callback'))
 							 ->callback_add_field('end_fieldset_identify',array($this,'_fake_callback'))
 							 ->callback_add_field('begin_fieldset_roles',array($this,'_fake_callback'))
 							 ->callback_add_field('end_fieldset_roles',array($this,'_fake_callback'))
 							 // CALLBACK EDIT FIELD
							 ->callback_edit_field('begin_fieldset_identify',array($this,'_fake_callback'))
    						 ->callback_edit_field('end_fieldset_identify',array($this,'_fake_callback'))
    						 ->callback_edit_field('ModifiedBy',array($this,'_modifiedby_callback'))
 							 ->callback_edit_field('ModifiedDate',array($this,'_modifieddate_callback'))
 							 ->callback_edit_field('begin_fieldset_roles',array($this,'_fake_callback'))
 							 ->callback_edit_field('end_fieldset_roles',array($this,'_fake_callback'))
 							 // ADD ACTIONS
							 ->add_action('JeditableButton', '', $jeditable, 'jeditable_action')
							 ->add_action('ControlDisplayButton', '', '', 'control_display_action', array($this,'_control_display_action'));
							 // GESAUTH CONTROL
							 // ADD
							 if($this->gesauth->control($this->control_create) == false){
							 	$this->grocery_crud->unset_add();
							 }
							 // MODIFY
							 if($this->gesauth->control($this->control_modify) == false){
							  	$this->grocery_crud->unset_edit();
							 }
							 // DELETE
							 if($this->gesauth->control($this->control_delete) == false){
							  	$this->grocery_crud->unset_delete();
							 }
							 // SET CUSTOM RELATION
			$this->grocery_crud->basic_model->set_custom_relation($relation,$fields);

		 $output = $this->grocery_crud->render();
		 $js['js'][] = $this->js;
	
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
/* Location: ./application/controllers/roles.php */
?>