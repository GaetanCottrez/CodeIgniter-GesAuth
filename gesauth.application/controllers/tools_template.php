<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tools template
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
 *
 *
 */

 class Tools_template extends CI_Controller {
	protected $theme = 'default';

	function __construct()
	{
		parent::__construct();

		// Initialisation des fichiers CSS
		$this->template->add_file_css('bootstrap.min');
		$this->template->add_file_css('bootstrap-theme.min');
		$this->template->add_file_css('normalize');
		$this->template->add_file_css('login');
		//$this->add_file_css('styles');
		$this->template->add_file_css('menu-css3');

		// Initialisation des fichiers JS
		$this->template->add_file_js('jquery-2.1.0.min');
		$this->template->add_file_js('bootstrap.min');
		$this->template->add_file_js('gesauth');

		$this->template->set_theme('default');
	}

}

/* End of file main.php */
/* Location: ./application/controllers/tools_template.php */
?>