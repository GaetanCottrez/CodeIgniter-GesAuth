<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tools Crud for GesAuth, controllers parent for all crud
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	grocery CRUD
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 *
 *
 */

//include APPPATH.'ressources/ssp.php';
include APPPATH.'controllers/tools_template.php';
class Tools_crud extends Tools_template {
	protected $table;
	protected $config_vars;
	protected $theme;
	protected $name_class="";
	protected $title="";
	protected $view;
	protected $language;

	function __construct()
	{
		parent::__construct();

		$this->load->library('grocery_CRUD');
		$this->grocery_crud->set_model('custom_query_crud_model');
		$this->config_vars = & $this->config->item('gesauth');
		$this->language = $this->session->userdata($this->config_vars['prefix_session'].'language');
        $this->grocery_crud->set_language($this->language);
		$this->lang->load('tools_crud',$this->language);
		$this->theme = 'gesauth';
		$this->view = 'gesauth/list';
	}

	/*
	|===============================================================================
	| Méthode commune pour tous les crud
	|	. ajax_server_side_list
	|	. _apply_js
	|	. _fake_callback
	|	. _enjoy
	|	. _just_display_value_callback
	|	. _jeditable_bool
	|	. jeditable_ajax
	|	. _just_display_value_callback
	|===============================================================================
	*/
	/*function ajax_server_side_list(){
		/*
		 * DataTables example server-side processing script.
		*
		* Please note that this script is intentionally extremely simply to show how
		* server-side processing can be implemented, and probably shouldn't be used as
		* the basis for a large complex system. It is suitable for simple use cases as
		* for learning.
		*
		* See http://datatables.net/usage/server-side for full details on the server-
		* side processing requirements of DataTables.
		*
		* @license MIT - http://datatables.net/license_mit
		*/

		// Table's primary key
		/*$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		$columns = array();
		foreach ($this->array_columns as $key){
			$columns[] = array( 'db' => $key, 'dt' => $key );
		}

		// SQL server connection information
		$sql_details = array(
				'user' => $this->db->username,
				'pass' => $this->db->password,
				'db'   => $this->db->database,
				'host' => $this->db->hostname
		);


		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP
		* server-side, there is no need to edit below this line.
		*/
		/*log_message('info','ajax_server_side_list');
		echo str_replace("'"," ",json_encode(
				SSP::simple( $_POST, $sql_details, $this->table, $primaryKey, $columns ))
		);
	}*/

	function _apply_js($js=null){
		$action = $this->uri->segment(3);
		if($action == null) $action='list';
		for($i=0;$i<count($js['js']);$i++) $js['js'][$i] = js_url($js['js'][$i].$action);
		if($js != null) $this->load->view('include_js',$js);
	}

	function _fake_callback(){

	}

	function _method_created_callback($value = null, $primary_key){
		return '<input id="field-method_created" name="method_created" type="hidden" value="CRUD_ADD">';
	}

 	function _method_modified_callback($value = null, $primary_key){
		return '<input id="field-method_modified" name="method_modified" type="hidden" value="CRUD_EDIT">';
	}

 	function _createdby_callback($value = null, $primary_key){
		return '<input id="field-CreatedBy" name="CreatedBy" type="hidden" value="'.$this->session->userdata($this->config_vars['prefix_session'].'id').'">';
	}

 	function _modifiedby_callback($value = null, $primary_key){
		return '<input id="field-ModifiedBy" name="ModifiedBy" type="hidden" value="'.$this->session->userdata($this->config_vars['prefix_session'].'id').'">';
	}

 	function _createddate_callback($value = null, $primary_key){
		return '<input id="field-CreatedDate" name="CreatedDate" type="hidden" value="'.date('Y-m-d H:i:s').'">';
	}

 	function _modifieddate_callback($value = null, $primary_key){
		return '<input id="field-ModifiedDate" name="ModifiedDate" type="hidden" value="'.date('Y-m-d H:i:s').'">';
	}

	function _enjoy($view=null, $output = null, $js = null)
	{
		$this->template->view($view,$output);
		if($js != null) $this->_apply_js($js);
	}

	function _just_display_value_callback($value = null, $primary_key){
		return '<b>'.$value.'</b>';
	}

	function _jeditable_bool(){
		return "{'0 ".$this->lang->line('tools_crud_no')."':'".$this->lang->line('tools_crud_no')."', '1 ".$this->lang->line('tools_crud_yes')."':'".$this->lang->line('tools_crud_yes')."' }";
	}

	function jeditable_ajax(){
		$id = $this->input->post('row_id');
		$value = $this->input->post('value');
		$extra = array();
		$field = null;
		$type_field = null;
		$segs = $this->uri->segment_array();
		$table = null;
		$countseg = 0;

		foreach ($segs as $segment)
		{
			$countseg++;
			switch($countseg){
				// tools_crud
				case 1:
				// jeditable_ajax
				case 2:

					break;
				// table
				case 3:
					$table = $segment;
					break;
				// field table
				case 4:
					$field = $segment;
					break;
				// type field table
				case 5:
					$type_field = $segment;
					switch($type_field){
						case 'select':
							$tab = explode(' ',$value);
							$value = $tab[0];
							$display_value = $tab[1];
							break;

						default:
							$display_value = $value;
					}
					break;
				// extra apply this field
				default:
					$extra[] = $segment;
			}
		}

		$data = array(
				$field =>  $value
		);
		$this->grocery_crud->basic_model->update_jeditable($table,$id,$data);

		$data = array(
				'value' =>  $display_value
		);

		$this->load->view('jeditable/jeditable',$data);
	}



	/*
	|===============================================================================
	| Méthode spécifique pour les différents crud existant
	|	. _encrypt_password_callback => user,
	|	. is_require_custom => user,
	|	. _set_password_input_to_empty => user,
	|	. _set_verify_password_input_to_empty => user,
	|	. _custom_field_id_user => user,
	|	. _check_unique_user => user,
	|	. _check_unique_email => user,
	|===============================================================================
	*/

	function _encrypt_password_callback($post_array= array(), $primary_key= null) {
		$this->config->load('gesauth');
		$config_vars = & $this->config->item('gesauth');
		//Encrypt password only if is not empty. Else don't change the password to an empty field
			if(!empty($post_array['password']) && !empty($post_array['verify_password']) && ($post_array['password'] == $post_array['verify_password']))
			{
				if(isset($post_array['password_display'])){
					$post_array['password_display'] = $this->encrypt->encode($post_array['password']);
				}
				$key = $config_vars['gesauth_salt'];
				$post_array['password'] = sha1($key.$post_array['password']);
				unset($post_array['verify_password']);
			}
			else
			{
				$action = $this->uri->segment(3);
				if($action == 'update_validation' && $action != 'update'){
					$table = $this->uri->segment(1);
					$id = $this->uri->segment(4);
					$query = $this->db->where('id', $id)->get(PREFIX.$table);
					$row = $query->row();
					$post_array['password'] = $row->password;
					unset($post_array['verify_password']);
				}else{
					unset($post_array['password']);
					unset($post_array['verify_password']);
				}
			}


		return $post_array;
	}

	function is_require_custom($str){
		$action = $this->uri->segment(3);
		if($action != 'update_validation' && $action != 'update')
		{
			if ($str == '')
			{
				$this->form_validation->set_message('is_require_custom', $this->lang->line('tools_is_require'));
				return FALSE;
			}
			else
			{
				return TRUE;
			}

		}else{
			return TRUE;
		}
	}

	function _set_password_input_to_empty() {
		$action = $this->uri->segment(3);
		if($action != 'read')
			return "<input type='password' id='field-password' name='password' value='' />";
		else
			return "&nbsp;";
	}

	function _set_verify_password_input_to_empty() {
		$action = $this->uri->segment(3);
		if($action != 'read')
			return "<input type='password' id='field-verify_password' name='verify_password' value='' />";
		else
			return "&nbsp;";

	}

	function _custom_field_id_user($value = null, $primary_key){
		return '<input class="readonly" readonly id="field-id" name="id" type="text" value="'.$value.'" maxlength="50">';
	}

	function _check_unique_user($str){
		$action = $this->uri->segment(3);
		if($action != 'update_validation' && $action != 'update')
		{
			$table = $this->uri->segment(1);
			$query = $this->db->where('id', $str)->get(PREFIX.$table);
			if ($query->num_rows() >= 1)
			{
				$this->form_validation->set_message('_check_unique_user', $this->lang->line('tools_not_unique'));
				return FALSE;
			}
			else
			{
				return TRUE;
			}

		}else{
			return TRUE;
		}
	}

	function _check_unique_name($str){
		$action = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$table = $this->uri->segment(1);

		if($id != '') $this->db->where('id !=', $id);
		$query = $this->db->where('name', $str)->get(PREFIX.$table);
		if ($query->num_rows() >= 1){
			$this->form_validation->set_message('_check_unique_name', $this->lang->line('tools_not_unique'));
			return FALSE;
		}
		else{
			return TRUE;
		}

	}

	function _check_unique_email($str){
		$id = $this->uri->segment(4);
		$action = $this->uri->segment(3);
		$table = $this->uri->segment(1);
		if(!empty($id) && $id != null){
			$query = $this->db->where('id', $id)->get(PREFIX.$table);
			$row = $query->row();
			$email = $row->email;
		}else{
			$email = null;
		}

		if(($action != 'update_validation' && $action != 'update') || ($email != $str))
		{
			$table = $this->uri->segment(1);
			$query = $this->db->where('email', $str)->get(PREFIX.$table);
			if ($query->num_rows() >= 1)
			{
				$this->form_validation->set_message('_check_unique_email', $this->lang->line('tools_not_unique'));
				return FALSE;
			}
			else
			{
				return TRUE;
			}

		}else{
			return TRUE;
		}
	}

}

/* End of file main.php */
/* Location: ./application/controllers/tools_crud.php */
?>