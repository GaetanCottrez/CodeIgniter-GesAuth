<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library Generate Object GC
 *
 * A Codeigniter library for generate a complete object Grocery CRUD.
 * 
 * Cette librairie permet de générer des objets Grocery CRUD très rapidement et très simplement
 * Très utile pour la génération de CRUD basique (exemple administration des données d'une liste déroulante) mais également de CRUD complexe
 * Un CRUD complexe étant au début un CRUD basique
 * Cela permet générer un nouvel l'espace de travail pour le développeur sans se poser de question sur ce qu'on a généré
 * 
 * Tout se génère automatiquement :
	•	Fichier de langage
	•	Fichier JS
	•	Controller
	•	Model
	•	Base de données
	•	Insertion des permissions en base de données
	•	Contrainte de suppression
	•	Filtres utilisateurs
	•	Actions
 * 
 * 
 * Gain de temps, standardisation des fichiers CRUD d'un objet à un autre
 *
 * RELEASES
 * 1.1 : fix bugs SHOW TABLE and upgrade library to CI 3.0
 * 1.0.3 : fix bugs
 * 1.0.2 : gestion du type de champ upload et possibilité de modifier les allow types pour un controller, gestion de la relation n n et gestion de CKEDITOR
 * 1.0.1 : fix logic GC for required, add field value type field in lines, add checkbox action add, edit, delete, read, add commentary for lines, automatic lenght for type of field if empty
 *
 * FEATURES
 * Generate actions for update state
 *
 * Copyright (C) 2015 Gaëtan Cottrez.
 *
 *
 * @package    	Generate Object GC
 * @copyright  	Copyright (c) 2015, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */


class Generate_Object_GC {

    public $ci;
    private $config_vars;
    public $errors = array();
    public $infos = array();
    public $file_language = 'generate_object_gc';
    public $generate_object_gc_model;
    private $treatment_form_url='';
	private $session;
	private $success_url;
	private $validation_url;
	private $add_line_url;
	private $dropdown_contraint_delete_field;
    private $option_field_on_table_url;
    public function __construct() {
    	$this->ci = & get_instance();

        $this->config_vars = $this->ci->config->item('gesauth');
        
        $this->ci->load->model('generate_object_gc_model');
    	$this->generate_object_gc_model = new generate_object_gc_model();

        //language/french/generate_object_gc_lang.php
        $this->ci->lang->load($this->file_language);

        // Get Session
        $this->session = $this->ci->session;
        
    }
    
	public function set_dropdown_contraint_delete_field($dropdown_contraint_delete_field){
    	$this->dropdown_contraint_delete_field = $dropdown_contraint_delete_field;
    }
    
	public function set_add_line_url($add_line_url){
    	$this->add_line_url = $add_line_url;
    }
    
	public function set_treatment_form_url($form_url){
    	$this->treatment_form_url = $form_url;
    }
    
	public function set_validation_url($validation_url){
    	$this->validation_url = $validation_url;
    }
    
	public function set_success_url($success_url){
    	$this->success_url = $success_url;
    }
    
    public function set_option_field_on_table($option_field_on_table){
    	$this->option_field_on_table_url = $option_field_on_table;
    }
    
	private function set_line_form($label,$field,$required='*'){
    	return '<div class="form-display-as-box" style="width:300px;">'.$label.' '.$required.' :</div>
			<div class="form-input-box">'.$field.'</div><div class="clear"></div><br />';
    }
    
    public function get_dropdown_contraint_delete_field($table){
    	$query = $this->generate_object_gc_model->get_options_contraint_delete_field($table);
    	$options = array();
    	$options .= "<option></option>";
    	$field = 'Field';
    	foreach ($query->result() as $row)
    	{
    		$options .= '<option value="'.$row->{$field}.'">'.$row->{$field}.'</option>';
    	}
    	
    	echo $options;
    }
    
	public function get_option_field_on_table($table){
    	$query = $this->generate_object_gc_model->get_options_contraint_delete_field($table);
    	$options = array();
    	$options .= "<option></option>";
    	$field = 'Field';
    	foreach ($query->result() as $row)
    	{
    		$options .= '<option value="'.$row->{$field}.'">'.$row->{$field}.'</option>';
    	}
    	
    	echo $options;
    }
    
	public function set_line_field_form($num=1){
		if($this->ci->input->post('index') != false) $num = $this->ci->input->post('index');
		$query = $this->generate_object_gc_model->show_tables();
		$options_relation = array();
		$options_relation[''] = "";
		$field = 'Tables_in_'.$this->ci->db->database;
		foreach ($query->result() as $row)
		{
			$options_relation[$row->{$field}] = $row->{$field};
		}
    	return '<tr>
    				<td>
    				'.form_input(array( 'name' => 'fields['.$num.'][name_field_table]', 'value'=> '', 'size' => '30')).'
    				'.form_hidden('index',$num).'
    				</td>
    				<td>
    					<select name="fields['.$num.'][type_field_table]">
    						<optgroup label="Nombres">
    							<option value="tinyint">tinyint</option>
    							<option value="smallint">smallint</option>
    							<option value="mediumint">mediumint</option>
    							<option value="int">int</option>
    							<option value="bigint">bigint</option>
    							<option value="decimal">decimal</option>
    							<option value="float">float</option>
    							<option value="double">double</option>
    						</optgroup>
    						<optgroup label="Date et heure">
    							<option value="date">date</option>
    							<option value="datetime">datetime</option>
    							<option value="timestamp">timestamp</option>
    							<option value="time">time</option>
    							<option value="year">year</option>
    						</optgroup>
    							<optgroup label="Chaînes">
    							<option value="char">char</option>
    							<option value="varchar">varchar</option>
    							<option value="tinytext">tinytext</option>
    							<option selected="" value="text">text</option>
    							<option value="mediumtext">mediumtext</option>
    							<option value="longtext">longtext</option>
    						</optgroup>
    						<optgroup label="Listes">
    							<option value="enum">enum</option>
    							<option value="set">set</option>
    						</optgroup>
    						<optgroup label="Binaires">
    							<option value="bit">bit</option>
    							<option value="binary">binary</option>
    							<option value="varbinary">varbinary</option>
    							<option value="tinyblob">tinyblob</option>
    							<option value="blob">blob</option>
    							<option value="mediumblob">mediumblob</option>
    							<option value="mediumblob">longblob</option>
    						</optgroup>
    					</select>
    				</td>
    				<td>'.form_input(array( 'name' => 'fields['.$num.'][lenght_field_table]', 'value'=> '', 'size' => '30')).'</td>
    				<td>'.form_input(array( 'name' => 'fields['.$num.'][appellation_field_gc]', 'value'=> '', 'size' => '30')).'</td>
    				<td>
    					<select name="fields['.$num.'][type_field_gc]">
    						<option value="">identique à la table</option>
    						<option value="hidden">hidden</option>
							<option value="invisible">invisible</option>
							<option value="password">password</option>
							<option value="enum">enum</option>
							<option value="set">set</option>
							<option value="dropdown">dropdown</option>
							<option value="multiselect">multiselect</option>
							<option value="integer">integer</option>
							<option value="true_false">true_false</option>
							<option value="string">string</option>
							<option value="text">text</option>
							<option value="date">date</option>
							<option value="datetime">datetime</option>
							<option value="readonly">readonly</option>
    						<option value="upload">upload</option>
    					</select>
    				</td>
    				<td>'.form_input(array( 'name' => 'fields['.$num.'][value_type_field_gc]', 'value'=> '', 'size' => '30')).'</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][list_gc]', 'value' => 'true', 'checked' => TRUE)).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][create_gc]', 'value' => 'true', 'checked' => TRUE)).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][modify_gc]', 'value' => 'true', 'checked' => TRUE)).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][required_gc]', 'value' => 'true')).'
    				</td>
					<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][texteditor_gc]', 'value' => 'true')).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][unique_gc]', 'value' => 'true')).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][jeditable_gc]', 'value' => 'true')).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][filter_gc]', 'value' => 'true')).'
    				</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][identify_gc]', 'value' => 'true')).'
    				</td>
    				<td>'.form_input(array( 'name' => 'fields['.$num.'][rules_gc]', 'value'=> 'trim|xss_clean', 'size' => '30')).'</td>
    				<td style="text-align:center;">
    					'.form_checkbox(array('name' => 'fields['.$num.'][activate_relation_n_n_gc]', 'value' => 'true', 'id' => 'activate_relation_n_n_gc_'.$num.'', 'class' => 'activate_relation_n_n')).'
    				</td>
    				<td>
    					<span class="relation-display-'.$num.'" style="display:none;">'.$this->ci->lang->line('generate_object_gc_relation_table').'<br /></span>
    					'.form_dropdown('fields['.$num.'][relations_gc]', $options_relation, array(), 'class="relation_n_n" id="relation_'.$num.'"').'
    					<span class="relation-display-'.$num.'" style="display:none;"><br />'.$this->ci->lang->line('generate_object_gc_selection_table').'<br /></span>
    					'.form_dropdown('fields['.$num.'][selection_gc]', $options_relation, array(), 'id="selection_'.$num.'" class="selection_n_n relation-display-'.$num.'" style="display:none;"').'
    					<span class="relation-display-'.$num.'" style="display:none;"><br />'.$this->ci->lang->line('generate_object_gc_primary_key_controller_table').'<br /></span>
    					'.form_dropdown('fields['.$num.'][primary_key_controller_gc]', array("" => ""), array(), 'id="primary_key_controller_'.$num.'" class="relation-display-'.$num.'" style="display:none;"').'
    					<span class="relation-display-'.$num.'" style="display:none;"><br />'.$this->ci->lang->line('generate_object_gc_primary_key_selection_table').'<br /></span>
    					'.form_dropdown('fields['.$num.'][primary_key_selection_gc]', array("" => ""), array(), 'id="primary_key_selection_'.$num.'" class="relation-display-'.$num.'" style="display:none;"').'
    					<span class="relation-display-'.$num.'" style="display:none;"><br />'.$this->ci->lang->line('generate_object_gc_title_field_selection').'<br /></span>
    					'.form_dropdown('fields['.$num.'][title_field_selection_gc]', array("" => ""), array(), 'id="title_field_selection_'.$num.'" class="relation-display-'.$num.'" style="display:none;"').'
    					<span class="relation-display-'.$num.'" style="display:none;"><br />'.$this->ci->lang->line('generate_object_gc_priority_field_relation').'<br /></span>
    					'.form_dropdown('fields['.$num.'][priority_field_relation_gc]', array("" => ""), array(), 'id="priority_field_relation_'.$num.'" class="relation-display-'.$num.'" style="display:none;"').'
    				</td>
    			</tr>';
    }
    
    private function set_h3($label){
    	return '<h3 class="fieldsetorditech ui-accordion-header ui-helper-reset form-title">
    	<div class="floatL form-title-left">'.$label.'</div></h3><br />';
    }
    
    public function treatment(){
    	$error = false;
    	$error_message ='';
    	$name_controller = ucfirst(strtolower($this->ci->input->post('name_controller')));
    	$name_table = $this->ci->input->post('name_table');
    	$name_file_js = $this->ci->input->post('name_file_js');
    	$title_page = $this->ci->input->post('title_page');
    	$title_button = $this->ci->input->post('title_button');
    	$contraint_delete_field = $this->ci->input->post('contraint_delete_field');
    	$create = $this->ci->input->post('create');
    	$edit = $this->ci->input->post('edit');
    	$read = $this->ci->input->post('read');
    	$delete = $this->ci->input->post('delete');
    	if($create !=false) $create = ''; else $create = '//';
    	if($edit !=false) $edit = ''; else $edit = '//';
    	if($read !=false) $read = '//'; else $read = '';
    	if($delete !=false) $delete = ''; else $delete = '//';
		
		$grocery_crud_file_upload_allow_file_types = $this->ci->input->post('grocery_crud_file_upload_allow_file_types');
    	if($grocery_crud_file_upload_allow_file_types != ''){
    		$grocery_crud_file_upload_allow_file_types = "\$this->config->set_item('grocery_crud_file_upload_allow_file_types','".$grocery_crud_file_upload_allow_file_types."');";
    	}else{
    		$grocery_crud_file_upload_allow_file_types = '';
    	}
		
    	$title_page_lang = $name_file_js.'_title';
    	$title_button_lang = $name_file_js.'_'.$name_file_js;
    	$contents_page_lang = '$lang[\''.$title_page_lang.'\'] ="'.$title_page.'";
$lang[\''.$title_button_lang.'\'] ="'.$title_button.'";
';
    	$string_create_table = "
    		CREATE TABLE `".PREFIX.$name_table."` (
			  `id` smallint(6) NOT NULL AUTO_INCREMENT,
    	";
    	$string_key_table ="";
    	$string_display_as = "";
    	$string_language = '';
    	$jeditable ='';
    	$array_columns = "";
    	$add_fields = "";
        $edit_fields = "";
        $add_fields_in_fieldset = "";
    	$edit_fields_in_fieldset = "";
    	$add_fields_after_fieldset = "";
    	$edit_fields_after_fieldset = "";
    	$required_fields = "";
    	$unique_fields = "";
    	$set_rules = "";
    	$set_relation = "";
		$set_relation_n_n = "";
    	$string_change_field_type = "";
    	$filter_list_crud_gc = '';
    	$filter_method_model_gc = '';
    	$filter_method_gc = '';
    	$array_unset_texteditor = '';
    	$nb_filter = 0;
		$upload ='';
    	
    	foreach($this->ci->input->post('fields') as $row){
    		$string_key_table_tmp ="";
			$string_create_table_tmp = "";
			if($row['name_field_table'] != "" && $row['appellation_field_gc'] != ""){
    			switch($row['type_field_table']){
    				case 'tinyint':
						if($row['lenght_field_table'] == "") $row['lenght_field_table'] = "2";
						$string_create_table_tmp = "`".$row['name_field_table']."` ".$row['type_field_table']."(".$row['lenght_field_table'].") NOT NULL DEFAULT '0',
								";
						$jeditable_type = 'text';
					break;
					
					case 'smallint':
						if($row['lenght_field_table'] == "") $row['lenght_field_table'] = "2";
						$string_create_table_tmp = "`".$row['name_field_table']."` ".$row['type_field_table']."(".$row['lenght_field_table'].") DEFAULT NULL,
								";
						$string_key_table_tmp =", KEY `fk_".PREFIX.$name_table."_".$row['name_field_table']."` (`".$row['name_field_table']."`)
								";
						$jeditable_type = 'text';
					break;
					case 'mediumint':
					case 'int':
					case 'bigint':
					case 'char':
					case 'varchar':
					case 'enum':
					case 'set':
					case 'bit':
					case 'binary':
					case 'varbinary':
						if($row['lenght_field_table'] == "") $row['lenght_field_table'] = "5";
						$string_create_table_tmp = "`".$row['name_field_table']."` ".$row['type_field_table']."(".$row['lenght_field_table'].") DEFAULT NULL,
								";
						$jeditable_type = 'text';
					break;
					
					case 'decimal':
					case 'float':
					case 'double':
						if($row['lenght_field_table'] == "") $row['lenght_field_table'] = "10,2";
						$string_create_table_tmp = "`".$row['name_field_table']."` ".$row['type_field_table']."(".$row['lenght_field_table'].") DEFAULT NULL,
								";
						$jeditable_type = 'text';
					break;
					
					case 'text':
						$string_create_table_tmp = "`".$row['name_field_table']."` ".$row['type_field_table']." DEFAULT NULL,
								";
						$jeditable_type = 'text';
					break;
					
					default:
						$string_create_table_tmp = "`".$row['name_field_table']."` ".$row['type_field_table']." NULL DEFAULT NULL,
								";
						$jeditable_type = 'text';
    			}
    			
    			$string_display_as .= "->display_as('".$row['name_field_table']."',\$this->lang->line('".$name_file_js."_".$row['name_field_table']."'))
							 ";
    			if($row['type_field_gc'] != ""){
					if($row['value_type_field_gc'] != ""){
						switch($row['type_field_gc']){
							case 'hidden':
							case 'enum':
							case 'set':
							case 'dropdown':
							case 'multiselect':
								$type_field_gc = ', '.$row['value_type_field_gc'];
								$string_change_field_type .= "->field_type('".$row['name_field_table']."', '".$row['type_field_gc']."'".$type_field_gc.")
";
							break;
							
							case 'upload':
								$type_field_gc = '';
								$upload .="->set_field_upload('".$row['name_field_table']."','".$row['value_type_field_gc']."')
";
							break;
							
							default:
								$type_field_gc = '';
								$string_change_field_type .= "->field_type('".$row['name_field_table']."', '".$row['type_field_gc']."'".$type_field_gc.")
";

						}
					}else{
	    			$string_change_field_type .= "->field_type('".$row['name_field_table']."', '".$row['type_field_gc']."')
";
					}
    			}
    			$string_language .= '$lang[\''.$name_file_js.'_'.$row['name_field_table'].'\'] = "'.$row['appellation_field_gc'].'";
';
    			
    			if(isset($row['jeditable_gc'])){
    				$jeditable .="array(
					'table' => PREFIX.'".$name_table."',
					'field_table' => '".$row['name_field_table']."',
					'field_request' => '".$row['name_field_table']."',
					'type_field' => '".$jeditable_type."'
				),
						";
    			}
    			
    			if(isset($row['filter_gc'])){
    				$nb_filter++;
    				$filter_list_crud_gc .= "// filter_company
		\$data_filter = \$this->_search_filter(\$this->name_class,".$nb_filter.");
		\$data = \$this->_get_".$row['name_field_table']."();
		\$filter = '';
		if(\$data != false){
			foreach (\$data as \$row)
			{
				\$checked = \$this->_is_value_filter_checked(\$data_filter,\$row['id']);
				if(\$checked == true){
					\$filter .= ' OR ".$row['name_field_table']." = '.\$row['id'];
				}
			}
		}
		
		if(\$filter != ''){
			\$this->grocery_crud->where('('.substr(\$filter,3).')');
		}
			
			";
    				
    				$filter_method_gc .= "// filter_".$row['name_field_table']."
	public function filter_".$row['name_field_table']."()
	{
		\$code_js = '';
		\$num_filter = 1;
		\$data_filter = \$this->_search_filter(\$this->name_class,\$num_filter);
		\$data = \$this->_get_".$row['name_field_table']."();
		\$this->_build_form_filter(\$data_filter,\$data,\$this->name_class,\$num_filter,\$code_js);
	}
	    				
	function _get_".$row['name_field_table']."(){
		\$query = \$this->".$name_controller."_model->get_".$row['name_field_table']."();
		if(\$query->num_rows() > 0){
			\$data = array();
			foreach (\$query->result() as \$row)
			{
				if(isset(\$row->ID)) \$row->id = \$row->ID;
				if(isset(\$row->Name)) \$row->name = \$row->Name;
				\$data[] = array(
					'id' => \$row->id,
					'name' => \$row->name
				);
			}
			\$row = \$data;
		}else{
			\$row = false;
		}
	
		return \$row;
	}
    
	";
    				
    				$filter_method_model_gc ="/**
	 *	get ".$row['name_field_table']."
	 *
	 *	@return object		result of request
	 */
	public function get_".$row['name_field_table']."()
	{
		return \$this->db->order_by('name','asc')->get(PREFIX.'".str_replace(PREFIX,"",$row['relations_gc'])."');
	}
	
	";

    			$filter_button ="array(
				'link' => '".strtolower($name_controller)."/filter_".$row['name_field_table']."',
				'text' => \$this->lang->line('".$name_file_js."_".$row['name_field_table']."'),
				'id' => 'filter_".$row['name_field_table']."'
			),
";
    			}
				
				if($row['type_field_gc'] == 'text' || ($row['type_field_gc'] == '' && $row['type_field_table'] == 'text')){
    				if(!isset($row['texteditor_gc'])) $array_unset_texteditor .= "'".$row['name_field_table']."', ";
    			}
    			
    			if(isset($row['identify_gc'])){
    				if(isset($row['create_gc'])) $add_fields_in_fieldset .= "'".$row['name_field_table']."', ";
    				if(isset($row['modify_gc'])) $edit_fields_in_fieldset .= "'".$row['name_field_table']."', ";
    			}else{
    				if(isset($row['create_gc'])) $add_fields_after_fieldset .= "'".$row['name_field_table']."', ";
    				if(isset($row['modify_gc'])) $edit_fields_after_fieldset .= "'".$row['name_field_table']."', ";
    			}
    			
    			if(isset($row['list_gc'])) $array_columns .= "'".$row['name_field_table']."', ";
    			//if(isset($row['create_gc'])) $add_fields .= "'".$row['name_field_table']."', ";
    			//if(isset($row['modify_gc'])) $edit_fields .= "'".$row['name_field_table']."', ";
    			if(isset($row['required_gc'])){ 
					$required_fields .= "'".$row['name_field_table']."', ";
					$required_rules ='|required';
				}else{
					$required_rules ='';
				}
    			
    			if(isset($row['unique_gc'])){ 
					$unique_fields .= "'".$row['name_field_table']."', ";
					//$unique_rules ='|is_unique[\'.PREFIX.\''.$name_table.'.'.$row['name_field_table'].']';
					$unique_rules = '';
				}else{
					$unique_rules = '';
				}
				
    			if($row['rules_gc'] != ""){
					$row['rules_gc'] = str_replace('|required','',$row['rules_gc']);
    				$row['rules_gc'] = str_replace('required|','',$row['rules_gc']);
					$row['rules_gc'] = str_replace('required','',$row['rules_gc']);
					$row['rules_gc'] = $row['rules_gc'].$required_rules.$unique_rules;
    				$set_rules .= "->set_rules('".$row['name_field_table']."', \$this->lang->line('".$name_file_js."_".$row['name_field_table']."'), '".$row['rules_gc']."')
    						 ";
    			}
    			
    			if(isset($row['activate_relation_n_n_gc']) && $row['title_field_selection_gc'] != "" && $row['relations_gc'] != "" && $row['selection_gc'] != "" && $row['primary_key_controller_gc'] != "" && $row['primary_key_selection_gc'] != ""){
    				if($row['priority_field_relation_gc'] != "") $row['priority_field_relation_gc'] = ", '".$row['priority_field_relation_gc']."'";
    				$set_relation_n_n .= "->set_relation_n_n('".$row['name_field_table']."', PREFIX.'".str_replace(PREFIX,"",$row['relations_gc'])."', PREFIX.'".str_replace(PREFIX,"",$row['selection_gc'])."', '".$row['primary_key_controller_gc']."', '".$row['primary_key_selection_gc']."', '".$row['title_field_selection_gc']."'".$row['priority_field_relation_gc'].")
    						 ";
    				
    			} else if($row['relations_gc'] != ""){
    				$set_relation .= "->set_relation('".$row['name_field_table']."', PREFIX.'".str_replace(PREFIX,"",$row['relations_gc'])."', 'name')
    						 ";
					$string_create_table .= $string_create_table_tmp;
    				$string_key_table .= $string_key_table_tmp;
    			}else{
    				$string_create_table .= $string_create_table_tmp;
    				$string_key_table .= $string_key_table_tmp;
    			}

    		}
    	}
    	
    	if($this->ci->input->post('contraint_delete_table') != ""){
    		$relation = "LEFT JOIN (SELECT ".$contraint_delete_field.", COUNT(".$contraint_delete_field.") AS NbUse FROM `".str_replace(PREFIX,"'.PREFIX.'",$this->ci->input->post('contraint_delete_table'))."` GROUP BY 1) `".str_replace(PREFIX,"'.PREFIX.'",$this->ci->input->post('contraint_delete_table'))."` ON `".str_replace(PREFIX,"'.PREFIX.'",$this->ci->input->post('contraint_delete_table'))."`.`".$contraint_delete_field."` = `'.PREFIX.'".$name_table."`.`id`";
    		$fields = '`'.$this->ci->input->post('contraint_delete_table').'`.NbUse';
    		$NbUse ="";
    	}else{
    		$relation = "";
    		$fields = "";
    		$NbUse ="//";
    	}
    	
    	$jeditable = substr($jeditable,0,-1);
    	$add_fields .="'begin_fieldset_identify', ".$add_fields_in_fieldset."'end_fieldset_identify', ".$add_fields_after_fieldset."'CreatedBy', 'CreatedDate', 'ModifiedBy', 'ModifiedDate'";
    	$edit_fields .="'begin_fieldset_identify', ".$edit_fields_in_fieldset."'end_fieldset_identify', ".$edit_fields_after_fieldset."'ModifiedBy', 'ModifiedDate'";
    	$array_columns = substr($array_columns,0,-2);
    	$required_fields = substr($required_fields,0,-2);
    	$unique_fields = substr($unique_fields,0,-2);
    	if($unique_fields == '') $unique_fields = "";
    	$array_unset_texteditor = substr($array_unset_texteditor,0,-2);
    	
    	$string_create_table .="
		  `CreatedBy` varchar(50) DEFAULT NULL,
		  `CreatedDate` timestamp NULL DEFAULT NULL,
		  `ModifiedBy` varchar(50) DEFAULT NULL,
		  `ModifiedDate` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
    	";
    	$string_create_table .= $string_key_table."
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    	";
    	// Création de la table en base de données
    	$query = $this->generate_object_gc_model->create_table($string_create_table);
    	
    	// Insertion des permission
    	$data_perms = array(
    			array(
    				'name' => $this->ci->input->post('perms_menu_name') ,
    				'definition' => $this->ci->input->post('perms_menu_definition')
    			),
    			array(
    				'name' => $this->ci->input->post('perms_create_name') ,
    				'definition' => $this->ci->input->post('perms_create_definition')
    			),
    			array(
    				'name' => $this->ci->input->post('perms_modify_name') ,
    				'definition' => $this->ci->input->post('perms_modify_definition')
    			),
    			array(
    				'name' => $this->ci->input->post('perms_delete_name') ,
    				'definition' => $this->ci->input->post('perms_delete_definition')
    			)
    	);
    	$this->generate_object_gc_model->insert_perms($data_perms);
   
    	//Création du dossier JS et des 3 fichiers JS
    	if(!$error){
    		if(!mkdir('./assets/javascript/'.strtolower($name_controller).'/')){
    			$error_message = $this->ci->lang->line('generate_object_gc_error_mkdir');
    			$error = true;
    		}
    	}
    	
    	if(!$error){
	    	if(!fopen('./assets/javascript/'.strtolower($name_controller).'/'.$name_file_js.'add.js', 'a')){
	    		$error_message = $this->ci->lang->line('generate_object_gc_error_file_js');
	    		$error = true;
	    	}
	    	
	    	if(!fopen('./assets/javascript/'.strtolower($name_controller).'/'.$name_file_js.'edit.js', 'a')){
	    		$error_message = $this->ci->lang->line('generate_object_gc_error_file_js');
	    		$error = true;
	    	}
	    	
	    	if(!fopen('./assets/javascript/'.strtolower($name_controller).'/'.$name_file_js.'list.js', 'a')){
	    		$error_message = $this->ci->lang->line('generate_object_gc_error_file_js');
	    		$error = true;
	    	}
    	}
    	
    	// Création du fichier model
    	log_message('info',APPPATH);
    	if(!$error){
	    	if(!fopen(APPPATH.'/models/'.strtolower($name_controller).'_model.php', 'a')){
	    		$error_message = $this->ci->lang->line('generate_object_gc_error_file_model');
	    		$error = true;
	    	}else{
	    		$file_model = fopen(APPPATH.'/models/'.strtolower($name_controller).'_model.php', 'r+');
	    		fseek($file_model, 0); // On remet le curseur au début du fichier
	    		fputs($file_model, sprintf(
	    		$this->ci->lang->line('generate_object_gc_contents_model'), 
	    		str_replace('_','',$name_controller.' Model'), 
	    		$this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), 
	    		str_replace('_','',$name_controller), 
	    		$this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), 
	    		$this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), 
	    		$this->ci->session->userdata($this->config_vars['prefix_session'].'email'), 
	    		$name_controller.'_model', 
	    		$filter_method_model_gc,
	    		strtolower($name_controller.'_model'), 
	    		strtolower($name_controller.'_model')
    			));
	    		fclose($file_model);
	    	}
    	}
    	
    	// Création du fichier controller
    	if(!$error){
	    	if(!fopen(APPPATH.'/controllers/'.ucfirst(strtolower($name_controller)).'.php', 'a')){
	    		$error_message = $this->ci->lang->line('generate_object_gc_error_file_controller');
	    		$error = true;
	    	}else{
	    		$file_controller = fopen(APPPATH.'/controllers/'.ucfirst(strtolower($name_controller)).'.php', 'r+');
	    		fseek($file_controller, 0); // On remet le curseur au début du fichier
	    		
				fputs($file_controller, sprintf(
		    		$this->ci->lang->line('generate_object_gc_contents_controller'), 
		    		str_replace('_','',$name_controller), 
		    		$this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), 
		    		str_replace('_','',$name_controller), 
		    		$this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), 
		    		$this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), 
		    		$this->ci->session->userdata($this->config_vars['prefix_session'].'email'), 
		    		$name_controller,
		    		strtolower($name_controller),
		    		$this->ci->input->post('perms_menu_definition'),
		    		$this->ci->input->post('perms_create_definition'),
		    		$this->ci->input->post('perms_modify_definition'),
		    		$this->ci->input->post('perms_delete_definition'),
	    			$name_controller.'/'.$name_file_js,
	    			$name_table,
	    			$title_page_lang,
	    			$name_controller.'_model',
	    			$array_columns,
	    			$add_fields,
	    			$edit_fields,
	    			$required_fields,
					$unique_fields,
					$array_unset_texteditor,
	    			$grocery_crud_file_upload_allow_file_types,
	    			$filter_method_gc,
	    			$filter_list_crud_gc,
	    			$filter_button,
	    			$relation,
	    			$fields,
	    			$jeditable,
	    			$title_button_lang,
	    			$string_display_as,
	    			$string_change_field_type,
					$upload,
	    			$set_rules,
	    			$set_relation,
					$set_relation_n_n,
	    			$read,
					$create,
					$create,
					$edit,
					$edit,
					$delete,
					$delete,
					$NbUse, 
	    			$NbUse, 
	    			strtolower($name_controller), 
	    			strtolower($name_controller)
        		));
	    		fclose($file_controller);
	    	}
    	}
    	
    	// Création du fichier language french
    	if(!$error){
    		if(!fopen(APPPATH.'/language/french/'.strtolower($name_controller).'_lang.php', 'a')){
    			$error_message = $this->ci->lang->line('generate_object_gc_error_file_lang');
    			$error = true;
    		}else{
    			$file_lang = fopen(APPPATH.'/language/french/'.strtolower($name_controller).'_lang.php', 'r+');
    			fseek($file_lang, 0); // On remet le curseur au début du fichier
    			fputs($file_lang, sprintf($this->ci->lang->line('generate_object_gc_contents_lang'), str_replace('_','',$name_controller), $this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), str_replace('_','',$name_controller), $this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), $this->ci->session->userdata($this->config_vars['prefix_session'].'firstname').' '.$this->ci->session->userdata($this->config_vars['prefix_session'].'name'), $this->ci->session->userdata($this->config_vars['prefix_session'].'email'), $contents_page_lang.$string_language, strtolower($name_controller), strtolower($name_controller)));
    			fclose($file_lang);
    		}
    	}
    	
    	if ($error)
    	{
    		//$this->db->trans_rollback();
    		echo "<textarea>".json_encode(array(
    				'success' => false ,
    				'error_message' => $error_message
    		))."</textarea>";
    		die();
    	}else{
    		echo "<textarea>".json_encode(array(
    				'success' => true ,
    				'success_message' => $this->ci->lang->line('generate_object_gc_insert_success'),
    				'success_list_url'=> site_url($this->success_url)
    		))."</textarea>";
    		die();
    	}
    }
    
    public function render($data,$view='generate_object_gc/form'){
    	$this->ci->template->view($view, $data);
    }
    
    public function validation(){
    	$this->ci->form_validation->set_rules('name_controller', $this->ci->lang->line('generate_object_gc_name_controller'), 'trim|required|xss_clean');
    	$this->ci->form_validation->set_rules('name_table', $this->ci->lang->line('generate_object_gc_name_table'), 'trim|required|xss_clean|callback_check_table_exist');
    	$this->ci->form_validation->set_rules('name_file_js', $this->ci->lang->line('generate_object_gc_name_table'), 'trim|required|xss_clean');
    	
    	$this->ci->form_validation->set_rules('perms_menu_definition', $this->ci->lang->line('generate_object_gc_menu_definition'), 'trim|required|xss_clean');
    	$this->ci->form_validation->set_rules('perms_menu_name', $this->ci->lang->line('generate_object_gc_menu_name'), 'trim|required|xss_clean');
    	$this->ci->form_validation->set_rules('perms_create_name', $this->ci->lang->line('generate_object_gc_create_name'), 'trim|required|xss_clean');
    	$this->ci->form_validation->set_rules('perms_create_definition', $this->ci->lang->line('generate_object_gc_create_definition'), 'trim|required|xss_clean');
		$this->ci->form_validation->set_rules('perms_modify_name', $this->ci->lang->line('generate_object_gc_create_definition'), 'trim|required|xss_clean');
		$this->ci->form_validation->set_rules('perms_modify_definition', $this->ci->lang->line('generate_object_gc_modify_definition'), 'trim|required|xss_clean');
		$this->ci->form_validation->set_rules('perms_delete_name', $this->ci->lang->line('generate_object_gc_delete_name'), 'trim|required|xss_clean');
		$this->ci->form_validation->set_rules('perms_delete_definition', $this->ci->lang->line('generate_object_gc_delete_definition'), 'trim|required|xss_clean');
    	$this->ci->form_validation->set_rules('title_page', $this->ci->lang->line('generate_object_gc_title_page'), 'trim|required|xss_clean');
    	$this->ci->form_validation->set_rules('title_button', $this->ci->lang->line('generate_object_gc_title_button'), 'trim|required|xss_clean');
    	if(!$this->ci->form_validation->run()) {
    		echo "<textarea>".json_encode(array(
    				'success' => false ,
    				'error_message' => validation_errors()
    		))."</textarea>";
    	}else{
    		echo json_encode(array('success' => true));
    	}
    }
    
    public function set_form(){
    	$form['title_page'] = $this->ci->lang->line('generate_object_gc_title');
    	
    	$form['lang']['title_success'] = $this->ci->lang->line('generate_object_gc_title_success');
    	$form['lang']['message_success'] = $this->ci->lang->line('generate_object_gc_insert_success');
    	$form['lang']['cancel'] = $this->ci->lang->line('generate_object_gc_cancel');
    	$form['lang']['add'] = $this->ci->lang->line('generate_object_gc_add');
    	$form['lang']['loading'] = $this->ci->lang->line('generate_object_gc_loading');
    	
    	
    	$form['validation_url'] = base_url($this->validation_url);
		$form['list_url'] = base_url('ask_holidays');
    	$form['message_alert_form'] = $this->ci->lang->line('generate_object_gc_alert_form');
    	$form['message_insert_error'] = $this->ci->lang->line('generate_object_gc_alert_form');
    	$form['success_list_url'] = site_url($this->success_url);
		$form['dropdown_contraint_delete_field'] = site_url($this->dropdown_contraint_delete_field);
		$form['option_field_on_table_url'] = site_url($this->option_field_on_table_url);
		$form['form'] = form_open( $this->treatment_form_url, 'method="post" id="form" autocomplete="off" enctype="multipart/form-data"');
		/* Identification */
		$form['form'] .= $this->set_h3($this->ci->lang->line('generate_object_gc_identification'));
		$data = array(
				'name'        => 'title_page',
				'id'          => 'title_page',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'Liste des utilisateurs',
		);
		$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_title_page'),form_input($data));
		
		$data = array(
				'name'        => 'title_button',
				'id'          => 'title_button',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'un utilisateur',
		);
		$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_title_button'),form_input($data));
		
		$data = array(
				'name'        => 'name_controller',
				'id'          => 'name_controller',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'Users',
		);
		$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_name_controller'),form_input($data));
		$data = array(
				'name'        => 'name_table',
				'id'          => 'name_table',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'users',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_name_table'),form_input($data));
    	$data = array(
				'name'        => 'name_file_js',
				'id'          => 'name_file_js',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'user',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_name_file_js'),form_input($data));
    	
    	$data = array(
				'name'        => 'grocery_crud_file_upload_allow_file_types',
				'id'          => 'grocery_crud_file_upload_allow_file_types',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'gif|jpeg|jpg|png',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_name_allow_files_types'),form_input($data),'');
    	
    	/* Permissions */
		$form['form'] .= $this->set_h3($this->ci->lang->line('generate_object_gc_perms'));
		$data = array(
				'name'        => 'perms_menu_name',
				'id'          => 'perms_menu_name',
				'value'       => '',
				'size'        => '30',
				'style'       => '',
				'placeholder' => 'Liste des utilisateurs',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_menu_name'),form_input($data));
    	
		$data = array(
    			'name'        => 'perms_menu_definition',
    			'id'          => 'perms_menu_definition',
    			'value'       => 'menu_',
    			'size'        => '30',
    			'style'       => '',
    	);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_menu_definition'),form_input($data));
    	
    	$data = array(
    			'name'        => 'perms_create_name',
    			'id'          => 'perms_create_name',
    			'value'       => '',
    			'size'        => '30',
    			'style'       => '',
    			'placeholder' => 'Création d\'un utilisateur',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_create_name'),form_input($data));
    	$data = array(
    			'name'        => 'perms_create_definition',
    			'id'          => 'perms_create_definition',
    			'value'       => 'create_',
    			'size'        => '30',
    			'style'       => '',
    	);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_create_definition'),form_input($data));
    	 
    	$data = array(
    			'name'        => 'perms_modify_name',
    			'id'          => 'perms_modify_name',
    			'value'       => '',
    			'size'        => '30',
    			'style'       => '',
    			'placeholder' => 'Modification d\'un utilisateur',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_modify_name'),form_input($data));
    	$data = array(
    			'name'        => 'perms_modify_definition',
    			'id'          => 'perms_modify_definition',
    			'value'       => 'modify_',
    			'size'        => '30',
    			'style'       => '',
    	);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_modify_definition'),form_input($data));
    	 
    	$data = array(
    			'name'        => 'perms_delete_name',
    			'id'          => 'perms_delete_name',
    			'value'       => '',
    			'size'        => '30',
    			'style'       => '',
    			'placeholder' => 'Suppression d\'un utilisateur',
		);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_delete_name'),form_input($data));
    	$data = array(
    			'name'        => 'perms_delete_definition',
    			'id'          => 'perms_delete_definition',
    			'value'       => 'delete_',
    			'size'        => '30',
    			'style'       => '',
    	);
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_delete_definition'),form_input($data));
		
		$query = $this->generate_object_gc_model->show_tables();
    	$options_relation = array();
    	$options_relation[''] = "";
    	$field = 'Tables_in_'.$this->ci->db->database;
    	foreach ($query->result() as $row)
    	{
    		$options_relation[$row->{$field}] = $row->{$field};
    	}
    	$form['form'] .= $this->set_h3($this->ci->lang->line('generate_object_gc_contraints'));
		$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_contraint_delete_table'),form_dropdown('contraint_delete_table', $options_relation, array(),'id="contraint_delete_table"'));
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_contraint_delete_field'),form_dropdown('contraint_delete_field', array('' => ''), array(),'id="contraint_delete_field"'));
    	 
    	/* Liste des champs */
		$form['form'] .= $this->set_h3($this->ci->lang->line('generate_object_gc_fields'));
		$form['form'] .= '<p>'.$this->ci->lang->line('generate_object_gc_informations_table').'</p>
						 <div class="tableau-gris" >
						 <table id="table_lines">
							<tr><td class="grey" colspan="3">Base de données</td><td class="grey" colspan="15">Grocery CRUD</td></tr>
							<tr><td>Nom du champ</td><td>Type du champ</td><td>Longueur</td><td>Appellation du champ</td><td>Type du champ</td><td>Valeur type du champ</td><td>Liste</td><td>Création</td><td>Modification</td><td>Requis</td><td>CKEDITOR</td><td>Unique</td><td>jEditable</td><td>Filtre</td><td>Identification</td><td>Rules</td><td>Relation n n</td><td>Relation avec</td></tr>
		';
		$form['form'] .= $this->set_line_field_form();
		$form['form'] .= '</table></div><br />';
		$form['form'] .= '<p>'.form_button(array('type' => 'button', 'id' => 'add', 'content' => 'Ajouter une ligne', 'onclick' => "var new_index = get_new_index(); $.ajax({ url: '".$this->add_line_url."', type: 'POST', data: {index : new_index}, dataType: 'html', success: function(html){\$('#table_lines tr:last').after(html);}});")).'</p>';
		/* Actions */
		$form['form'] .= $this->set_h3($this->ci->lang->line('generate_object_gc_actions'));
		$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_title_create'),form_checkbox(array('name' => 'create', 'value' => 'true', 'checked' => true)));
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_title_edit'),form_checkbox(array('name' => 'edit', 'value' => 'true', 'checked' => true)));
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_title_read'),form_checkbox(array('name' => 'read', 'value' => 'true')));
    	$form['form'] .= $this->set_line_form($this->ci->lang->line('generate_object_gc_title_delete'),form_checkbox(array('name' => 'delete', 'value' => 'true', 'checked' => true)));
    	 
    	
		$form['form'] .= form_close();
    	
    	$this->render($form);
    }

}

?>