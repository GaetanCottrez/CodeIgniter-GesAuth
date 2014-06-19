function getXhr(){
	var xhr = null; 
	if(window.XMLHttpRequest) // Firefox et autres
	   xhr = new XMLHttpRequest(); 
	else if(window.ActiveXObject){ // Internet Explorer 
	   try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
	}
	else { // XMLHttpRequest non supporté par le navigateur 
	   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
	   xhr = false; 
	} 
	return xhr;
}

function FullAjax(xhr,DIV){
	// On défini ce qu'on va faire quand on aura la réponse
	xhr.onreadystatechange = function(){
		// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
		if(xhr.readyState == 4 && xhr.status == 200){
			LaDiv = xhr.responseText;
			var MyDiv = document.getElementById(DIV);
			// On se sert de innerHTML pour rajouter les options a la liste
			MyDiv.innerHTML = LaDiv;
			//Code permettant d'executé tout le javascript de la page appellé en ajax et non de le printé
			var body = document.getElementsByTagName("body")[0]; // on spécifie ou se trouve le javascript ici c'est dans <body></body>
			var scr;
			var scrajx = MyDiv.getElementsByTagName('script'); // on spécifie les balises où est contenu le javascript <script></script>
			for( var i in scrajx ) // boucle qui parcourt toutes les balises script et execute leur contenu
			{	scr = document.createElement("script");
				scr.type = "text/javascript";
				scr.text = scrajx[i].text;
				body.appendChild(scr);	
			}
			document.getElementById('notification').style.display='none';
		}
		else{
			document.getElementById('notification').style.display='';
		}
	}
}

//Permet un MyGo depuis une iframe interagissant avec le DOM parent
function MyGoModal(maChaine,conteneur,fichier){
	var xhr = getXhr();
	FullAjaxModal(xhr,conteneur);
	xhr.open("POST","ajax.php?page="+fichier,true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	//xhr.overrideMimeType('text/html; charset=ISO-8859-15');
	//alert(maChaine);
	xhr.send("ID="+maChaine);
}

//Permet un FullAjax personnalisé pour le MyGoModal
function FullAjaxModal(xhr,DIV){
	// On défini ce qu'on va faire quand on aura la réponse
	xhr.onreadystatechange = function(){
		// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
		if(xhr.readyState == 4 && xhr.status == 200){
			LaDiv = xhr.responseText;
			var MyDiv = window.parent.document.getElementById(DIV);
			// On se sert de innerHTML pour rajouter les options a la liste
			MyDiv.innerHTML = LaDiv;
			//Code permettant d'executé tout le javascript de la page appellé en ajax et non de le printé
			var body = document.getElementsByTagName("body")[0]; // on spécifie ou se trouve le javascript ici c'est dans <body></body>
			var scr;
			var scrajx = MyDiv.getElementsByTagName('script'); // on spécifie les balises où est contenu le javascript <script></script>
			for( var i in scrajx ) // boucle qui parcourt toutes les balises script et execute leur contenu
			{	scr = document.createElement("script");
				scr.type = "text/javascript";
				scr.text = scrajx[i].text;
				body.appendChild(scr);	
			}
			document.getElementById('notification').style.display='none';
		}
		else{
			document.getElementById('notification').style.display='';
		}
	}
}

function writediv(texte,div){
    document.getElementById(div).innerHTML = texte;
}

function chState(check, nom)
{
	var checkbox =document.getElementById(check);	
	var groupe = document.getElementById(nom).options[document.getElementById(nom).selectedIndex].value;
	
	if(checkbox.checked) 
	{
		checkbox.value='1'; 
		var vip = checkbox.value;
	}
   else
	{
	   checkbox.value='0';
	   var vip = checkbox.value;
	}
	MyGo(groupe+";"+vip,"ResultGroups","salesfunnel_groups");
}

// Test de l'unicité d'un champ
function unique(id,saisie,div,table,champ_table,page){
	 var xhr = getXhr();
	 FullAjax(xhr,div);
     xhr.open("POST","ajax.php?page="+page, true); 
	 xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	 //alert('saisie='+escape(saisie)+'&table='+escape(table)+'&champ='+escape(champ_table)+'&id='+escape(id));
     xhr.send('saisie='+escape(saisie)+'&table='+escape(table)+'&champ='+escape(champ_table)+'&id='+escape(id)); 
}

// Test de l'unicité d'un champ
function unique2(id,saisie,div,table,champ_table,champ_table2,page){
	 var xhr = getXhr();
	 FullAjax(xhr,div);
     xhr.open("POST","ajax.php?page="+page, true); 
	 xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	 var prefix = document.getElementById(id).value;
     xhr.send('saisie='+escape(saisie)+'&table='+escape(table)+'&champ='+escape(champ_table)+'&prefix='+escape(prefix)+'&champ2='+escape(champ_table2)); 
}

//Test d'un seul champ obligatoire
function vide(champ){
if (document.getElementById(champ).value != ""){
	$("#"+champ).addClass("idleField");
	$("#"+champ).removeClass("required");
	$("#error_"+champ).text("");
}
}


function verifCoef(saisie,div){
 var lasaisie;
 lasaisie = document.getElementById(saisie).value;
 lasaisie = lasaisie.replace(',','.');
 lasaisie = parseFloat(lasaisie);
	 if(lasaisie < 1.00){
		writediv('<span><img src="CSS/images/cancel.png" alt="graphique"></span>',div);}
	 else{
		writediv('<span><img src="CSS/images/OK.png" alt="graphique"></span>',div);}
}

function generatePrefix(idFamily,idMark,idSubFamily,idSubSubFamily,fichier,div){
	var xhr = getXhr();
	FullAjax(xhr,div);
	xhr.open("POST","ajax.php?page="+fichier,true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	var Family = document.getElementById(idFamily).value;
	var Mark = document.getElementById(idMark).value;
	var SubFamily = document.getElementById(idSubFamily).value;
	var SubSubFamily = document.getElementById(idSubSubFamily).value;
	//alert("family="+Family+"&mark="+Mark+"&subfamily="+SubFamily+"&subsubfamily="+SubSubFamily);
	xhr.send("family="+Family+"&mark="+Mark+"&subfamily="+SubFamily+"&subsubfamily="+SubSubFamily);
}
	 
function file(fichier){
	 xhr_object = getXhr() ;
	 xhr_object.open("POST", fichier, false); 
	 xhr_object.send(null); 
	 if(xhr_object.readyState == 4) return(xhr_object.responseText);
	 else return(false);
}

// Permet de rajouter un object à une pièce commerciale
function AddObjectOfLineBusinessRecords(varGlobal,Conteneur,fichier) {
	var xhr = getXhr();
	FullAjax(xhr,Conteneur);
	// Ici on va voir comment faire du post
	xhr.open("POST","ajax.php?page="+fichier,true);
	// ne pas oublier ça pour le post
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	// ne pas oublier de poster les arguments
	// ici
	xhr.send("num="+varGlobal);

}

// Permet de rajouter une partie identique d'un formulaire dynamiquement
function Add_part_of_form(i,IdLeselect,fichier) {
	var i2 = i + 1;
	var xhr = getXhr();
	FullAjax(xhr,IdLeselect);
	// Ici on va voir comment faire du post
	xhr.open("POST","ajax.php?page="+fichier,true);
	// ne pas oublier ça pour le post
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	// ne pas oublier de poster les arguments
	// ici
	xhr.send("num="+i2);

}

//Permet de rajouter une partie identique d'un formulaire dynamiquement
function Add_part_dynamic(i,IdLeselect,fichier,showAdd,nb) {
	nb = document.getElementById(nb).value;
	for(y=1;y<nb;y++){
		if(document.getElementById(showAdd+'_'+y) != undefined){
			$('#'+showAdd+'_'+y).show();
		}
	}
	var xhr = getXhr();
	FullAjax(xhr,IdLeselect);
	// Ici on va voir comment faire du post
	xhr.open("POST","ajax.php?page="+fichier,true);
	// ne pas oublier ça pour le post
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	// ne pas oublier de poster les arguments
	// ici
	xhr.send("num="+i);

}

// Permet de supprimer un fournisseur dynamiquement en vérifiant qu'il n'est pas par défaut
function del_part_of_form(parent, child, radio){
	var btn = document.getElementById(radio).checked;
	//alert(btn);
	if (btn == false){
		var obj = document.getElementById(parent);

		var old = document.getElementById(child);

		obj.removeChild(old);
	}
	else{
		jAlert("Impossible de supprimer le fournisseur par défaut !");
	}

}

// Permet de supprimer un fournisseur dynamiquement en vérifiant qu'il n'est pas par défaut
function del_div(texte,title,divAdd,div){
jConfirm(texte, title, function(r) {
	var val = r;
		if (val !=false){
		var obj = document.getElementById(divAdd);

		var old = document.getElementById(div);

		obj.removeChild(old);
		}
	});


}

// Permet de recuperer la valeur dans une liste déroulante ou l'id n'est pas généré dynamiquement
function go(IdLeselect,leId,ID,fichier){
	var xhr = getXhr();
	FullAjax(xhr,IdLeselect);
	// Ici on va voir comment faire du post
	xhr.open("POST","ajax.php?page="+fichier,true);
	// ne pas oublier ça pour le post
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	// ne pas oublier de poster les arguments
	// ici
	sel = document.getElementById(leId);
	ID = sel.options[sel.selectedIndex].value;
	xhr.send(leId+"="+ID);
}

//Permet de recuperer la valeur dans uninput ou l'id n'est pas généré dynamiquement
function goInput(input,leId,ID,fichier){
	var xhr = getXhr();
	FullAjax(xhr,input);
	// Ici on va voir comment faire du post
	xhr.open("POST","ajax.php?page="+fichier,true);
	// ne pas oublier ça pour le post
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	// ne pas oublier de poster les arguments
	// ici
	sel = document.getElementById(leId);
	ID = sel.value;
	xhr.send(leId+"="+ID);
}

//Permet de passer ses propres paramètres non contenu dans des champs
function MyGo(maChaine,conteneur,fichier){
	var xhr = getXhr();
	FullAjax(xhr,conteneur);
	xhr.open("POST","ajax.php?page="+fichier,true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	//xhr.overrideMimeType('text/html; charset=ISO-8859-15');
	//alert(maChaine);
	xhr.send("ID="+maChaine);
}

// Permet de recuperer la valeur dans une liste déroulante où l'id a été générée dynamiquement
function goDynamique(IdLeselect,leId,ID,fichier,num){
	var xhr = getXhr();
	FullAjax(xhr,IdLeselect);
	// Ici on va voir comment faire du post
	xhr.open("POST","ajax.php?page="+fichier,true);
	// ne pas oublier ça pour le post
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	// ne pas oublier de poster les arguments
	// ici
	sel = document.getElementById(leId);
	ID = sel.options[sel.selectedIndex].value;
	leId = "leId";
	//alert(leId+"="+ID+"&num="+num);
	xhr.send(leId+"="+ID+"&num="+num);
}

// Permet de recuperer la valeur dans deux champs input
function goDynamique2(IdLeselect,leId1,leId2,ID1,ID2,fichier,choice,radio){
	if(choice == true){
		if(document.getElementById(radio) != null){
			targetElement = document.getElementById(radio).checked;
		}else{
			targetElement = false;
		}
		if(targetElement == true){
			var xhr = getXhr();
			FullAjax(xhr,IdLeselect);
			// Ici on va voir comment faire du post
			xhr.open("POST","ajax.php?page="+fichier,true);
			// ne pas oublier ça pour le post
			xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			// ne pas oublier de poster les arguments
			// ici
			sel1 = document.getElementById(leId1);
			sel2 = document.getElementById(leId2);
			ID1 = sel1.value;
			ID2 = sel2.value;
			leId1 = "leId";
			xhr.send(leId1+"="+ID1+"&"+leId2+"="+ID2);
		}
	}
	else{
		var xhr = getXhr();
		FullAjax(xhr,IdLeselect);
		// Ici on va voir comment faire du post
		xhr.open("POST","ajax.php?page="+fichier,true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici
		sel1 = document.getElementById(leId1);
		sel2 = document.getElementById(leId2);
		ID1 = sel1.value;
		ID2 = sel2.value;
		leId1 = "leId";
		xhr.send(leId1+"="+ID1+"&"+leId2+"="+ID2);
	}
}
	
	

// Fonction permettant de vérifié si l'élement n'est pas dejà choisi
function verif_choice_provider(SelectFournisseur,nb_provider,num,fichier,IdLeselect,prixVente,coefPrixListe,coefPrixImpose,prixVenteImpose){

	//alert(nb_provider);
	//alert(SelectFournisseur+"_"+num);
	sel = document.getElementById(nb_provider);
	y = sel.value;
	//sel = document.getElementById(SelectFournisseur+"_"+num);
	//Fournisseur_verif = sel.options[sel.selectedIndex].value;
	
	Fournisseur_verif = document.getElementById(SelectFournisseur+"_"+num).value;
	
	if (Fournisseur_verif != ""){
		//alert(y);
		//alert(Fournisseur_verif);
		Fournisseur = "";
		for (var i=1;i<y;i++){
			//alert(SelectFournisseur+"_"+i);
			sel = document.getElementById(SelectFournisseur+"_"+i);
			if(sel != null){
				if (SelectFournisseur+"_"+num != SelectFournisseur+"_"+i){
					//alert(sel);
					//Fournisseur = sel.options[sel.selectedIndex].value;
					Fournisseur = sel.value;
					//alert(Fournisseur == Fournisseur_verif);
					if(Fournisseur == Fournisseur_verif) {
						i=y;
						document.getElementById(SelectFournisseur+"_"+num).value = '';
						jAlert("Ce fournisseur a déjà été choisi","Fournisseur existant", function(r) {
			    			if( r == true) document.getElementById(SelectFournisseur+"_"+num).value = '';});
					}
				}
			}
		}
	}else{
		MyGo(document.getElementById('SelectFournisseur_'+num).value,'NameProvider_'+num,'recup_name_provider')
		//goDynamique('NameProvider_'+num,'SelectFournisseur_'+num,'leId','recup_name_provider',num);
		//saisie_or_not('SelectFournisseur_'+num, 'refFournisseur_'+num+';prixAchat_'+num, prixVente+';'+coefPrixListe+';'+coefPrixImpose+';'+prixVenteImpose);	
	}
}

// Fonction permettant d'afficher ou de cacher les elements d'un DIV
function afficher_cacher(nb_provider,Id,cacherDelete,SelectFournisseur,prixAchat){
var y = parseInt(document.getElementById(nb_provider).value); 
y = y + 1;
//alert(y);
//alert(Id);
	for (var i=1;i<y;i++){
		var targetElement;
		targetElement = document.getElementById(Id+"_"+i);
		//alert(i +" "+document.getElementById(Id+"_"+i));
		if (targetElement != null){
		targetElement = document.getElementById(Id+"_"+i).checked ;
		
			if (targetElement == false){
				$("#"+cacherDelete+"_"+i).show();
				$("label[for="+Id+"_"+i+"]").removeClass();
				$("label[for="+Id+"_"+i+"]").text("Fournisseur *");
				$("#"+SelectFournisseur+"_"+i).removeClass();
			}
			else{
				$("#"+cacherDelete+"_"+i).hide();
				$("label[for="+Id+"_"+i+"]").addClass("object_default"); 
				$("label[for="+Id+"_"+i+"]").text("Fournisseur par défaut *");
				$("#"+SelectFournisseur+"_"+i).addClass("object_default_list");
			}
		}
	}	
}

function saisie_or_not(NameProvider,chaine1,chaine2){
	//alert(document.getElementById(NameProvider).value);
	if (document.getElementById(NameProvider).value != ""){
		var reg = new RegExp("[;]+", "g");
		var tableauChaine = chaine1.split(reg);
		for (var i=0; i<tableauChaine.length; i++) {
			$("#"+tableauChaine[i]).attr({ disabled : "" , value : "" });
		}
		
		var reg = new RegExp("[;]+", "g");
		var tableauChaine = chaine2.split(reg);
		for (var i=0; i<tableauChaine.length; i++) {
			$("#"+tableauChaine[i]).attr({ value : "" });
		}
		//alert("je bloque");
	}
	else{
		//alert("je ne bloque pas");
		var reg = new RegExp("[;]+", "g");
		var tableauChaine = chaine1.split(reg);
		for (var i=0; i<tableauChaine.length; i++) {
			$("#"+tableauChaine[i]).attr({ disabled : "disabled" , value : "" });
		}
		
		var reg = new RegExp("[;]+", "g");
		var tableauChaine = chaine2.split(reg);
		for (var i=0; i<tableauChaine.length; i++) {
			$("#"+tableauChaine[i]).attr({ value : "" });
		}
		
	}
}

function select_option_default(val,nb_choix,input1,input2,input3,input4){
	sel = document.getElementById(val);
	ID = sel.options[sel.selectedIndex].value;
	valeur = ID;
	switch (ID) {
	 case "1":
		//alert(document.getElementById(input1).value); display_prix_vente
		if (document.getElementById(input1).value != ""){
			var price = document.getElementById(input1).value;
		}
		else{
			var price = 0;
		}
		 //alert("choix 1");
		
		document.getElementById('display_prix_vente').style.display='';
		document.getElementById('display_prix_liste_impose').style.display='none';
		document.getElementById('display_prix_vente_impose').style.display='none';
		document.getElementById('display_coef_marge_impose').style.display='none';
		
		 break;
		 
	 case "2":
		//alert(document.getElementById(input2).value);
		if (document.getElementById(input2).value != ""){
			var price = document.getElementById(input2).value;
		}
		else{
			var price = 0;
		}
		// alert("choix 2");
		document.getElementById('display_prix_vente').style.display='none';
		document.getElementById('display_prix_liste_impose').style.display='';
		document.getElementById('display_prix_vente_impose').style.display='none';
		document.getElementById('display_coef_marge_impose').style.display='none';
		 break;
		 
	 case "3":
		//alert(document.getElementById(input3).value);
		if (document.getElementById(input3).value != ""){
			var price = document.getElementById(input3).value;
		}
		else{
			var price = 0;
		}
		// alert("choix 3");
		document.getElementById('display_prix_vente').style.display='none';
		document.getElementById('display_prix_liste_impose').style.display='none';
		document.getElementById('display_prix_vente_impose').style.display='';
		document.getElementById('display_coef_marge_impose').style.display='none';
		break;
		 
	 case "4":
		//alert(document.getElementById(input4).value);
		if (document.getElementById(input4).value != ""){
			var price = document.getElementById(input4).value;
		}
		else{
			var price = 0;
		}
		 //alert("choix 4");
		document.getElementById('display_prix_vente').style.display='none';
		document.getElementById('display_prix_liste_impose').style.display='none';
		document.getElementById('display_prix_vente_impose').style.display='none';
		document.getElementById('display_coef_marge_impose').style.display='';
		 break;
	}
	
	var price2 = parseFloat(price);
//	if(price2 != 0){
		var compteur = parseInt(nb_choix) +1;
		for (var i=1;i<compteur;i++){
			var verif = valeur == i;
			if (verif == false){
				$("label[for=fixer_"+i+"]").removeClass();
			}	
			else{
				$("label[for=fixer_"+i+"]").addClass("object_default"); 
			}
		}
//	}
//	else{
//		//alert(ID);
//		jAlert("Vous ne pouvez pas fixer sur un prix à 0 ou inexistant !");
//		document.getElementById(val).selectedIndex = 0;
//		sel = document.getElementById(val);
//		ID = sel.options[sel.selectedIndex].value;
//		valeur = ID;
//		var compteur = parseInt(nb_choix) +1;
//		for (var i=1;i<compteur;i++){
//			var verif = valeur == i;
//			if (verif == false){
//				$("label[for=fixer_"+i+"]").removeClass();
//			}	
//			else{
//				$("label[for=fixer_"+i+"]").addClass("object_default"); 
//			}
//		}
//	}
}

// Fonction permettant la suppression d'une partie d'un formulaire avec un message d'avertissement personnalisé
function confirm_del(texte,title,divAddProvider,default_provider,div,recupNameProvider){
//alert(recupNameProvider);
sel = document.getElementById(recupNameProvider);
ID = sel.value;
jConfirm(texte+" "+ID+" ?", title, function(r) {
var val = r;
	if (val !=false){
	//alert(divAddProvider);
	//alert(div);
	//alert(default_provider);
	del_part_of_form(divAddProvider,div,default_provider);
	}
});
}

function lookup(inputString,fichier,sugges,autoSugges,recup) {
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#'+sugges).hide();
	} else {
		$.post("ajax.php?page="+fichier, {queryString: ""+inputString+"", recup: ""+recup+"", sugges: ""+sugges+""}, function(data){
			if(data.length >0) {
				$('#'+sugges).show();
				$('#'+autoSugges).html(data);
			}
		});
	}
} // lookup
	
function fill(thisValue,input,sugges) {
	$('#'+input).val(thisValue);
	setTimeout("$('#"+sugges+"').hide();", 200);
}