<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH.'controllers/tools_template.php';
class Welcome extends Tools_template {

	private $title="";
	private $name_class="welcome";
	public function __construct()
	{
		//	Obligatoire
		parent::__construct();
		// A decommenter si le template n'est pas ajout� � l'autoload
		//$this->load->library('Webges_template');

		$this->load->model($this->name_class.'_model');

		//Set du titre
		$this->lang->load($this->name_class);
		$this->title = $this->lang->line('welcome_title');
	}

	public function index()
	{
		$this->welcome();
	}

	public function welcome()
	{

		$data = array();

		//	On lance une requ�te
		$data['user_info'] = $this->welcome_model->get_info();

		// On charge le titre de la page
		if($this->title != "") $this->template->set_title($this->title);

		$this->template->view('welcome/welcome_view',$data);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */