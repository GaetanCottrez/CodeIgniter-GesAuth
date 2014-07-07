<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Assets URL
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('assets_url'))
{
    function assets_url($uri = '')
    {
        $CI =& get_instance();

        $assets_url = $CI->config->item('assets_url');

        return $assets_url . trim($uri, '/');
    }
}

if ( ! function_exists('css_url'))
{
	function css_url($nom)
	{
		return versioning_name_files(base_url() . 'assets/css/' . $nom . '.css',VERSIONING_FILES);
	}
}

if ( ! function_exists('js_url'))
{
	function js_url($nom)
	{
		return versioning_name_files(base_url() . 'assets/javascript/' . $nom . '.js',VERSIONING_FILES);
	}
}

if ( ! function_exists('img_url'))
{
	function img_url($nom)
	{
		return versioning_name_files(base_url() . 'assets/images/' . $nom,VERSIONING_FILES);
	}
}

if ( ! function_exists('img_balise'))
{
	function img_balise($nom, $alt = '')
	{
		return '<img src="' . img_url($nom) . '" alt="' . $alt . '" />';
	}
}

if ( ! function_exists('site_url'))
{
	function site_url($uri = '')
	{
		if( ! is_array($uri))
		{
			//	Tous les param�tres sont ins�r�s dans un tableau
			$uri = func_get_args();
		}

		//	On ne modifie rien ici
		$CI =& get_instance();
		return $CI->config->site_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('link_balise'))
{
	function link_balise($text, $uri = '',$class='',$target='')
	{
		if($class != ""){
			$class ='class="'.$class.'"';
		}

		if($target != ""){
			$target ='target="'.$target.'"';
		}

		return '<a '.$class.' '.$target.' href="' . site_url($uri) . '">' . $text . '</a>';
	}
}

// ------------------------------------------------------------------------

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302, $refresh='0')
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = site_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:".$refresh.";url=".$uri);
			break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
			break;
		}
		exit;
	}
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */