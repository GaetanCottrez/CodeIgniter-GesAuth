<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Conversion Helper
 *
 * @access	public
 * @param	string
 * @return	string
*/
if ( ! function_exists('formatBytes'))
{
	function formatBytes($bytes, $precision = 2) {
		return round($bytes/(1048576),$precision);
	}
}

/* End of file conversion_helper.php */
/* Location: ./application/helpers/conversion_helper.php */