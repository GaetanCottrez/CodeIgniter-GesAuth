<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter HTML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/html_helper.html
 */

// ------------------------------------------------------------------------


/**
 * Script
 *
 * Generates an HTML script tag.
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('script'))
{
	function script($type = '', $src = '', $content = '')
	{
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($type))
		{
			$type = array(array('type' => $type, 'src' => $src, 'content' => $content));
		}
		else
		{
			// Turn single array into multidimensional
			if (isset($type['type']))
			{
				$type = array($type);
			}
		}

		$str = '';
		foreach ($type as $meta)
		{
			$type		= ( ! isset($meta['type']) || $meta['type'] =='') 	? '' 	: 'type="'.$meta['type'].'"';
			$src		= ( ! isset($meta['src']) || $meta['src'] =='')		? ''	: 'src="'.$meta['src'].'"';
			$content	= ( ! isset($meta['content']) || $meta['content'] =='')	? ''	: $meta['content'];

			$str .= '<script '.$type.' '.$src.'>'.$content.'</script>';
		}

		return $str;
	}
}


/**
 * Heading
 *
 * Generates an HTML heading tag.  First param is the data.
 * Second param is the size of the heading tag.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	string
 */
if ( ! function_exists('title'))
{
	function title($data = '')
	{
		return "<title>".$data."</title>";
	}
}


/* End of file html_helper.php */
/* Location: ./application/helpers/MY_html_helper.php */