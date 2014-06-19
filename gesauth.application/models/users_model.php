<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Models CRUD Users for Gesauth
 *
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	Gesauth
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license
 * @version    	1.0
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */

 class Users_model extends CI_Model
{
	function __construct() {
		parent::__construct();

	}

	/**
	 *	Get list language.
	 *
	  *	@return object		result of request
	 */
	public function get_list_languages()
	{
		 return $this->db->get(PREFIX.'languages');
	}

}

?>