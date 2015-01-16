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
$lang['gesauth_no_access'] ='You dont have access.';
$lang['gesauth_ip_address_change'] ="Your IP address has changed since your last login, please reconnect.";
$lang['gesauth_disconnect'] ="Log out successfully.";
$lang['gesauth_disconnect_by_other_user'] ="You have been disconnected because another user has logged in with this account.";
$lang['gesauth_wrong'] ='User or Password is wrong.';
$lang['gesauth_exceeded'] ='Login try limit exceeded.';
$lang['gesauth_disabled'] ="Disabled user.";
$lang['gesauth_session_expired'] ="Your session has expired due to inactivity";

// ldap
$lang['gesauth_no_etablish_connection_ldap'] ="The connection to the server could not be established, please try again later.";
$lang['gesauth_no_result_to_search_ldap'] ="No results were found for the requested search.";
$lang['gesauth_password_expired_ldap'] ="Your password has expired.";
$lang['gesauth_unable_to_connect_server_ldap'] ="Unable to connect to server: %s";
$lang['gesauth_authentification_mode'] ="Authentification mode";
$lang['gesauth_authentification_ldap_temporarily_unavailable'] ="Windows authentication temporarily unavailable";

//extension
$lang['gesauth_ldap_not_support'] ="Library GesAuth : LDAP functions are not supported, please activate LDAP extension on the server or change your authentication mode in MySQL.";



/* End of file gesauth_lang.php */
/* Location: ./system/language/french/gesauth_lang.php */