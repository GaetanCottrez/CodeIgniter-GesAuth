<?php
/**
 * Language for GesAuth
 *
 * A Codeigniter library authentification based on Aauth.
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license GNU GENERAL PUBLIC LICENSE
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */


// error
$lang['gesauth_no_access'] ="Vous n'avez pas acc&egrave;s.";
$lang['gesauth_ip_address_change'] ="Votre adresse IP a changé depuis votre dernière connexion, veuillez vous reconnecter.";
$lang['gesauth_disconnect'] ="Déconnexion effectuée avec succès.";
$lang['gesauth_disconnect_by_other_user'] ="Vous avez été déconnecté car un autre utilisateur s'est connecté avec ce compte.";
$lang['gesauth_wrong'] ="Nom d'utilisateur ou mot de passe incorrect.";
$lang['gesauth_exceeded'] ='Tentative de connexion excédée.';
$lang['gesauth_disabled'] ="Nom d'utilisateur désactivé.";

// ldap
$lang['gesauth_no_etablish_connection_ldap'] ="La connexion au serveur n'a pas pu être établi, veuillez réessayer ultérieurement.";
$lang['gesauth_no_result_to_search_ldap'] ="Aucun résultat n'a été trouvé pour la recherche demandée.";
$lang['gesauth_password_expired_ldap'] ="Votre mot de passe est expiré.";
$lang['gesauth_unable_to_connect_server_ldap'] ="Impossible de se connecter au serveur: %s";
$lang['gesauth_authentification_mode'] ="Mode d'authentification";
$lang['gesauth_authentification_ldap_temporarily_unavailable'] ="Authentification Windows indisponible temporairement";

//extension
$lang['gesauth_ldap_not_support'] ="Librairie GesAuth : Les fonctions LDAP ne sont pas support&eacute;s, Veuillez activer l'extension LDAP sur le serveur ou changer votre mode d'authentification en MySQL.";



/* End of file gesauth_lang.php */
/* Location: ./system/language/french/gesauth_lang.php */