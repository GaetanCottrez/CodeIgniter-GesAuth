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

		$this->config_vars = & $this->CI->config->item('gesauth');

		$this->var['output'] = '';
		$this->var['menu'] ='';
		//	Le title est composé du nom de la méthode et du nom du contrôleur
		//	La fonction ucfirst permet d'ajouter une majuscule
		//$this->var['title'] = ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->CI->router->fetch_class());
		$this->var['title'] ='';

		//	Nous initialisons la variable $charset avec la même valeur que
		//	la clé de configuration initialisée dans le fichier config.php
		$this->var['charset'] = $this->CI->config->item('charset');
		$this->var['css'] = array();
		$this->var['js'] = array();

		// Initialisation des fichiers CSS
		$this->add_file_css('bootstrap.min');
		$this->add_file_css('bootstrap-theme.min');
		$this->add_file_css('normalize');
		$this->add_file_css('styles');
		$this->add_file_css('menu-css3');

		// Initialisation des fichiers JS
		$this->add_file_js('jquery-2.1.0.min');
		$this->add_file_js('bootstrap.min');
		$this->add_file_js('gesauth');

		// Check que l'utilisateur est bien connecté
		$this->is_loggedin();
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
		if(is_string($theme) AND !empty($theme) AND file_exists('./application/themes/' . $theme . '.php'))
		{
			$this->theme = $theme;
			return true;
		}
		return false;
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

		$this->CI->load->view('../themes/' . $this->theme, $this->var);
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

	public function set_col($number=1,$content='')
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
		$this->var['menu'] .= '<li>'.link_balise($this->CI->lang->line($title['Name']),$title['Link'],$title['Class']);
		if($nb_column > 1) $s='s'; else $s='';
		if(!isset($title['Align'])) $title['Align'] = '';
		$this->var['menu'] .= '<div class="dropdown_'.$nb_column.'column'.$s.' '.$title['Align'].'">';
		for($i=0;$i<$nb_column;$i++){
			$this->var['menu'] .= '<div class="col_'.$col.'">';
			if(isset($li[$i][0]['h3'])) $this->var['menu'] .= '<h3>'.$this->CI->lang->line($li[$i][0]['h3']).'</h3>';
			$this->var['menu'] .= '<ul class="greybox">';
			for($y=0;$y<count($li[$i]);$y++){
				if(!isset($li[$i][$y]['Class'])) $li[$i][$y]['Class'] = '';
				if(!isset($li[$i][$y]['Blank'])) $li[$i][$y]['Blank'] = '';
				if(isset($li[$i][$y]['Link']) && isset($li[$i][$y]['Name']))$this->var['menu'] .= '<li>'.link_balise($this->CI->lang->line($li[$i][$y]['Name']),$li[$i][$y]['Link'],$li[$i][$y]['Class'],$li[$i][$y]['Blank']).'</li>';
			}
			$this->var['menu'] .= '</ul>';
			$this->var['menu'] .= '</div>';
		}

		$this->var['menu'] .= '</div>';
		$this->var['menu'] .= '</li>';

	}

	public function load_menu(){
		$sess = get_object_vars($this->CI->session);
		$this->CI->lang->load('menu',$sess['userdata'][$this->config_vars['prefix_session'].'language']);
		$this->var['menu'] .= '<ul id="menu">';
		// Accueil
		$this->var['menu'] .= '<li><a href="#" class="drop" title="'.$this->CI->lang->line('menu_home')
		.'">'.$this->CI->lang->line('menu_home')
		.'</a>';
		$this->var['menu'] .= '<div class="dropdown_2columns">';
		$this->var['menu'] .= '<div class="col_2">';
		// Affichage du prenom-nom Utilisateur
		if(!isset($sess['userdata'][$this->config_vars['prefix_session'].'firstname'])) $sess['userdata'][$this->config_vars['prefix_session'].'firstname'] ='undefined';
		if(!isset($sess['userdata'][$this->config_vars['prefix_session'].'name'])) $sess['userdata'][$this->config_vars['prefix_session'].'name'] ='undefined';
		$this->var['menu'] .= '<h2>'.$this->CI->lang->line('menu_welcome').' '.$sess['userdata'][$this->config_vars['prefix_session'].'firstname'].' '.$sess['userdata'][$this->config_vars['prefix_session'].'name'].'</h2>';
		// Affichage de la version de l'application
		$this->var['menu'] .= '<p>'.SITE_NAME.' '.$this->CI->lang->line('menu_version').' '.VERSION.'</p>';
		// Affichage du copyright
		$this->var['menu'] .= '<p>Copyright &copy; '.date('Y').' &nbsp;'.SITE_NAME.'. '.$this->CI->lang->line('menu_all_right_reserved').'.</p>';
		// Affichage de la dernière connexion
		$this->var['menu'] .= '<p>'.$this->CI->lang->line('menu_lastconnexion').' ';
		if(!isset($sess['userdata'][$this->config_vars['prefix_session'].'last_login'])) $sess['userdata'][$this->config_vars['prefix_session'].'last_login'] ='undefined';
		if($sess['userdata'][$this->config_vars['prefix_session'].'last_login']!=0)
			$this->var['menu'] .= date('d/m/Y H:i',strtotime($sess['userdata'][$this->config_vars['prefix_session'].'last_login']));
		else
			$this->var['menu'] .= $this->CI->lang->line('menu_never');
		$this->var['menu'] .= '</p>';
		// Affichage du role utilisateur
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

		$this->var['menu'] .= '</div>';
		// Affichage du lien vers le dashboard
		$this->var['menu'] .= $this->set_col(2,'<p>'.link_balise($this->CI->lang->line('menu_dashboard'),'/').'</p>');
		// Affichage du lien pour se déconnecter
		$this->var['menu'] .= $this->set_col(2,'<p>'.link_balise($this->CI->lang->line('menu_logout'),'/login/logout/').'</p>');

		$this->var['menu'] .= $this->set_col(2,'<p class="border-bottom">&nbsp;</p>');
		$this->var['menu'] .= $this->set_col(1,img_balise('gesauth.png'));
		$this->var['menu'] .= $this->set_col(1,INFORMATION_COMPANY);
		$this->var['menu'] .= '</div>';

		/*  Admin */
		$li = array();
		$title = array();
		$title['Name'] = 'menu_admin';
		$title['Link'] = '#';
		$title['Class'] = 'drop';
		$nb_column = 2;
		$col= 1;
		$x = 0;
		$y = 0;
		$y = 0;
		$li[$x][$y]['h3'] = 'menu_users';
		// Users
		if($this->CI->gesauth->control('menu_users') == true){
			$li[$x][$y]['Name'] = 'menu_users';
			$li[$x][$y]['Link'] = '/users/';
			$y++;
		}

		$x++;
		$y = 0;
		$li[$x][$y]['h3'] = 'menu_roles';
		// roles
		if($this->CI->gesauth->control('menu_roles') == true){
			$li[$x][$y]['Name'] = 'menu_roles';
			$li[$x][$y]['Link'] = '/roles/';
			$y++;
		}
		$this->add_element_menu($title,$nb_column,$col,$li);
		/*  End Admin */

		/* End Home Item */
		$this->var['menu'] .= '</ul>';
	}

}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */