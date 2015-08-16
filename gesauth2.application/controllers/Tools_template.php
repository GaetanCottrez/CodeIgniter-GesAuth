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
	public $config_gesauth;
	
	function __construct()
	{
		parent::__construct();

		// Initialisation des fichiers CSS
		$this->template->add_file_css('bootstrap.min');
		$this->template->add_file_css('bootstrap-theme.min');
		$this->template->add_file_css('normalize');
		$this->template->add_file_css('login');
		$this->template->add_file_css('ui-lightness/jquery-ui');
		$this->template->add_file_css('menu-css3');
		$this->template->add_file_css('custom');
		
		// Initialisation des fichiers JS
		$this->template->add_file_js('jquery-2.1.0.min');
		$this->template->add_file_js('external/jquery/jquery');
		$this->template->add_file_js('bootstrap.min');
		$this->template->add_file_js('jquery-ui.min');
		$this->template->add_file_js('gesauth');
		$this->template->add_file_js('custom');
		
		$this->config_gesauth = $this->config->item('gesauth');
		$this->lang->load('menu',$this->session->userdata($this->config_gesauth['prefix_session'].'language'));
		
		// Dynamic menu 
		
		/*  Admin */
		$li = array();
		$title = array();
		$title['Name'] = 'menu_admin';
		$title['Link'] = '#';
		$title['Class'] = 'drop';
		$nb_column = 1;
		$col= 1;
		$x = 0;
		$y = 0;
		if($this->gesauth->control('menu_roles', false) == true){
			$li[$x][$y]['Name'] = 'menu_roles';
			$li[$x][$y]['Link'] = '/roles/';
			$y++;
		}

		if($this->gesauth->control('menu_users', false) == true){
			$li[$x][$y]['Name'] = 'menu_users';
			$li[$x][$y]['Link'] = '/users/';
			$y++;
		}
		
		$this->template->add_element_menu($title,$nb_column,$col,$li);
		/*  End Admin */
		
		/* End Home Item */
		$this->template->set_theme($this->theme);
	}

}

/* End of file tools_template.php */
/* Location: ./application/controllers/tools_template.php */
?>