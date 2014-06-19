<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  |  GesAuth Config
  | -------------------------------------------------------------------
  | A library Basic Authorization for CodeIgniter 2.x
 */


// Config variables

$config['gesauth'] = array(
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
    // prefix
	'prefix_session' => 'user_',
    // remember time
    'remember' => ' +3 days',

	// this is a salt for password
	'gesauth_salt' => 'y%zPaOm|$yu0y: ;wu6Kywe_+P;#XqUo|7NIN(-~w:tEdAg6#62mIem1nu=hx-h_',

    // pasword maximum char long (min is 4)
    'max' => 13,

    // it limits login attempts
    'dos_protection' => true,

    // login attempts time interval
    // default 10 times in one minute
    'try' => 10,

    // display no_access
    'display_no_access' => false

);


/* End of file gesauth.php */
/* Location: ./application/config/gesauth.php */