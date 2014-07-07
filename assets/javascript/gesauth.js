/**
 * Js required for mechanics GesAuth
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

$(document).ready(function() {
	window.onbeforeunload = function () {
		$.ajax({
			url: gesauth_url_close_browser, /* <script type="text/javascript">var gesauth_url_close_browser = "<?php echo site_url('login/ajax_close_browser'); ?>";</script>  */
			type: 'POST',
			async : false,
			data: null,
			success: function(msg) {
				$('#processing').html(msg);
			}
		});
	    //return " ";
	};
});