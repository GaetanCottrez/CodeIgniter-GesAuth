<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Groups for Gesauth
 *
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	Users
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license
 * @version    	1.0
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */

include APPPATH.'controllers/tools_crud.php';
class Groups extends Tools_crud {
	protected $table;
	protected $config_vars;
    protected $theme='flexigrid';
	protected $name_class="groups";
	protected $title="";

	function __construct()
	{
		 parent::__construct();

		 $this->config_vars = & $this->config->item('gesauth');

         $this->table = PREFIX.'groups';
		 $this->lang->load($this->name_class);
		 $this->title = $this->lang->line('group_title');

		 $this->load->model('Groups_model');

	}

	public function index()
	{
		 if($this->gesauth->control('menu_groups') == true){
		 	$this->list_groups();
		 }else{
		 	redirect(site_url());
		 }
	}

	public function list_groups()
	{
		$fields = array();
		$relation = 'LEFT JOIN (SELECT group_id, COUNT(group_id) AS NbUse FROM `'.PREFIX.'user_to_group` GROUP BY 1) jb80bb774 ON `jb80bb774`.`group_id` = `'.PREFIX.'groups`.`id`';
		$fields[] = 'jb80bb774.NbUse';
		$jeditable = "!".$this->table.";name;name;text!";
		$array_columns = array('name');
		// On charge le titre de la page
		if($this->title != "") $this->template->set_title($this->title);
		// column
		$this->grocery_crud->set_theme($this->theme)
							 // unset action
							 ->unset_read()
		 					 ->set_table($this->table)
							 ->set_subject($this->lang->line('group_group'))
							 ->columns($array_columns)
							  // DISPLAY AS
							 ->display_as('name',$this->lang->line('group_name'))
							 ->display_as('perms',$this->lang->line('group_perms'))
							 ->display_as('begin_fieldset_identify',$this->lang->line('tools_fieldset_identify'))
		 					 ->display_as('end_fieldset_identify','')
		 					 ->display_as('begin_fieldset_groups',$this->lang->line('tools_fieldset_internal_organisation'))
		 					 ->display_as('end_fieldset_groups','')
		 					 // FIELDS
		 					 ->add_fields('begin_fieldset_identify', 'name', 'begin_fieldset_groups', 'perms', 'end_fieldset_groups', 'CreatedBy', 'CreatedDate', 'ModifiedBy', 'ModifiedDate', 'end_fieldset_identify')
		 					 // EDIT FIELDS
		 					 ->edit_fields('begin_fieldset_identify', 'name', 'begin_fieldset_groups', 'perms', 'end_fieldset_groups', 'ModifiedBy', 'ModifiedDate', 'end_fieldset_identify')
		 					 // REQUIRED FIELDS
		 					 ->required_fields('name')
		 					 // CHANGE FIELD TYPE
		 					 ->change_field_type('name', 'alpha_numeric')
							 ->change_field_type('CreatedBy', 'hidden')
							 ->change_field_type('CreatedDate', 'hidden')
							 ->change_field_type('ModifiedBy', 'hidden')
							 ->change_field_type('ModifiedDate', 'hidden')
							 // SET RULE
							 ->set_rules('name', $this->lang->line('user_name'), 'trim|required|xss_clean')
							 // SET RELATION
							 ->set_relation_n_n('perms', PREFIX.'perm_to_group', PREFIX.'perms', 'group_id', 'perm_id', 'name')
							 // CALLBACK ADD FIELD
							 ->callback_add_field('CreatedBy',array($this,'_createdby_callback'))
 							 ->callback_add_field('CreatedDate',array($this,'_createddate_callback'))
 							 ->callback_add_field('ModifiedBy',array($this,'_modifiedby_callback'))
 							 ->callback_add_field('ModifiedDate',array($this,'_modifieddate_callback'))
 							 ->callback_add_field('begin_fieldset_identify',array($this,'_fake_callback'))
 							 ->callback_add_field('end_fieldset_identify',array($this,'_fake_callback'))
 							 ->callback_add_field('begin_fieldset_groups',array($this,'_fake_callback'))
 							 ->callback_add_field('end_fieldset_groups',array($this,'_fake_callback'))
 							 // CALLBACK EDIT FIELD
							 ->callback_edit_field('begin_fieldset_identify',array($this,'_fake_callback'))
    						 ->callback_edit_field('end_fieldset_identify',array($this,'_fake_callback'))
    						 ->callback_edit_field('ModifiedBy',array($this,'_modifiedby_callback'))
 							 ->callback_edit_field('ModifiedDate',array($this,'_modifieddate_callback'))
 							 ->callback_edit_field('begin_fieldset_groups',array($this,'_fake_callback'))
 							 ->callback_edit_field('end_fieldset_groups',array($this,'_fake_callback'))
 							 // ADD ACTIONS
							 ->add_action('JeditableButton', '', $jeditable, 'jeditable_action')
							 ->add_action('ControlDisplayButton', '', '', 'control_display_action', array($this,'_control_display_action'));
							 // GESAUTH CONTROL
							 // ADD
							 if($this->gesauth->control('create_group') == false){
							 	$this->grocery_crud->unset_add();
							 }
							 // MODIFY
							 if($this->gesauth->control('modify_group') == false){
							 	$this->grocery_crud->unset_edit();
							 }
							 // DELETE
							 if($this->gesauth->control('delete_group') == false){
							 	$this->grocery_crud->unset_delete();
							 }
							 // SET CUSTOM RELATION
			$this->grocery_crud->basic_model->set_custom_relation($relation,$fields);

		 $output = $this->grocery_crud->render();
		 $js['js'][] = 'groups/group';
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