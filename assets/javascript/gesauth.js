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
 
 function no_accent (my_string) {
	var new_string = "";
	my_string = my_string.toLowerCase();
	var pattern_accent = new Array("é", "è", "ê", "ë", "ç", "à", "â", "ä", "î", "ï", "ù", "ô", "ó", "ö", " ");
	var pattern_replace_accent = new Array("e", "e", "e", "e", "c", "a", "a", "a", "i", "i", "u", "o", "o", "o", "-");
	if (my_string && my_string!= "") {
		new_string = preg_replace (pattern_accent, pattern_replace_accent, my_string);
	}
	return new_string;
}

function preg_replace (array_pattern, array_pattern_replace, my_string)  {
	var new_string = String (my_string);
		for (i=0; i<array_pattern.length; i++) {
			var reg_exp= RegExp(array_pattern[i], "gi");
			var val_to_replace = array_pattern_replace[i];
			new_string = new_string.replace (reg_exp, val_to_replace);
		}
		return new_string;
}


// Permet de charger une valeur dans un champ
function generate_identifiant(field_name,field_firstname,field_id){
	var firstname = $(field_firstname).val();
	var name = $(field_name).val();
// Si le name et le firstname n'est pas vide on génére le nom d'utilisateur
	if(firstname != "" && name != ""){
		firstname = no_accent(firstname);
		name = no_accent(name);
		$(field_id).val(firstname+'.'+name);
	}
}

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