<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * GesAuth Config
 *
 * A Codeigniter library authentification based on Aauth.
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	GesAuth
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license 	GNU GENERAL PUBLIC LICENSE
 * @license 	http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE
 * @version    	1.1
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 */


// Config variables

$config['gesauth'] = array(
    // The table which contains language
    'logs_gesauth' => true,
	//name of admin group
    'admin_group' => 'admin',
    // The table which contains users
    'users' => PREFIX.'users',
    // The table which contains language
    'languages' => PREFIX.'languages',
	// The table which contains language
	'join_users_languages' => PREFIX.'languages.id = '.PREFIX.'users.Language',
    // the group table
    'groups' => PREFIX.'groups',
    // the link user to group
    'user_to_group' => PREFIX.'user_to_group',
    // permitions
    'perms' => PREFIX.'perms',
    // perms to group
    'perm_to_group' => PREFIX.'perm_to_group',
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
	// Is a previous win2k server ?
	'PREVIOUS_WIN2K' => false,
	// LDAP Domain
	'LDAP_DOMAIN' => 'test.intra', # exemple : test.intra
	// LDAP DC
	'LDAP_DC' => 'serveur.test.intra', # exemple : serveur.test.intra
	// LDAP PORT DC
	'LDAP_PORT_DC' => 389, # default port dc is 389
	// LDAP AD USER
	'LDAP_AD_USER' => 'php', # exemple : php
	// LDAP USER PASSWORD
	'LDAP_AD_USER_PASSWORD' => 'password', # exemple : password
	// LDAP AD OU
	'LDAP_AD_OU' => 'CN=Users,DC=test,DC=intra' # exemple : CN=Users,DC=test,DC=intra

);


/* End of file gesauth.php */
/* Location: ./application/config/gesauth.php */