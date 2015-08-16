<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * GesAuth Config
 *
 * A Codeigniter library authentification based on Aauth.
 *
 * Copyright (C) 2014-2015 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014-2015, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1.4
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */


// Config variables

$config['gesauth'] = array(
    // The table which contains language
    'logs_gesauth' => true,
	//name of admin role
    'admin_role' => 'admin',
    // The table which contains users
    'users' => PREFIX.'users',
    // The table which contains language
    'languages' => PREFIX.'languages',
	// The table which contains language
	'join_users_languages' => PREFIX.'languages.id = '.PREFIX.'users.Language',
    // the role table
    'roles' => PREFIX.'roles',
    // the link user to role
    'user_to_role' => PREFIX.'user_to_role',
    // permitions
    'perms' => PREFIX.'perms',
    // perms to role
    'perm_to_role' => PREFIX.'perm_to_role',
    // The table which contains language
    'logs_authentification' => PREFIX.'logs_authentification',
	// The table which contains language
    'logs_perms' => PREFIX.'logs_perms',
	// prefix
	'prefix_session' => 'user_',
    // remember time
    'remember' => ' +3 days',
	// this is a salt for password
	'gesauth_salt' => 'y%zPaOm|$yu0y: ;wu6Kywe_+P;#XqUo|7NIN(-~w:tEdAg6#62mIem1nu=hx-h_',
	// it limits login attempts
    'dos_protection' => true,
	// gesauth clean all user session agent close
	'clean_session_user_agent_close' =>  true,
	// gesauth time to clean all user session agent close
	'time_to_clean_session_user_agent_close' =>  300,
	// gesauth clean all user session expired
	'clean_session_for_expiration' =>  true,
	// gesauth time to clean all user session expired
	'time_to_clean_session_for_expiration' =>  28800,
	// register logs authentification in the database
    'active_logs_authentification' => true,
	// register logs perms in the database
    'active_logs_perms' => true,
	// login attempts time interval
    // default 10 times in one minute
    'try' => 10,
	// display no_access
    'display_no_access' => false,
	// display no_access
    'match_ip' => true,
	// mode authentification
    'gesauth_mode' => 'mysql/ldap', # different values (mysql,ldap,mysql/ldap) if you use mode LDAP, activate extension PHP ldap
	// default mode authentification
    'gesauth_mode_default' => 'mysql', # different values (mysql,ldap)
	// include authentification by email ? (only mysql)
    'authentification_by_email' => true,
    // Use OpenLDAP_2.x.x ?
	'OpenLDAP_2.x.x' => true,
	// Is a previous win2k server ?
	'PREVIOUS_WIN2K' => false,
	// LDAP Domain
	'LDAP_DOMAIN' => 'test.intra', # exemple : test.intra
	// LDAP DC
	'LDAP_DC' => 'serveur.test.intra', # exemple : serveur.test.intra
	// LDAP PORT DC
	'LDAP_PORT_DC' => 389, # default port dc is 389
	// LDAP AD USER (if yout use OpenLDAP 2.x.x)
	'LDAP_AD_USER' => 'php', # exemple : php
	// LDAP USER PASSWORD (if yout use OpenLDAP 2.x.x)
	'LDAP_AD_USER_PASSWORD' => 'password', # exemple : password
	// LDAP AD OU
	'LDAP_AD_OU' => 'CN=Users,DC=test,DC=intra' # exemple : CN=Users,DC=test,DC=intra

);


/* End of file gesauth.php */
/* Location: ./application/config/gesauth.php */