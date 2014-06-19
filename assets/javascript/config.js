/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.removePlugins = 'elementspath';
	config.scayt_sLang = 'fr_FR';
	//config.scayt_autoStartup = true;
	config.ToolbarStartExpanded = false;
	config.disableNativeSpellChecker = false;
	config.width = 800;
	config.height = 300;
	config.language = 'fr';
	config.contentsLanguage = 'fr';
	config.defaultLanguage = 'fr';
	config.enterMode = CKEDITOR.ENTER_BR; 
	config.scayt_uiTabs = '0,1,0';
	config.resize_enabled = false;
	config.tabSpaces = 4;
	config.toolbar = 'MyToolbar';
	 
    config.toolbar_MyToolbar =
    [
        ['Bold','Italic','Underline','Strike','-','Undo','Redo','-','Find','Replace','-','SelectAll','-'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt']
    ];
	
};
