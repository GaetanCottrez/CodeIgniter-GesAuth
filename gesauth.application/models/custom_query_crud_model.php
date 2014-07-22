<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom model for grocery crud
 *
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
 */

//include APPPATH.'models/grocery_crud_model.php';
class Custom_query_crud_model extends grocery_CRUD_model
{
	private $custom_field = array();
	function __construct() {
		parent::__construct();
	}

	/**
	 *	hack add relation grocery crud.
	 *
	 *	@param string $relation 	relation table custom
	 *	@param array $fields 	list fields of relation
	 */
	public function set_custom_relation($relation,$fields){
		$action = $this->uri->segment(3);
		if($action == 'success') $action = false;
		if($action == false){
			$this->db->ar_join[] = $relation;
			foreach($fields as $field)
			{
				$this->custom_field[] = $field;
			}
		}
	}

	/**
	 *	update for jeditable.
	 *
	 *	@param string $id 	id of table user
	 *	@param array $data 	table data user
	 *	@return object		result of request
	 */
	public function update_jeditable($table,$id,$data)
	{
		return $this->db->where('id', $id)
		->update($table, $data);
	}

	function get_list()
	{
		if($this->table_name === null)
			return false;

		$select = "`{$this->table_name}`.*";

		//set_relation special queries
		if(!empty($this->relation))
		{
			foreach($this->relation as $relation)
			{
				list($field_name , $related_table , $related_field_title) = $relation;
				$unique_join_name = $this->_unique_join_name($field_name);
				$unique_field_name = $this->_unique_field_name($field_name);

				if(strstr($related_field_title,'{'))
				{
					$related_field_title = str_replace(" ","&nbsp;",$related_field_title);
					$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
				}
				else
				{
					$select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
				}

				if($this->field_exists($related_field_title))
					$select .= ", `{$this->table_name}`.$related_field_title AS '{$this->table_name}.$related_field_title'";
			}
		}

		//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
		if(!empty($this->relation_n_n))
		{
			$select = $this->relation_n_n_queries($select);
		}

		// custom field
		foreach($this->custom_field as $field)
		{
			$select .= ", ".$field;
		}

		$this->db->select($select, false);

		$results = $this->db->get($this->table_name)->result();

		return $results;
	}

}

?>