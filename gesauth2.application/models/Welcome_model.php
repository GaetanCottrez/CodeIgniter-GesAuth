<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model
{
	public function get_info()
	{
		//	On simule l'envoi d'une requête
		return array('paragraph1' => 'Ceux-ci est le dashboard utilisateur',
			     'paragraph2' => 'C\'est ici que se trouve toutes les requêtes et liens rapides de l\'utilisateur',
		         'paragraph3' => 'Exemple : afficher tous les utilisateurs connectés');
	}
}

?>