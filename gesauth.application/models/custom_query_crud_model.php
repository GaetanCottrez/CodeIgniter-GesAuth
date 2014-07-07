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
		if($action == false){
			$this->db->ar_join[] = $relation;
			foreach($fields as $field)
			{
				$this->db->ar_select[] = $field;
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

}

?>