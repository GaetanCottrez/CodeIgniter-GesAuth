<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Models Generate Object GC
 *
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

class generate_object_gc_model extends CI_Model
{
	public function __construct() {
        parent::__construct();
    }

    /**
	 *	insert perms
	 *
	 *	@param string $data $data to insert
	 *	@return object		result of request
	 */
	public function insert_perms($data)
	{
		 return $this->db->insert_batch(PREFIX.'perms', $data);
	}
	
	/**
	 *	show tables in database
	 *
	 *	@return object		result of request
	 */
	public function show_tables()
	{
		return $this->db->query('SHOW TABLES FROM `'.$this->db->database.'`');
	}
	
	/**
	 *	create table in database
	 *
	 *	@return object		result of request
	 */
	public function create_table($query)
	{
		return $this->db->query($query);
	}
	
	/**
	 *	get options contraint delete field
	 *
	 *	@return object		result of request
	 */
	public function get_options_contraint_delete_field($table)
	{
		if($table != '') return $this->db->query("DESCRIBE `".$table."`");
	}
	
	/**
	 *	check table exist
	 *
	 *	@return object		result of request
	 */
	public function check_table_exist($table='')
	{
		if($table != "") return $this->db->query('SHOW TABLES FROM `'.$this->db->database.'` LIKE "'.$table.'"');
	}
	
	
}

/* End of file generate_object_gc_model.php */
/* Location: ./application/models/generate_object_gc_model.php */