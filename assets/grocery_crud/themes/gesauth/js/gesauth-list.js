/*
 * Custom action for list users
 *
 * Copyright (c) 2014 Gaëtan Cottrez
 *
 *
 */


if($('a.custom_general_button').attr('href') != undefined){
	var custom_general_button = $('a.custom_general_button').attr('href').split('!')[1];
	var custom_general_button = custom_general_button.split('|');
}else{
	var custom_general_button = new Array();
}

for(i=0;i<custom_general_button.length;i++){
	tmp = custom_general_button[i].split(';');
	if(custom_general_button[i] !=''){
		$( "#custom-general-button" ).after( '<a role="button" class="DTTT_button ui-state-default ui-corner-all" href="'+tmp[0]+'"><span class="ui-button-text">'+tmp[1]+'</span></a>' );
	}
}

$( "a" ).remove(":contains('CustomGeneralButton')");

/*

$( "#custom-general-button" ).after( "<p>Test</p>" );

<a role="button" class="DTTT_button add_button ui-state-default ui-corner-all ui-button-text-icon-primary" href="<?php echo $add_url?>">
	<span class="ui-button-icon-primary ui-icon ui-icon-circle-plus"></span>
	<span class="ui-button-text"><?php echo $subject?></span>
</a>
*/

$('a.control_display_action').each(function( index ) {
  $( "#"+$( this ).attr('href') ).remove();
});

if($('a.jeditable_action').attr('href') != undefined){
	var options_jeditable = $('a.jeditable_action').attr('href').split('!')[1];
	var options_jeditable = options_jeditable.split('|');
}else{
	var options_jeditable = new Array();
}

$( "a" ).remove(":contains('ControlDisplayButton')");


$( "a" ).remove(":contains('JeditableButton')");

$( "th.ui-state-default" ).remove(":contains('JeditableButton')");

$(document).ready(function() {
	/* Init DataTables */
	var oTable = $('#'+uniqid).dataTable();
	// fixed column table for scroll
	//new $.fn.dataTable.FixedHeader( oTable );
	/* Apply the jEditable handlers to the table */
	var strdynamicurl = '';
	var tmp = '';
	var name = '';
	var nametd = '';
	var typefieldsubmit = '';
	var typefield = '';
	var dropdownlist ='';
	for(i=0;i<options_jeditable.length;i++){
		tmp = options_jeditable[i].split(';');
		table = tmp[0];
		name = tmp[1];
		nametd = tmp[2];
		typefieldsubmit = tmp[3];
		typefield = tmp[3];
		switch(typefield){
			case 'select':
				var strdynamicurl = null;
				var dropdownlist = tmp[4];
				break;

			default:
				if(tmp[4] != undefined)
					var dynamicurl = tmp[4].split(',');
				else
					var dynamicurl = new Array();
				var dropdownlist = '';
		}
		strdynamicurl = '/'+table+'/'+name+'/'+typefieldsubmit;
		for(y=0;y<dynamicurl.length;y++){
				strdynamicurl = strdynamicurl+'/'+dynamicurl[y];
		}
		// instance jeditable by td
		$("td[name*='"+nametd+"']", oTable.fnGetNodes()).editable( base_url+'tools_crud/jeditable_ajax'+strdynamicurl, {
			 data	  : dropdownlist,
			 type     : typefield,
		     /* submit   : 'OK', */
		     "callback": function( sValue, y ) {
				var aPos = oTable.fnGetPosition( this );
				oTable.fnUpdate( sValue, aPos[0], aPos[1] );
			},
			"submitdata": function ( value, settings ) {
				return {
					"row_id": this.parentNode.getAttribute('id'),
					"text": $(this).html(),
					"column": oTable.fnGetPosition( this )[2]
				};
			},
			"height": "14px"
		} );
	}

	// Rewrite columns lines for numeric order asc by click to th
	$( "th.ui-state-default" ).click(function() {
		var lines = $( "td[name='lines']" );
		var y = 1;
		for(i=0;i<lines.length;i++){
			lines[i].innerHTML = y;
			y++;
		}
	});

	// Rewrite columns lines for numeric order asc by click to th
	$( "input" ).keyup(function() {
		var lines = $( "td[name='lines']" );
		var y = 1;
		for(i=0;i<lines.length;i++){
			lines[i].innerHTML = y;
			y++;
		}
	});

	// Rewrite columns lines for numeric order asc by click to th
	$( "div.dataTablesContainer" ).click(function() {
		var lines = $( "td[name='lines']" );
		var y = 1;
		for(i=0;i<lines.length;i++){
			lines[i].innerHTML = y;
			y++;
		}
	});

} );

// Rewrite columns lines for numeric order asc
$( document ).ready(function() {
	var lines = $( "td[name='lines']" );
	var y = 1;
	for(i=0;i<lines.length;i++){
		lines[i].innerHTML = y;
		y++;
	}

});

