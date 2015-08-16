<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Models Template
 *
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	Template
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */

class template_model extends CI_Model
{
	public $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    /**
	 *	Get the table with conditions
	 *
	 *	@return object		result of request
	 */
	public function get_table($table='', $where=array(), $like=array(), $order_by=array())
	{
		if(!empty($where)) $this->db->where($where);
		if(!empty($like)) $this->db->or_like($like);
		if(!empty($order_by)) $this->db->order_by($order_by);
		return $this->db->get(PREFIX.$table);
	}

    /**
	 *	Get information companie by user.
	 *
	 *	@param string $id_user 	id of table user
	 *	@return object		result of request
	 */
	public function get_company($id_user)
	{
		 return $this->CI->db->select(PREFIX.'companies.Name, '.PREFIX.'companies.LogoPath, '.PREFIX.'companies.Street, '.PREFIX.'companies.StreetNumber, '.PREFIX.'companies.Country, '.PREFIX.'companies.ZIP, '.PREFIX.'companies.City')
		 					 ->from(PREFIX.'users, '.PREFIX.'companies')
		 					 ->where(PREFIX.'users.id', $id_user)
		 					 ->where(PREFIX.'companies.ID', 1)
         					 ->get();
	}

}

/* End of file template_model.php */
/* Location: ./application/models/template_model.php */