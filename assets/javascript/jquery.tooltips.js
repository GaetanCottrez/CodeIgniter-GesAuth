/** 
 * Tool Tips 
 * par Jay Salvat - http://blog.jaysalvat.com/ 
 *
 * Article:
 * http://blog.jaysalvat.com/articles/creez-votre-propre-plugin-jquery-infobulles.php
 */ 
(function($) { 
$.fn.toolTips = function(settings) {     
    options =  { 
		click: true,
        offsetX:    10, 
        offsetY:    -5,
        delay:      100,
        baseLine:   'middle'
    }; 
    var options = $.extend(options, settings); 
     
    return this.each(function(){ 
        var $$ = $(this); 
        var aTitle   = $$.attr('title') || ''; 
        var aHref    = $$.attr('href')  || ''; 
        var aRel     = $$.attr('rel')   || ''; 
        var aToolTip = $("<div></div>");
        var aCaption = '';
        var aImage;
        var timer;
        //var offsetX = 1;
        //var offsetY = 1;
        var offsetX = -15;
        var offsetY = 15;

        // Quand le curseur survole un élément 
        $$.mouseover(function(e) {           
            // Supprime le Title pour éviter le tooltip par défaut du navigateur 
            $$.attr('title', '');    
             
            // Si un Title est présent, on fait un block pour la légende 
            if (aTitle) { 
                aCaption = '<div class="toolTip-caption"><span>'+ aTitle +'</span></div>'; 
            }
			
            // Si un attribut Rel est présent dans le lien et qu'il mene a une image 
            // on passe en mode Vignette 
            if (aRel.match(/\.(png|jpg|jpeg|gif)$/)) { 
                aImage = $('<img src="'+ aRel +'" />');
                aToolTip = $('<div class="toolTip-thumbnail">'+ aCaption +'</div>'); 
 
            // Si le lien est un lien vers une image 
            // on passe en mode Prévisualisation 
            } else if (aHref.match(/\.(png|jpg|jpeg|gif)$/)) { 
                aImage = $('<img src="'+ aHref +'" />');
                aToolTip = $('<div class="toolTip-picture">'+ aCaption +'</div>'); 
                
            // Sinon on pas en mode Texte
            } else if (aTitle) {
                aToolTip = $("<div class='toolTip-text'><span>"+ aTitle +"</span></div>");     
            } 

            // Le toolTip précédemment créé est ajouté au Body et masqué
            aToolTip.appendTo("body").hide().css({ position:'absolute', top:0, left:0 });

            // On attend le chargement de l'image éventuellement contenue
            // dans le toolTip pour ajuster le placement selon la hauteur finale
            if ((aImage)) {
                aImage.load(function() {
                    aImage.prependTo(aToolTip);
                    
                    offsetX = options.offsetX;
                    if (options.baseLine == 'bottom') {
                        offsetY = options.offsetY - aToolTip.height();
                    } else if (options.baseLine == 'middle') {
                        offsetY = options.offsetY - (aToolTip.height() / 2);
                    }

                    // Place le toolTip aux coordonnées voulues
                    aToolTip.css({
                        left: parseInt(aToolTip.css('left')) + offsetX + "px",
                        top:  parseInt(aToolTip.css('top'))  + offsetY + "px"                            
                    });
                });
            }

            // On déplace le toolTip en meme temps que la souris 
            $$.mousemove(function(e) { 
                aToolTip.css({
                    left: e.pageX + offsetX + "px",
                    top:  e.pageY + offsetY + "px"                            
                });
            }); 
            
            // On attend quelques fractions de seconde avant d'afficher le toolTip
            timer = setTimeout( function() { aToolTip.show() }, options.delay);
        }) 
            
        // Quand le curseur ne survole plus un élément 
        $$.mouseout(function(e) { 
            clearTimeout(timer);
            // On remet le Title en place 
            $$.attr("title", aTitle);   
            // On supprime le suivi de déplacement 
            $$.unbind("mousemove");      
            // On supprime le toolTip 
            aToolTip.remove(); 
        });
		
		// Bloque éventuellement le click sur le lien
		$$.click(function() {
			return options.click;
		});     
    }); 
}; 
})(jQuery); 