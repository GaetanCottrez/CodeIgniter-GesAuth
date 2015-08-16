<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Template Library
 * Handle masterview and views within masterview
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 *
 */

class Template {

    private $CI;
	private $theme = 'default';
	private $config_vars;
/*
|===============================================================================
| Constructeur
|===============================================================================
*/

	public function __construct()
	{
		$this->CI =& get_instance();

		$this->config_vars = $this->CI->config->item('gesauth');

		// Définition du modèle pour la librairie
		$this->CI->load->model('template_model');
		$this->template_model = new template_model();


		$this->var['output'] = '';
		$this->var['menu'] ='';
		$this->var['dynamic_menu'] = '';
		//	Le title est composé du nom de la méthode et du nom du contrôleur
		//	La fonction ucfirst permet d'ajouter une majuscule
		//$this->var['title'] = ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->CI->router->fetch_class());
		$this->var['title'] ='';

		//	Nous initialisons la variable $charset avec la même valeur que
		//	la clé de configuration initialisée dans le fichier config.php
		$this->var['charset'] = $this->CI->config->item('charset');
		$this->var['css'] = array();
		$this->var['js'] = array();

	}

	public function is_loggedin() {
		// Si l'utilisateur n'est pas connecté
		$explode_uri = explode('/',uri_string());
		$uri_login = $explode_uri[0];
		if(isset($explode_uri[1])){
			$uri_logout = $explode_uri[1];
		}else{
			$uri_logout = '';
		}

		if($uri_logout == URI_CLOSE_BROWSER) return;

		if (!$this->CI->gesauth->is_loggedin()){
			if($uri_login != URI_LOGIN) redirect('/'.URI_LOGIN.'/', 'refresh');
			return;
		}else{
			if($uri_login == URI_LOGIN && $uri_logout != URI_LOGOUT){
				redirect('/', 'refresh');
				return;
			}
			// SET du Menu
			$this->load_menu();
		}
	}

	public function set_theme($theme)
	{	
		if(is_string($theme) AND !empty($theme) AND file_exists('./orditech.application/views/themes/' . $theme . '.php'))
		{
			$this->theme = $theme;
		}
		
		// Check que l'utilisateur est bien connecté
		$this->is_loggedin();
	}

/*
|===============================================================================
| Méthodes pour charger les vues
|	. view
|	. views
|===============================================================================
*/

	public function view($name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		$this->CI->load->view('themes/' . $this->theme, $this->var);
	}

	public function views($name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}

/*
|===============================================================================
| Méthodes pour modifier les variables envoyées au layout
|	. set_title
|	. set_charset
|===============================================================================
*/
	public function set_title($title)
	{
		if(is_string($title) AND !empty($title))
		{
			$this->var['title'] = $title;
			return true;
		}
		return false;
	}

	public function set_charset($charset)
	{
		if(is_string($charset) AND !empty($charset))
		{
			$this->var['charset'] = $charset;
			return true;
		}
		return false;
	}

/*
|===============================================================================
| Méthodes pour ajouter des feuilles de CSS et de JavaScript
|	. add_file_css
|	. add_file_js
|===============================================================================
*/
	public function add_file_css($nom)
	{
		if(is_string($nom) AND !empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
		{
			$this->var['css'][] = css_url($nom);
			return true;
		}
		return false;
	}

	public function add_file_js($nom)
	{
		if(is_string($nom) AND !empty($nom) AND file_exists('./assets/javascript/' . $nom . '.js'))
		{
			$this->var['js'][] = js_url($nom);
			return true;
		}
		return false;
	}

	private function set_col($number=1,$content='')
	{
		if(is_string($content) AND !empty($content))
		{
			$col = '<div class="col_'.$number.'">';
			$col .= $content;
			$col .= '</div>';
			return $col;
		}
	}

	public function add_element_menu($title=array(),$nb_column=1,$col=1,$li=array()){
		$this->var['dynamic_menu'] .= '<li><a class="'.$title['Class'].'" href="'.site_url($title['Link']).'">'.$this->CI->lang->line($title['Name']).'</a>';
		if($nb_column > 1) $s='s'; else $s='';
		if(!isset($title['Align'])) $title['Align'] = '';
		$this->var['dynamic_menu'] .= '<div style="text-align: center;" class="dropdown_'.$nb_column.'column'.$s.' '.$title['Align'].'">';
		$this->var['dynamic_menu'] .= '<div class="clearfix" style="display: inline-block; margin: 0 auto;">';
		for($i=0;$i<$nb_column;$i++){
			$this->var['dynamic_menu'] .= '<div class="col_'.$col.'">';
			if(isset($li[$i][0]['h3'])) $this->var['dynamic_menu'] .= '<h3>'.$this->CI->lang->line($li[$i][0]['h3']).'</h3>';
			$this->var['dynamic_menu'] .= '<ul class="greybox">';
			if(!empty($li[$i])){
				for($y=0;$y<count($li[$i]);$y++){
					if(!isset($li[$i][$y]['Class'])) $li[$i][$y]['Class'] = '';
					if(!isset($li[$i][$y]['Blank'])) $li[$i][$y]['Blank'] = '';
					if(isset($li[$i][$y]['Link']) && isset($li[$i][$y]['Name']))$this->var['dynamic_menu'] .= '<li>'.link_balise($this->CI->lang->line($li[$i][$y]['Name']),$li[$i][$y]['Link'],$li[$i][$y]['Class'],$li[$i][$y]['Blank']).'</li>';
					if(isset($li[$i][$y]['Title'])) $this->var['dynamic_menu'] .= "<h3 style='text-align: center;'>".$li[$i][$y]['Title']."</h3>";
				}
			}
			$this->var['dynamic_menu'] .= '</ul>';
			$this->var['dynamic_menu'] .= '</div>';
		}
		$this->var['dynamic_menu'] .= '</div>';
		$this->var['dynamic_menu'] .= '</div>';
		$this->var['dynamic_menu'] .= '</li>';
	}

	private function load_menu(){
		$sess = get_object_vars($this->CI->session);

		$query = $this->template_model->get_company($sess['userdata'][$this->config_vars['prefix_session'].'id']);
		if ($query->num_rows() > 0) {
			$row = $query->row();
		}

		$this->CI->lang->load('menu',$sess['userdata'][$this->config_vars['prefix_session'].'language']);

		if(isset($sess['userdata'][$this->config_vars['prefix_session'].'id']))
		{
			$this->var['menu'] .= '<div id="header-container">';
			$this->var['menu'] .= '<div class="background-top-header"></div>';
			$this->var['menu'] .= '<div id="top-header" class="clearfix">';
				$this->var['menu'] .= '<div class="left">';
				if(IS_DYNAMIC_COMPANY == true)
					$this->var['menu'] .= '<img height="33px" style="margin-right: 20px;" src="'.site_url().'assets/uploads/files/'.$row->LogoPath.'"/>';
				else
					$this->var['menu'] .= '<img height="33px" style="margin-right: 20px;" src="'.site_url().'assets/images/'.LOGO_COMPANY.'"/>';
					$this->var['menu'] .= '<a id="dashboard" href="'.site_url().'">'.$this->CI->lang->line('menu_dashboard').'</a>';
				$this->var['menu'] .= '</div>';
				$this->var['menu'] .= '<div id="data-user" class="right clearfix">';
					// $this->var['menu'] .= '<a class="left" style="margin-right: 20px;" href="#">'.$this->CI->lang->line('menu_FAQ').'</a>';
					$this->var['menu'] .= '<a class="left" id="support" style="margin-right: 50px;" href="mailto:'.SUPPORT_EMAIL.'">'.$this->CI->lang->line('menu_support').'</a>';
					$this->var['menu'] .= '<div class="user left clearfix">';
						$this->var['menu'] .= '<span id="user_name">'.$sess["userdata"][$this->config_vars["prefix_session"]."firstname"]." ".$sess["userdata"][$this->config_vars["prefix_session"]."name"].'</span>';
						$this->var['menu'] .= '<span id="icon-menu-full" class="ui-icon ui-icon-carat-1-s white"></span>';
						$this->var['menu'] .= '<img id="icon-menu-mobile" src="'.site_url().'assets/images/mobile-menu.png"/>';
						$this->var['menu'] .= '<div class="dropdown_1column" style="text-align: center;">';
							$this->var['menu'] .= '<div class="clearfix" style="display: inline-block; margin: 0 auto;">';
								$this->var['menu'] .= '<div class="col_1">';
									$this->var['menu'] .= '<ul>';
										$this->var['menu'] .= '<li><a href="'.site_url().'my_account/index/edit/'.$sess['userdata'][$this->config_vars['prefix_session'].'id'].'">'.$this->CI->lang->line('menu_my_account').'</a></li>';
										$this->var['menu'] .= '<li><a href="'.site_url().'login/logout">'.$this->CI->lang->line('menu_logout').'</a></li>';
									$this->var['menu'] .= '</ul>';
								$this->var['menu'] .= '</div>';
							$this->var['menu'] .= '</div>';
						$this->var['menu'] .= '</div>';
					$this->var['menu'] .= '</div>';
				$this->var['menu'] .= '</div>';
			$this->var['menu'] .= '</div>';
		}

		$this->var['menu'] .= '<ul class="clearfix" id="menu">';
		// Accueil
		$this->var['menu'] .= '<li><a href="'.site_url().'" class="drop" title="'.$this->CI->lang->line('menu_home')
		.'">'.$this->CI->lang->line('menu_home')
		.'</a>';
		$this->var['menu'] .= '<div class="dropdown_2columns">';
		// Affichage du prenom-nom Utilisateur
		if(!isset($sess['userdata'][$this->config_vars['prefix_session'].'firstname'])) $sess['userdata'][$this->config_vars['prefix_session'].'name'] ='undefined';
		if(!isset($sess['userdata'][$this->config_vars['prefix_session'].'name'])) $sess['userdata'][$this->config_vars['prefix_session'].'name'] ='undefined';
		
		$this->var['menu'] .= '<p>&nbsp;</p>';

		$this->var['menu'] .= '<p>'.$this->CI->lang->line('menu_welcome').' '.$sess['userdata'][$this->config_vars['prefix_session'].'firstname']." ".$sess['userdata'][$this->config_vars['prefix_session'].'name'].'</p>';
		
		// Affichage du role utilisateur
		$this->var['menu'] .= '<p>';
		if(count($sess['userdata'][$this->config_vars['prefix_session'].'roles']) > 0){
			$text_role = '';
			foreach ($sess['userdata'][$this->config_vars['prefix_session'].'roles'] as $row)
			{
				$text_role .= $row['name'].', ';
			}
			$text_role = substr($text_role,0,-2);
			$this->var['menu'] .= $this->CI->lang->line('menu_in_roles').$text_role;
		}else{
			$this->var['menu'] .= $this->CI->lang->line('menu_in_no_role');
		}
		$this->var['menu'] .= '</p>';
		// Affichage de la dernière connexion
		$this->var['menu'] .= '<p>'.$this->CI->lang->line('menu_lastconnexion').' ';
		if(!isset($sess['userdata'][$this->config_vars['prefix_session'].'last_login'])) $sess['userdata'][$this->config_vars['prefix_session'].'last_login'] ='undefined';
		if($sess['userdata'][$this->config_vars['prefix_session'].'last_login']!=0)
			$this->var['menu'] .= date('d/m/Y H:i',strtotime($sess['userdata'][$this->config_vars['prefix_session'].'last_login']));
		else
			$this->var['menu'] .= $this->CI->lang->line('menu_never');
		$this->var['menu'] .= '</p>';

		$this->var['menu'] .= '<p class="border-bottom">&nbsp;</p>';

		// Affichage de la version de l'application
		$this->var['menu'] .= '<p>'.SITE_NAME.' '.$this->CI->lang->line('menu_version').' '.VERSION.'</p>';
		// Affichage du copyright
		$this->var['menu'] .= '<p>Copyright &copy; '.BEGIN_DATE;

		if(BEGIN_DATE != date('Y'))
			$this->var['menu'] .= '-'.date('Y');

		$this->var['menu'] .= ' &nbsp;Orditech SA. '.$this->CI->lang->line('menu_all_right_reserved').'.</p>';
		
		
		// // Affichage du lien vers le dashboard
		// $this->var['menu'] .= $this->set_col(2,'<p>'.link_balise($this->CI->lang->line('menu_my_account'),'/my_account/index/edit/'.$sess['userdata'][$this->config_vars['prefix_session'].'id']).'</p>');
		// // Affichage du lien vers le dashboard
		// $this->var['menu'] .= $this->set_col(2,'<p>'.link_balise($this->CI->lang->line('menu_dashboard'),'/').'</p>');
		// // Affichage du lien pour se déconnecter
		// $this->var['menu'] .= $this->set_col(2,'<p>'.link_balise($this->CI->lang->line('menu_logout'),'/login/logout/').'</p>');

		/*
		 * informations company
		*/

		$query = $this->template_model->get_company($sess['userdata'][$this->config_vars['prefix_session'].'id']);
		if ($query->num_rows() > 0) {
			$row = $query->row();
		}

		// $legal_form = $this->template_model->get_table("legalform", array("name" => $row->LegalForm))->result();
		/*
		 * informations company
		*/
		$this->var['menu'] .= '<p class="border-bottom">&nbsp;</p>';
		$this->var['menu'] .= $this->set_col(2,$this->CI->lang->line('menu_license_to'));
		if(IS_DYNAMIC_COMPANY == false)
		{
			$this->var['menu'] .= $this->set_col(1,'<img width="130" src="'.site_url("assets/images/".LOGO_COMPANY).'"/>');
			$this->var['menu'] .= $this->set_col(1,INFORMATION_COMPANY);
		}
		else
		{
			if(!empty($row->LogoPath))
				$this->var['menu'] .= $this->set_col(1,'<img width="130" src="'.site_url("assets/uploads/files/".$row->LogoPath).'"/>');
			else
				$this->var['menu'] .= $this->set_col(1,'');

			$legalform = "";
			if(!empty($legal_form) && $legal_form[0]->display == 1)
				$legalform = $legal_form[0]->name;

			$company_text = $row->Name.' '.$legalform.' <br /> <br />'.$row->Street.' '.$row->StreetNumber.'<br />'.$row->ZIP.' '.$row->City;
			$this->var['menu'] .= $this->set_col(1,$company_text);
		}
		$this->var['menu'] .= $this->var['dynamic_menu'];
		
		$this->var['menu'] .= '</ul>';
		$this->var['menu'] .= '</div>';
	}

}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */