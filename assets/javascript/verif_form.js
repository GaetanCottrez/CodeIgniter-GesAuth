function add_membership(form_id,name,file) {
	 
	// Gets the element before which the new box will be added
	var element = document.getElementById('after');
	// Get a reference to the parent element
	var parentDiv = element.parentNode;
	
 // create the new "file" <input>, and its attributes
  var new_el = document.createElement("div");
  var number = document.getElementById('nb_membership').value;
  new_el.setAttribute("id", 'div_'+number);
  if(file != "") MyGo(number,'div_'+number,file);
  //parentDiv.insertBefore(new_el, element);
  parentDiv.insertBefore(new_el, element.nextSibling);
}

function trim (myString){
	return myString.replace(/^\s+/g,'').replace(/\s+$/g,'').replace('\xC2','').replace('\x8B','')
}

function add_DOM_element(form_id,BaliseHTML,type,name,BoolID,file) {
	 
	// Gets the element before which the new box will be added
	var element = document.getElementById('after');
	// Get a reference to the parent element
	var parentDiv = element.parentNode;
	
 // create the new "file" <input>, and its attributes
  var new_el = document.createElement(BaliseHTML);
  new_el.setAttribute("type", type);
  new_el.setAttribute("name", name);
  parentDiv.insertBefore(new_el, element);
  if(BoolID == 1){ 
	  var number = document.getElementsByName(name).length;
	  new_el.setAttribute("id", name.replace('[]','')+'_'+number);
  }
  if(file != "") MyGo('',name.replace('[]','')+'_'+number,file)
  var new_el = document.createElement("br");
  parentDiv.insertBefore(new_el, element);
}

function GenerateLoginContact(container) {
	 
	var firstName = document.getElementById('firstName').value;
	var Name = document.getElementById('Name').value
	
	Name=Name.replace(/[àáâä]/g,"a");
	Name=Name.replace(/[èéêë]/g,"e");
	Name=Name.replace(/[ìíîï]/g,"i");
	Name=Name.replace(/[òóôö]/g,"o");
	Name=Name.replace(/[ùúûü]/g,"u");
	Name=Name.replace(/[ýÿ]/g,"y");
	Name=Name.replace(/[ç]/g,"c");
	Name=Name.replace(/[']/g,"");
	Name=Name.replace(/[ ]/g,"");
	
	//alert(Name);
	
	firstName=firstName.replace(/[àáâä]/g,"a");
	firstName=firstName.replace(/[èéêë]/g,"e");
	firstName=firstName.replace(/[ìíîï]/g,"i");
	firstName=firstName.replace(/[òóôö]/g,"o");
	firstName=firstName.replace(/[ùúûü]/g,"u");
	firstName=firstName.replace(/[ýÿ]/g,"y");
	firstName=firstName.replace(/[ç]/g,"c");
	firstName=firstName.replace(/[']/g,"");
	firstName=firstName.replace(/[ ]/g,"");
	
	//alert(container);
	document.getElementById(container).value = firstName.toLowerCase()+'.'+Name.toLowerCase();

}

// Permet de charger une valeur dans un champ
function load_value(ID,valeur){
	document.getElementById(ID).value = valeur;
}

// Renvoi la valeur d'une liste de bouton radio en fonction de son name
function getRadioValue(name){
    var lstRadios = document.getElementsByName(name);
    var radio = 0;
    for(var i=0; i<lstRadios.length; i++){
    	if(lstRadios[i].checked == true){
    		radio = i+1;
    	}
    }

    return radio;
}

function MoveDivTotal(div){
	if(document.getElementById(div) != undefined) document.getElementById(div).innerHTML = '<HR style="width: 20%; text-align: right; margin: 0 5px 0 auto;"> <p /><p /> <div style="float:right;"> <table> <tr> <td style="width:160px;">Total sans taxes : </td> <td style="text-align:right;min-width:60px;"><span id="total_sans_taxes">0,00</span><input type="hidden" id="input_total_sans_taxes" name="input_total_sans_taxes" value="0" /></td> </tr> </table> <table> <tr> <td style="width:160px;">Taxes : </td> <td style="text-align:right;min-width:60px;"><span id="total_taxes">0,00</span><input type="hidden" id="input_total_taxes" name="input_total_taxes" value="0" /></td> </tr> </table> <table> <tr> <td style="width:160px;">Total avec taxes : </td> <td style="text-align:right;min-width:60px;"><span id="alltotal">0,00</span></td></tr> </table><table> <tr> <td style="width:160px;">Nombre de lignes cochées : </td> <td style="text-align:right;min-width:60px;"><span id="totallines">0</span></td> </tr> </table>';
}

function DisabledOrNotTrademark(){
	var total = document.getElementById('total').value;
	var Customer = getRadioValue('select_customer');
	
	var lstRadios = document.getElementsByName('select_customer');
    var Customer = 0;
    for(var i=0; i<lstRadios.length; i++){
    	if(lstRadios[i].checked == true){
    		Customer = lstRadios[i].value;
    	}
    }
	    
	var lstRadios = document.getElementsByName('select_trademark');
	 var radio = 0;
    init = false;
    document.getElementById('total-div').innerHTML ='';
    for(var i=0; i<lstRadios.length; i++){
    	if(i == Customer){
			if(document.getElementById('total-div'+i) != undefined) document.getElementById('total-div'+i).innerHTML = '<HR style="width: 20%; text-align: right; margin: 0 5px 0 auto;"> <p /><p /> <div style="float:right;"> <table> <tr> <td style="width:160px;">Total sans taxes : </td> <td style="text-align:right;min-width:60px;"><span id="total_sans_taxes">0,00</span><input type="hidden" id="input_total_sans_taxes" name="input_total_sans_taxes" value="0" /></td> </tr> </table> <table> <tr> <td style="width:160px;">Taxes : </td> <td style="text-align:right;min-width:60px;"><span id="total_taxes">0,00</span><input type="hidden" id="input_total_taxes" name="input_total_taxes" value="0" /></td> </tr> </table> <table> <tr> <td style="width:160px;">Total avec taxes : </td> <td style="text-align:right;min-width:60px;"><span id="alltotal">0,00</span></td></tr> </table><table> <tr> <td style="width:160px;">Nombre de lignes cochées : </td> <td style="text-align:right;min-width:60px;"><span id="totallines">0</span></td> </tr> </table>';
		}else{
			if(document.getElementById('total-div'+i) != undefined) document.getElementById('total-div'+i).innerHTML = "";
		}
    	if(lstRadios[i].value == Customer){
    		lstRadios[i].disabled = false;
    		//alert(lstRadios[i].checked);
    		if(lstRadios[i].checked == true){
    			for(var y=0; y<total; y++){
    				if(document.getElementById(y) != null){
    					//alert(document.getElementById(y).value+' == '+i+'_'+Customer);
	    				if(document.getElementById(y).value == i+'_'+Customer){
	    					document.getElementById(y).disabled = false;
	    					document.getElementById(y).checked = true;
	    				}else{
	    					document.getElementById(y).disabled = true;
	    					document.getElementById(y).checked = false;
	        			}
    				}
    			}
    			init = true;
    		}
    	}else{
    		lstRadios[i].disabled = true;
    		lstRadios[i].checked = false;
    		if(lstRadios[i].checked == true){
    			for(var y=0; y<total; y++){
    				if(document.getElementById(y) != null){
	    				if(document.getElementById(y).value == i+'_'+Customer){
	    					document.getElementById(y).disabled = false;
	    					document.getElementById(y).checked = true;
	    				}else{
	    					document.getElementById(y).disabled = true;
	    					document.getElementById(y).checked = false;
	        			}
    				}
    			}
    		}
    	}
    }
    
    if(init == false){
    	for(var y=0; y<total; y++){
			if(document.getElementById(y) != null){
				document.getElementById(y).disabled = true;
				document.getElementById(y).checked = false;
			}
		}
    }
}

function DisabledOrNotTrademark2(){
	var total = document.getElementById('total').value;
	var Customer = getRadioValue('select_customer');
	
	var lstRadios = document.getElementsByName('select_customer');
    var Customer = 0;
    for(var i=0; i<lstRadios.length; i++){
    	if(lstRadios[i].checked == true){
    		//alert(lstRadios[i].value);
    		Customer = lstRadios[i].value;
    	}
    }
	    
	var lstRadios = document.getElementsByName('select_trademark');
	 var radio = 0;
    init = false;
    document.getElementById('total-div').innerHTML ='';
    //alert(lstRadios.length);
    for(var i=0; i<lstRadios.length; i++){
    	//alert(lstRadios[i].value+' == '+Customer);
    	if(lstRadios[i].value == Customer){
			if(document.getElementById('total-div'+lstRadios[i].value) != undefined) document.getElementById('total-div'+lstRadios[i].value).innerHTML = '<HR style="width: 20%; text-align: right; margin: 0 5px 0 auto;"> <p /><p /> <div style="float:right;"> <table> <tr> <td style="width:160px;">Total sans taxes : </td> <td style="text-align:right;min-width:60px;"><span id="total_sans_taxes">0,00</span><input type="hidden" id="input_total_sans_taxes" name="input_total_sans_taxes" value="0" /></td> </tr> </table> <table> <tr> <td style="width:160px;">Taxes : </td> <td style="text-align:right;min-width:60px;"><span id="total_taxes">0,00</span><input type="hidden" id="input_total_taxes" name="input_total_taxes" value="0" /></td> </tr> </table> <table> <tr> <td style="width:160px;">Total avec taxes : </td> <td style="text-align:right;min-width:60px;"><span id="alltotal">0,00</span></td></tr> </table><table> <tr> <td style="width:160px;">Nombre de lignes cochées : </td> <td style="text-align:right;min-width:60px;"><span id="totallines">0</span></td> </tr> </table>';
		}else{
			if(document.getElementById('total-div'+lstRadios[i].value) != undefined) document.getElementById('total-div'+lstRadios[i].value).innerHTML = "";
		}
    	if(lstRadios[i].value == Customer){
    		lstRadios[i].disabled = false;
    		//alert(Customer);
    		if(lstRadios[i].checked == true){
    			for(var y=0; y<total; y++){
    				if(document.getElementById(y) != null){
    					//alert(document.getElementById(y).value+' == '+lstRadios[i].value+'_'+Customer);
	    				if(document.getElementById(y).value == lstRadios[i].value+'_'+Customer){
	    					document.getElementById(y).disabled = false;
	    					document.getElementById(y).checked = true;
	    				}else{
	    					document.getElementById(y).disabled = true;
	    					document.getElementById(y).checked = false;
	        			}
    				}
    			}
    			init = true;
    		}
    	}else{
    		lstRadios[i].disabled = true;
    		lstRadios[i].checked = false;
    		if(lstRadios[i].checked == true){
    			for(var y=0; y<total; y++){
    				if(document.getElementById(y) != null){
	    				if(document.getElementById(y).value == i+'_'+Customer){
	    					document.getElementById(y).disabled = false;
	    					document.getElementById(y).checked = true;
	    				}else{
	    					document.getElementById(y).disabled = true;
	    					document.getElementById(y).checked = false;
	        			}
    				}
    			}
    		}
    	}
    }
    
    if(init == false){
    	for(var y=0; y<total; y++){
			if(document.getElementById(y) != null){
				document.getElementById(y).disabled = true;
				document.getElementById(y).checked = false;
			}
		}
    }
}

// Permet de calculer le prix d'achat spécial chez un fournisseur pour un client en fonction d'un pourcentage imposé par le fournisseur (Uplift)
function Uplift(){
	var m = document.getElementById('tableLineBusinessRecords').rows.length; 
	//alert(m);
	var uplift = document.getElementById('uplift').value /100; 
	//alert(uplift);
	for(i=0;i<m;i++){
		if(document.getElementById('ConstructorPrice_'+i) != undefined){
			var ConstructorPrice = document.getElementById('ConstructorPrice_'+i).value;
			ConstructorPrice = parseFloat(ConstructorPrice.replace(',','.'));
			document.getElementById('SupplierPrice_'+i).value = format(ConstructorPrice / (1 - uplift),2,'.');
			if(ConstructorPrice != 0){
				var PAO = parseFloat(document.getElementById('TDPriceSupplier_'+i).innerHTML.replace(',','.')); 
				document.getElementById('TDDiscount_'+i).innerHTML = format(((1-(ConstructorPrice / (1 - uplift))/PAO))*100,2,'.');
			}
		}
	}
}

// fonction permettant de formater les chiffres en choissisant le nombre après la virgule et le séparateur des milliers
function format(valeur,decimal,separateur) {
	// formate un chiffre avec 'decimal' chiffres après la virgule et un separateur
		var deci=Math.round( Math.pow(10,decimal)*(Math.abs(valeur)-Math.floor(Math.abs(valeur)))) ; 
		var val=Math.floor(Math.abs(valeur));
		//alert(val);
		//alert(deci);
		if(!isNaN(deci)){
			//alert(val);
			//alert(deci);
			if ((decimal==0)||(deci==Math.pow(10,decimal))) {val=Math.floor(Math.abs(valeur)); deci=0;}
			var val_format=val+"";
			var nb=val_format.length;
			for (var i=1;i<4;i++) {
				if (val>=Math.pow(10,(3*i))) {
					//alert(val_format.substring(0,nb-(3*i)));
					//alert(val_format.substring(nb-(3*i)));
					val_format=val_format.substring(0,nb-(3*i))+separateur+val_format.substring(nb-(3*i));
				}
			}
			//alert(decimal);
			if (decimal>0) {
				var decim=""; 
				for (var j=0;j<(decimal-deci.toString().length);j++) {decim+="0";}
				deci=decim+deci.toString();
				val_format=val_format+","+deci;
			}
			if (parseFloat(valeur)<0) {val_format="-"+val_format;}
			val_format = val_format.replace()
			return val_format;
		}else{
			return valeur;
		}
}

// Permet de renvoyer les coordonnées d'un clic
function localiser(e) {
	if (navigator.appName == "Netscape")
	{document.captureEvents(Event.CLICK);}
	if (navigator.appName == "Microsoft Internet Explorer")
	{sX = event.clientX; sY = event.clientY;}
	else {sX = e.pageX;sY = e.pageY;}
	//alert("Coordonnées du clic x = " + sX + " et y = " + sY);
	
	return sX+';'+sY
}

function getHTTPObject() {
	var xmlhttp;
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		try {
			xmlhttp = new XMLHttpRequest();
		xmlhttp.overrideMimeType("text/xml"); 
		} catch (e) {
			xmlhttp = false;
		}
	}
	return xmlhttp;
}

function CocheCkeckbox(type_coche){
	if(type_coche == 1) type_coche = true; else type_coche = false;
	   var taille = document.forms['formulaire'].elements.length;
	   var element = null;
	   for(i=0; i < taille; i++){
	      element = document.forms['formulaire'].elements[i];
	      if(element.type == "checkbox")
	         element.checked = type_coche;
	   }    
}

function CocheCheckbox(checkbox,total){
	   var Total = document.getElementById(total).value;
	   for(i=0;i<Total;i++){
		   //alert(document.getElementById(i));
		   if(document.getElementById(i) != null && document.getElementById(i).disabled == false){
			   document.getElementById(i).checked = checkbox;
			   if($('#'+i).is(':checked')){ $('#'+i).parent().parent().addClass('selectedrow'); }else{ $('#'+i).parent().parent().removeClass('selectedrow'); }
		   }
	   }   
}

function pageDim() {
	var w, h;
	
	// firefox is ok
	h = document.documentElement.scrollHeight;
	w = document.documentElement.scrollWidth;
	
	// now IE 7 + Opera with "min window"
	if ( document.documentElement.clientHeight > h ) { h  = document.documentElement.clientHeight; }
	if ( document.documentElement.clientWidth > w ) { w  = document.documentElement.clientWidth; }
	
	// last for safari
	if ( document.body.scrollHeight > h ) { h = document.body.scrollHeight; }
	if ( document.body.scrollWidth > w ) { w = document.body.scrollWidth; }
	return h;
}

function CreditRating(default_field,field){
	var default_field2 = document.getElementById(default_field).value;
	default_field2 = parseFloat(default_field2.replace(",","."));
	var field2 = document.getElementById(field).value;
	field2 = parseFloat(field2.replace(",","."));
	if(field2 > default_field2){
		default_field2 = default_field2.toFixed(2);
		document.getElementById(field).value = format(default_field2,2,'.');
	}else{
		field2 = field2.toFixed(2);
		document.getElementById(field).value = format(field2,2,'.');
	}
}
function SetValueCKEDITOR(ID,valeur){
	CKEDITOR.instances[ID].setData(valeur);
}

function refreshpage(page) { 
	top.location.href = page;
}

function AdditionalSetValueCKEDITOR(ID,valeur){
	var val = CKEDITOR.instances[ID].getData();
	if(val != ""){
		val = val+'<br />'+ valeur;
	}
	else{
		val = valeur;
	}
	CKEDITOR.instances[ID].setData(val);
}

function switchCompany(div1,div2,company,checkbox,orientation,tb1,tb2){
	
	
		var ckbx = document.getElementById(checkbox).checked;
		switch (company){
		case '1':
			
			
			
			if(orientation==1){
				document.getElementById(tb1).style.display='';
				document.getElementById(tb2).style.display='none';
				document.getElementById(div1).style.display='none';
				document.getElementById(div2).style.display='none';
			} else{
				if (orientation==2){
					document.getElementById(div1).style.display='';
					document.getElementById(div2).style.display='none';
				}else {
					if (ckbx == true){
						document.getElementById(div1).style.display='';
					}
					document.getElementById(div2).style.display='none';
				}
			}
		break;	
		
		case '2':
			
			
			if(orientation==1){
				document.getElementById(tb1).style.display='none';
				document.getElementById(tb2).style.display='';
				document.getElementById(div1).style.display='none';
				document.getElementById(div2).style.display='none';
			} else {if (orientation ==2){
				document.getElementById(div2).style.display='';
				document.getElementById(div1).style.display='none';
			}else {
				if (ckbx == true){
					document.getElementById(div2).style.display='';
					}
				document.getElementById(div1).style.display='none';
					
			}
			}
		break;
		}
}




function visibilityByCheckBox(div,checkbox,type,getelement){
	if(type == null || type == undefined) type = true;
	if(getelement == null || getelement == undefined) getelement = 'id';
	var ckbx = document.getElementById(checkbox).checked;
	//alert(ckbx+','+type);
	
	switch(getelement){
		case 'name':
			var getElementDiv = document.getElementsByName(div);
			if(type == true){
				if (ckbx == true){
					for(var i=0; i<getElementDiv.length; i++){
						getElementDiv[i].style.display='';
					}
				}
				else{
					for(var i=0; i<getElementDiv.length; i++){
						getElementDiv[i].style.display='none';
					}
				}
			}
			else{
				if (ckbx == true){
					for(var i=0; i<getElementDiv.length; i++){
						getElementDiv[i].style.display='none';
					}
				}
				else{
					for(var i=0; i<getElementDiv.length; i++){
						getElementDiv[i].style.display='';
					}
				}
			}
		break;
		
		case 'id':
			if(type == true){
				if (ckbx == true){
					document.getElementById(div).style.display='';
				}
				else{
					document.getElementById(div).style.display='none';
				}
			}
			else{
				if (ckbx == true){
					document.getElementById(div).style.display='none';
				}
				else{
					document.getElementById(div).style.display='';
				}
			}
		break;
		
		default:
			if(type == true){
				if (ckbx == true){
					document.getElementById(div).style.display='';
				}
				else{
					document.getElementById(div).style.display='none';
				}
			}
			else{
				if (ckbx == true){
					document.getElementById(div).style.display='none';
				}
				else{
					document.getElementById(div).style.display='';
				}
			}
	}
}

function TotalByCheckbox(total_lines,total,total_sans_taxes,taxes,total_taxes,label_alltotal){
	total_lines = document.getElementById(total_lines).value;
	Total = 0;
	Total_taxes = 0;
	Total_lines = 0;
	for(i=0;i<total_lines;i++){
		if(document.getElementById(i) != null){
			var ckbx = document.getElementById(i).checked;
			
			if (ckbx == true){
				totalVar = document.getElementById(total+i).value;
				totalVar = totalVar.replace(".","");
				totalVar = parseFloat(totalVar.replace(",","."));
				
				taxesVar = document.getElementById(taxes+i).value;
				taxesVar = taxesVar.replace(".","");
				taxesVar = parseFloat(taxesVar.replace(",","."));
				
				Total = totalVar + Total;
				
				Total_taxes = taxesVar + Total_taxes;
				
				Total_lines = Total_lines +1;
			}
		}
	}
		
	Total = Total.toFixed(2);
	Total = parseFloat(Total);
	
	Total_taxes = Total_taxes.toFixed(2);
	Total_taxes = parseFloat(Total_taxes);
	//Total_taxes = Total_taxes.replace(".",",");

	document.getElementById(total_sans_taxes).innerHTML = format(Total,2,'.');
	document.getElementById(total_taxes).innerHTML = format(Total_taxes,2,'.');
	
	//Total = Total.replace(".","");
	//Total = parseFloat(Total.replace(",","."));
	
	//Total_taxes = Total_taxes.replace(".","");
	//Total_taxes = parseFloat(Total_taxes.replace(",","."));
	
	AllTotal = Total + Total_taxes;
	AllTotal = AllTotal.toFixed(2);
	//AllTotal = AllTotal.replace(".",",");
	
	document.getElementById(label_alltotal).innerHTML = format(AllTotal,2,'.');
	document.getElementById('totallines').innerHTML = Total_lines;
}

function SeeLinkForSubstitute(checkbox,obsolete,linkObsolete){
	var ckbx = document.getElementById(obsolete).checked;
	if (ckbx == true){
		$('#'+checkbox).attr("disabled","disabled");
		document.getElementById(linkObsolete).style.display='';
		document.getElementById(checkbox).checked=false;
	}else{
		$('#'+checkbox).removeAttr("disabled");
		document.getElementById(linkObsolete).style.display='none';
	}
}

function RegularizationContract(checkbox,inputValue,inputDefault,inputNews){
	var ckbx = document.getElementById(checkbox).checked;
	if (ckbx == true){
		document.getElementById(inputValue).value = document.getElementById(inputNews).value;
	}
	else{
		document.getElementById(inputValue).value = document.getElementById(inputDefault).value;
	}
}

function vider_element(element){
	document.getElementById(element).innerHTML= '';
}

function completer_element(element,value){
	document.getElementById(element).innerHTML= value;
}

function completer_element_with_link(element,value,link,classes){
	document.getElementById(element).innerHTML= "<a class="+classes+" href="+link+">"+value+"</a>";
}

function update_submit(element,value){
	var script = '<input type="hidden" id="submit-button" name="submit-button" value="'+value+'" />';
	document.getElementById(element).innerHTML= script;
}

function ajout_valeur(valeur,ID){
	if(document.getElementById(ID).value == ""){	
		document.getElementById(ID).value = valeur;
	}
}

function delete_valeur(valeur,ID){
	if(document.getElementById(ID).value == valeur){	
		document.getElementById(ID).value = "";
	}
}

function CleanReference(chaine,ID){
	//alert(window.event.keyCode);
	if(window.event.keyCode != 37 && window.event.keyCode != 38 && window.event.keyCode != 39 && window.event.keyCode != 40){
		var text = chaine.replace(new RegExp("[^a-zA-Z0-9_\s]"), "");
	
		text = text.toUpperCase();
		document.getElementById(ID).value = text;
	}
}

function verification_for_delete(elementToDelete,input,nb,delete_button){
	var count = 0;
	document.getElementById(elementToDelete).innerHTML= '';
	nb = document.getElementById(nb).value;
	for(i=1;i<nb;i++){
		if(document.getElementById(input+'_'+i) != undefined){
			count = count + 1;
		}
	}
	
	if(count == 1){
		for(i=1;i<nb;i++){
			if(document.getElementById(input+'_'+i) != undefined){
				$('#'+delete_button+'_'+i).hide();
			}
		}	
	}
}

function isOrditech(selectID,number){
	var SelectFournisseur = document.getElementById(selectID).value;
	//alert(SelectFournisseur) display_prix_vente_impose display_coef_marge_impose display_prix_liste_impose display_prix_vente
	if(SelectFournisseur == 'ORDITECH'){
		document.getElementById('display_reference_'+number).style.display='none';
		document.getElementById('display_prix_'+number).style.display='none';
		document.getElementById('refFournisseur_'+number).value='';
		document.getElementById('prixAchat_'+number).value='0';
		document.getElementById('prixVente').value='0';
		
		document.getElementById('display_prix_vente_impose').style.display='';
		document.getElementById('display_prix_vente').style.display='none';
		document.getElementById('display_coef_marge_impose').style.display='none';
		document.getElementById('display_prix_liste_impose').style.display='none';
		
		document.getElementById('SelectFixer').disabled = true;
		
		document.getElementById('SelectFixer').value = 3;
		//alert(document.getElementById('prixAchat_'+number).value);
	}else{
		document.getElementById('display_reference_'+number).style.display='';
		document.getElementById('display_prix_'+number).style.display='';
		//document.getElementById('refFournisseur_'+number).value='';
		//document.getElementById('prixAchat_'+number).value='';
		document.getElementById('display_prix_vente_impose').style.display='none';
		document.getElementById('display_prix_vente').style.display='';
		document.getElementById('display_coef_marge_impose').style.display='none';
		document.getElementById('display_prix_liste_impose').style.display='none';
		
		document.getElementById('SelectFixer').disabled = false;
		document.getElementById('SelectFixer').value = 1;
		
	}
}

function CalculatePriceArticle(default_provider,PrixAchat,type_price){
	var provider_value = document.getElementsByName(default_provider);
	for(var i=0; i<provider_value.length; i++){
		//alert(provider_value[i].checked);
		if(provider_value[i].checked) var Price = provider_value[i].value;
	}
	tab = Price.split('_');
	var Number = tab[2];
	//alert(Number);
	
	var PrixAchat = document.getElementById('prixAchat_'+Number).value;
	PrixAchat = PrixAchat.replace('.','');
	PrixAchat = parseFloat(PrixAchat.replace(',','.'));
	switch(type_price){
		case 2:
			var prixListe = document.getElementById('prixListe').value;
			if(prixListe != ""){
				prixListe = prixListe.replace('.','');
				prixListe = parseFloat(prixListe.replace(',','.'));
				var Field = prixListe/PrixAchat;
				Total = Field.toFixed(2);
				//Total = Total.replace(".",",");
				if(Total == 'Infinity' || Total == 'NaN'){ 
					Total = '';
				}else{
					Total= format(Total,2,'.');
				}
				document.getElementById('coefPrixListe').value = Total;
			}
			break;
			
		case 3:
			var prixListe = document.getElementById('prixVenteImpose').value;
			if(prixListe != ""){
				prixListe = prixListe.replace('.','');
				prixListe = parseFloat(prixListe.replace(',','.'));
				var Field = prixListe/PrixAchat;
				Total = Field.toFixed(2);
				//Total = Total.replace(".",",");
				if(Total == 'Infinity' || Total == 'NaN'){ 
					Total = '';
				}else{
					Total= format(Total,2,'.');
				}
				document.getElementById('coefPrixImpose').value = Total;
			}
			
			break;
			
		case 4:
			var prixListe = document.getElementById('coefMargeImpose').value;
			if(prixListe != ""){
				prixListe = prixListe.replace('.','');
				prixListe = parseFloat(prixListe.replace(',','.'));
				var Field = prixListe*PrixAchat;
				Total = Field.toFixed(2);
				//Total = Total.replace(".",",");
				if(Total == 'Infinity' || Total == 'NaN'){ 
					Total = '';
				}else{
					Total= format(Total,2,'.');
				}
				document.getElementById('prixVenteMargeImpose').value = Total;
			}
			break;
			
		default:
			var coefficient = document.getElementById('coefficient').value;
			coefficient = coefficient.replace('.','');
			coefficient = parseFloat(coefficient.replace(',','.'));
			
			var Field = coefficient*PrixAchat;
			Total = Field.toFixed(2);
			//Total = Total.replace(".",",");
			if(Total == 'Infinity' || Total == 'NaN'){ 
				Total = 0;
			}else{
				Total= format(Total,2,'.');
			}
			document.getElementById('prixVente').value = Total;
		
		
	}
	
}

function CalculateAnnualSubcription(){
	var x = document.getElementById('x').value;
	if(x != ''){
		x = parseFloat(x.replace(",","."));
	}
	
	var y = document.getElementById('y').value;
	if(y != ''){
		y = parseFloat(y.replace(",","."));
	}
	
	var select_y = document.getElementById('select-y').value;
	if(select_y == 1){
		//Mois
		var select_y_value = 12;
	}else{
		// Semaines
		if(select_y == 2){
			//Mois
			var select_y_value = 52;
		}else{
			var select_y_value = 1;
		}
	}
	
	var z = document.getElementById('z').value;
	if(z != ''){
		z = parseFloat(z.replace(",","."));
	}
	var select_z = document.getElementById('select-z').value;
	if(select_z == 1){
		// Heures
		var select_z_value = 1;
	}else{
		// Jours
		var select_z_value = 8;
	}
	
	if(x != '' && y != '' && z != ''){
		//alert((x*(z*select_z_value)));
		//alert(y * select_y_value);
		var MaintenanceAnnualSubscription = (x*z*select_z_value*select_y_value)/ y;
		MaintenanceAnnualSubscription = MaintenanceAnnualSubscription.toFixed(2);
		document.getElementById('MaintenanceAnnualSubscription').value = format(MaintenanceAnnualSubscription,2,'.');
		document.getElementById('CorrectionMaintenanceAnnualSubscription').value = format(MaintenanceAnnualSubscription,2,'.');
		var limit_travel = (x* select_y_value)/y;
		//alert(x+'*('+y+' * '+select_y_value+')');
		document.getElementById('limit_travel').value = limit_travel;
		document.getElementById('quantite_deplacement').value = limit_travel;
	}else{
		document.getElementById('MaintenanceAnnualSubscription').value = null;
		document.getElementById('CorrectionMaintenanceAnnualSubscription').value = null;
	}

}

function checkOrders(Qtecommandee,qteEnStockInitial,qteCommandeeInitial,qteEnStock,name){
	var quantiteCommandee = document.getElementById(Qtecommandee).value;
	quantiteCommandee = parseFloat(quantiteCommandee.replace(",","."));
	
	var quantiteEnStockInitial = document.getElementById(qteEnStockInitial).value;
	quantiteEnStockInitial = parseFloat(quantiteEnStockInitial.replace(",","."));
	
	var quantiteCommandeeInitial = document.getElementById(qteCommandeeInitial).value;
	quantiteCommandeeInitial = parseFloat(quantiteCommandeeInitial.replace(",","."));
	
	var quantiteEnStock = document.getElementById(qteEnStock).value;
	quantiteEnStock = parseFloat(quantiteEnStock.replace(",","."));
	
	var TheName = name;
	var tab = TheName.split('_');
	//alert(tab[3]);
	//alert(TheName+','+quantiteCommandee+','+quantiteEnStockInitial+','+quantiteCommandeeInitial+','+quantiteEnStock);
	
	var totalCommande = quantiteEnStockInitial + quantiteEnStock;
	//alert(tab);
	// if(tab[3] == undefined){ 
		// tab[3] = tab[2];
		// var TheName = tab[0]+'_'+tab[1];
	// }else{
		// if(tab[2] == undefined){ 
			// var TheName = tab[0];
			// tab[3] = tab[1];
		// }else{
			// var TheName = tab[0]+'_'+tab[1]+'_'+tab[2];
		
		// }
	// }
	
	if(tab[2] == undefined){ 
		var TheName = tab[0];
		tab[3] = tab[1];
	}else{
		if(tab[3] == undefined){ 
			tab[3] = tab[2];
			var TheName = tab[0]+'_'+tab[1];
		}else{
			var TheName = tab[0]+'_'+tab[1]+'_'+tab[2];
		
		}
	}
	//alert(TheName);
	if(totalCommande > quantiteCommandeeInitial){
		//alert(totalCommande);
		var nbLignes = document.getElementById('total').value;
		nbLignes = parseFloat(nbLignes.replace(",","."));
		
		var TheIDArticle = document.getElementById('article_'+tab[3]).value;
		var TotalUseStock = 0;
		var Texte = '';
		for(i=0;i<nbLignes;i++){
			if(document.getElementById('article_'+i) != null){
				var IDArticle = document.getElementById('article_'+i).value;
				//alert(IDArticle+'=='+TheIDArticle);
				if(IDArticle == TheIDArticle){
					valueboucle = document.getElementById(TheName+'_'+i).value;
					//alert(valueboucle)
					valueboucle = parseFloat(valueboucle.replace(",","."));
					//alert(valueboucle)
					//alert(TotalUseStock+' + '+ valueboucle) 
					// sequential_number_orders_
					// reference_customer_
					TotalUseStock = TotalUseStock + valueboucle;
					if(i != tab[3]){
						Texte = Texte+' - '+document.getElementById('sequential_number_orders_'+i).value+' pour le '+document.getElementById('reference_customer_'+i).value+'\n';
					}
				}
			}
		}
		if(TotalUseStock > quantiteEnStockInitial){
			jAlert('Attention le stock de l\'article est déja utilisé pour :\n '+Texte);
			document.getElementById(qteEnStock).value = '0,00';
			quantiteEnStock = 0;
		}
		
		if(TheName == 'quantity_in_stock'){
			if(quantiteEnStock > quantiteCommandeeInitial){
				var newValue = quantiteCommandeeInitial;
				newValue = newValue.toFixed(2);
				newValue = newValue.replace(".",",");
				
				document.getElementById(qteEnStock).value = newValue;
				quantiteEnStock = quantiteCommandeeInitial
			}
			var newTotal = quantiteCommandeeInitial - quantiteEnStock;
			newTotal = newTotal.toFixed(2);
			newTotal = newTotal.replace(".",",");
			
			document.getElementById(Qtecommandee).value = newTotal;
			
		}else{
			if(quantiteEnStock > quantiteCommandee){
				var newValue = quantiteCommandeeInitial;
				newValue = newValue.toFixed(2);
				newValue = newValue.replace(".",",");
				
				document.getElementById(Qtecommandee).value = newValue;
				quantiteCommandee = quantiteCommandeeInitial;
			}
			var newTotal = quantiteCommandeeInitial - quantiteCommandee;
			newTotal = newTotal.toFixed(2);
			newTotal = newTotal.replace(".",",");
			document.getElementById(qteEnStock).value = newTotal;
		}
		
	}
}

function CalculateBillablePriceQty(Qtecommandee,input2,input3,taxe_initial,taxe,margin,sellingPricedef,qteEnStockInitial,qteCommandeeInitial,qteEnStock,name){
	
	checkOrders(Qtecommandee,qteEnStockInitial,qteCommandeeInitial,qteEnStock,name);
	
	var SellPrice = document.getElementById(Qtecommandee).value;
	if(SellPrice == "") SellPrice = "1";
	SellPrice = parseFloat(SellPrice.replace(",","."));
	if(SellPrice.toFixed(2) != "NaN"){
		SellPriceFormat = SellPrice.toFixed(2);
		//SellPriceFormat = SellPriceFormat.replace(".",",");
		document.getElementById(Qtecommandee).value = format(SellPriceFormat,2,'.');
	}
	
	var Qty = document.getElementById(input2).value;
	if(Qty == "") Qty = "1";
	//Qty = Qty.replace(".","");	
	Qty = parseFloat(Qty.replace(",","."));	
	if(Qty.toFixed(2) != "NaN"){
		QtyFormat = Qty.toFixed(2);
		//QtyFormat = QtyFormat.replace(".",",");
		document.getElementById(input2).value = format(QtyFormat,2,'.');
	}
	
	var Total = parseFloat(Qty*SellPrice);
	if(Total.toFixed(2) != "NaN"){
		Total = Total.toFixed(2);
		//Total = Total.replace(".",",");
		document.getElementById(input3).value = format(Total,2,'.');
	}
	
	var TaxeInitial = document.getElementById(taxe_initial).value;
	TaxeInitial = parseFloat(TaxeInitial.replace(",","."));
	TaxeInitial = TaxeInitial.toFixed(2);
	var TotalTaxe = parseFloat(SellPrice*TaxeInitial);
	TotalTaxe = TotalTaxe.toFixed(2);
	//TotalTaxe = TotalTaxe.replace(".",",");
	document.getElementById(taxe).value = format(TotalTaxe,2,'.');
	
	var sellingPricedef = document.getElementById(sellingPricedef).value;
	sellingPricedef = sellingPricedef.replace(".","");
	sellingPricedef = parseFloat(sellingPricedef.replace(",","."));
	//alert(sellingPricedef);
	Marge = parseFloat(sellingPricedef/Qty);
	Marge = Marge.toFixed(2);
	//Marge = Marge.replace(".",",");
	document.getElementById(margin).value = format(Marge,2,'.');
	
	
}

function CalculateBillablePriceQtyForBillable(input1,input2,input3){
	var SellPrice = document.getElementById(input1).value;
	if(SellPrice == "") SellPrice = "1";
	SellPrice = SellPrice.replace('.','');
	SellPrice = parseFloat(SellPrice.replace(",","."));
	if(SellPrice.toFixed(2) != "NaN"){
		SellPriceFormat = SellPrice.toFixed(2);
		//SellPriceFormat = SellPriceFormat.replace(".",",");
		document.getElementById(input1).value = format(SellPriceFormat,2,'.');
	}
	
	var Qty = document.getElementById(input2).value;
	if(Qty == "") Qty = "1";
	Qty = Qty.replace('.','');
	Qty = parseFloat(Qty.replace(",","."));	
	if(Qty.toFixed(2) != "NaN"){
		QtyFormat = Qty.toFixed(2);
		//QtyFormat = QtyFormat.replace(".",",");
		document.getElementById(input2).value = format(QtyFormat,2,'.');
	}
	
	var Total = parseFloat(Qty*SellPrice);
	//alert(Qty+'*'+SellPrice)
	if(Total.toFixed(2) != "NaN"){
		Total = Total.toFixed(2);
		//Total = Total.replace(".",",");
		document.getElementById(input3).value = format(Total,2,'.');
	}
}

function CalculateBillableEvent(input1,input2,input3){
	var SellPrice = document.getElementById(input1).value;
	if(SellPrice == "") SellPrice = "1";
	SellPrice = SellPrice.replace(".","");
	SellPrice = parseFloat(SellPrice.replace(",","."));
	if(SellPrice.toFixed(2) != "NaN"){
		SellPriceFormat = SellPrice.toFixed(2);
		document.getElementById(input1).value = format(SellPriceFormat,2,'.');
		//alert(format(SellPriceFormat,2,'.'));
	}
	
	var Qty = document.getElementById(input2).value;
	if(Qty == "") Qty = "1";
	Qty = Qty.replace(".","");
	Qty = parseFloat(Qty.replace(",","."));	
	if(Qty.toFixed(2) != "NaN"){
		QtyFormat = Qty.toFixed(2);
		document.getElementById(input2).value = format(QtyFormat,2,'.');
		//alert(format(QtyFormat,2,'.'));
	}
	
	var Total = parseFloat(Qty*SellPrice);
	if(Total.toFixed(2) != "NaN"){
		Total = Total.toFixed(2);
		document.getElementById(input3).value = format(Total,2,'.');
		//alert(format(Total,2,'.'));
	}
}

function CalculateTotalBillablePriceQty(){
	var TotalIntervention = document.getElementById('total_intervention').value;
	var TotalIntervention = parseInt(TotalIntervention);
	var TotalHTVA = 0;
	for(i=0;i<TotalIntervention;i++){
		if(document.getElementById('total_'+i) != undefined){
			Quantite = document.getElementById('quantite_'+i).value.replace(".","");
			Quantite = parseFloat(Quantite.replace(",","."));
			
			Price = document.getElementById('prix_'+i).value.replace(".","");
			Price = parseFloat(Price.replace(",","."));
			
			TotalHTVA = TotalHTVA + parseFloat(Price * Quantite);
		}
	}
	
	//alert(TotalHTVA);
	var TotalHTTC = TotalHTVA * 1.21;
	//alert(TotalHTTC);
	var TotalTVA = TotalHTTC - TotalHTVA;
	//alert(TotalTVA);
	
	document.getElementById('Total_HTVA_0').value = '0,00';
	document.getElementById('total_tva_0').value = '0,00';
	document.getElementById('total_ttc_0').value = '0,00';
	
	document.getElementById('Total_HTVA_6').value = '0,00';
	document.getElementById('total_tva_6').value = '0,00';
	document.getElementById('total_ttc_6').value = '0,00';
	
	document.getElementById('Total_HTVA_12').value = '0,00';
	document.getElementById('total_tva_12').value = '0,00';
	document.getElementById('total_ttc_12').value = '0,00';
	
	document.getElementById('Total_HTVA_21').value = format(ArondirSuperieur(TotalHTVA),2,'.');
	document.getElementById('total_tva_21').value = format(ArondirSuperieur(TotalTVA),2,'.');
	document.getElementById('total_ttc_21').value = format(ArondirSuperieur(TotalHTTC),2,'.');
	
	document.getElementById('a_payer').value = format(ArondirSuperieur(TotalHTTC),2,'.');
	
}


function showpresta(weeknumber){
	var xhr = getXhr();
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			/** reponse = clean(xhr.responseXML.documentElement);
			document.getElementById('testajax').innerHTML = reponse; **/
			document.getElementById('week'+weeknumber).innerHTML = xhr.responseText;
			/**alert(xhr.responseText);**/
			
		}
	}
	xhr.open("POST","prestation_ajax.php",true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhr.send("week="+weeknumber);
}

function Regenerate_table_drag_and_drop(){
	//Recalculate();
	$(document).ready(function() {
	    $('#tableLineBusinessRecords').tableDnD({
	    	onDrop: function(table, row) {
	    	//Recalculate();
	    }
	    });
	});
}

function quantite_affected(champ){
	var quantite = document.getElementById(champ).value;
	if(quantite != ""){
		quantite = parseFloat(quantite.replace(",","."));
		quantite = quantite.toFixed(2);
		var quantite_exam = quantite.split('.');
		
		if(quantite_exam[1] != 0){
			if( (quantite_exam[1] >= 00) && (quantite_exam[1] <= 13) ){
				quantite_exam[1] = 00;
			}
			
			if( (quantite_exam[1] >= 14) && (quantite_exam[1] <= 25) ){
				quantite_exam[1] = 25;
			}
			
			if( (quantite_exam[1] >= 26) && (quantite_exam[1] <= 37) ){
				quantite_exam[1] = 25;
			}
			
			if( (quantite_exam[1] >= 38) && (quantite_exam[1] <= 50) ){
				quantite_exam[1] = 50;
			}
			
			if( (quantite_exam[1] >= 51) && (quantite_exam[1] <= 63) ){
				quantite_exam[1] = 50;
			}
			
			if( (quantite_exam[1] >= 64) && (quantite_exam[1] <= 75) ){
				quantite_exam[1] = 75;
			}
			
			if( (quantite_exam[1] >= 76) && (quantite_exam[1] <= 87) ){
				quantite_exam[1] = 75;
			}
			
			if( (quantite_exam[1] >= 88)){
				quantite_exam[1] = 00;
				quantite_exam[0] = parseInt(quantite_exam[0]) + 1;
			}
		}
		
		quantite = quantite_exam[0]+'.'+quantite_exam[1];
		document.getElementById(champ).value = format(quantite,2,'.');
	}

}

function GereControle(Controleur, Controle, Masquer) {
	var objControleur = document.getElementById(Controleur);
	var objControle = document.getElementById(Controle);
		if (Masquer=='1')
			objControle.style.display=(objControleur.checked==true)?'':'none';
		else
			objControle.disabled=(objControleur.checked==true)?false:true;
		return true;
}

function CalculOISF(container){
	var SyntecIndexWebges = document.getElementById("SyntecIndexWebges").value;
	var TCHIndexWebges = document.getElementById("TCHIndexWebges").value;
	SyntecIndexWebges = parseFloat(SyntecIndex.replace(",","."));
	TCHIndexWebges = parseFloat(TCHIndex.replace(",","."));	
	
	var SyntecIndex = document.getElementById("SyntecIndex").value;
	var TCHIndex = document.getElementById("TCHIndex").value;
	SyntecIndex = parseFloat(SyntecIndex.replace(",","."));
	TCHIndex = parseFloat(TCHIndex.replace(",","."));
	
	var prixVente = document.getElementById("prixVente").value;
	prixVente = parseFloat(prixVente.replace(",","."));
	
	var Sn = SalaireReferenceWebges+CoutSalarialWebges;
	
	var So = SalaireReference+CoutSalarial;
	var Pn = prixVente * ( 0,20 + 0,80 * ( 0,80 ( SyntecIndex / SyntecIndexWebges ) + 0,20 (TCHIndex / TCHIndexWebges) ) ) ;
	
	if(Pn.toFixed(2) != "NaN"){
		var resultat = Pn.toFixed(2);
		resultat = resultat.replace(".",",");
		document.getElementById(container).value = resultat;
	
	//Formule : P = Po x { 0,20 + 0,80 x [ 0,80 ( S / So ) + 0,20 (T / To) ] }

	}
}

function CalculAgoria(container){
	var SalaireReferenceWebges = document.getElementById("SalaireReferenceWebges").value;
	var CoutSalarialWebges = document.getElementById("CoutSalarialWebges").value;
	SalaireReferenceWebges = parseFloat(SalaireReferenceWebges.replace(",","."));
	CoutSalarialWebges = parseFloat(CoutSalarialWebges.replace(",","."));	
	
	var SalaireReference = document.getElementById("SalaireReference").value;
	var CoutSalarial = document.getElementById("CoutSalarial").value;
	SalaireReference = parseFloat(SalaireReference.replace(",","."));
	CoutSalarial = parseFloat(CoutSalarial.replace(",","."));
	
	var prixVente = document.getElementById("prixVente").value;
	prixVente = parseFloat(prixVente.replace(",","."));
	
	var Sn = SalaireReferenceWebges+CoutSalarialWebges;
	
	var So = SalaireReference+CoutSalarial;
	var Pn = prixVente * (((0.8 * Sn)/So)+ 0.2);
	
	if(Pn.toFixed(2) != "NaN"){
		var resultat = Pn.toFixed(2);
		resultat = resultat.replace(".",",");
		document.getElementById(container).value = resultat;
	}
}

function CalculDeplacement(radio){
	for (var i=0; i<radio.length;i++) {
        if (radio[i].checked) {
        	var ChoixPrix = parseFloat(radio[i].value);
        }
     }
	var Itineraire = parseFloat(document.getElementById("Itineraire").value);
	
	if(isNaN(ChoixPrix)){
		if(document.getElementById("prix_defini") != null){
			var ChoixPrix = document.getElementById("prix_defini").value;
			ChoixPrix = ChoixPrix.replace(",",".");
			ChoixPrix  = parseFloat(ChoixPrix);
		}
	}
	
	var resultat = ChoixPrix * Itineraire;
	resultat = resultat.toFixed(2);
	if(resultat != "NaN"){
		document.getElementById("prixVente").value = resultat;
	}
	else{
		document.getElementById("prixVente").value = "";
	}
}

function IsParticular(ValJuridique){
	if(ValJuridique == 19){
		document.getElementById('numTVA').value = 'N.A'; 
		document.getElementById('numTVA').readOnly = true; 
		document.getElementById('numTVA').className = 'readonly idleField';
		document.getElementById('SelectTVA').value = 2; 
		
		document.getElementById('SelectPayment').value = 1; 
		document.getElementById('SelectGroupe').value = 11; 
		document.getElementById('SelectStaff').value = 6; 
			
	} 
	else{
		document.getElementById('SelectTVA').value = ''; 
		document.getElementById('numTVA').value = ''; 
		document.getElementById('numTVA').readOnly = false; 
		document.getElementById('numTVA').className = 'idleField';
		
		document.getElementById('SelectPayment').value = ''; 
		document.getElementById('SelectGroupe').value = ''; 
		document.getElementById('SelectStaff').value = ''; 
	}
}

function RecalculateTotaux(PaysClient,DelivAddress){
	var transport2 = 0;
	var transport3 = 0;
	var transport4 = 0;
	if(document.getElementById(PaysClient).value == 'BELGIQUE'){
		//MyGo('','TabMontant','tab_montant');
		var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0','0');
		var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6','6');
		var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12','12');
		var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21','21');
		var frais_transport = document.getElementById('frais_transport').value;
		frais_transport = parseFloat(frais_transport.replace(',','.'));
		var frais_transport_auto = document.getElementById('frais_transport_auto').value;
		frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		var Total = document.getElementById('Total_HTVA_21').value;
		Total = parseFloat(Total.replace(',','.'));
		resultat = parseFloat(Total+frais_transport+frais_transport_auto);
		resultat = resultat.toFixed(2);
		document.getElementById('Total_HTVA_21').value = resultat;
		resultat = parseFloat(((Total+frais_transport+frais_transport_auto)*1.21) - (Total+frais_transport+frais_transport_auto));
		resultat = resultat.toFixed(2);
		document.getElementById('total_tva_21').value = resultat;
		resultat = parseFloat(((Total+frais_transport+frais_transport_auto)*1.21));
		resultat = resultat.toFixed(2);
		document.getElementById('total_ttc_21').value = resultat;
		resultat = parseFloat(((Total+frais_transport+frais_transport_auto)*1.21));
		resultat = resultat.toFixed(2);
		document.getElementById('a_payer').value = resultat;
	} else if(document.getElementById(DelivAddress).value == 'BELGIQUE'){
		var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0','0');
		var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6','6');
		var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12','12');
		var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21','21');
		var frais_transport = document.getElementById('frais_transport').value;
		frais_transport = parseFloat(frais_transport.replace(',','.'));
		var frais_transport_auto = document.getElementById('frais_transport_auto').value;
		frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		var Total = document.getElementById('Total_HTVA_21').value;
		Total = parseFloat(Total.replace(',','.'));
		resultat = parseFloat(Total+frais_transport+frais_transport_auto);
		resultat = resultat.toFixed(2);
		document.getElementById('Total_HTVA_21').value = resultat;
		resultat = parseFloat(((Total+frais_transport+frais_transport_auto)*1.21) - (Total+frais_transport+frais_transport_auto));
		resultat = resultat.toFixed(2);
		document.getElementById('total_tva_21').value = resultat;
		resultat = parseFloat(((Total+frais_transport+frais_transport_auto)*1.21));
		resultat = resultat.toFixed(2);
		document.getElementById('total_ttc_21').value = resultat;
		resultat = parseFloat(((Total+frais_transport+frais_transport_auto)*1.21));
		resultat = resultat.toFixed(2);
		document.getElementById('a_payer').value = resultat;
	
	} else{
		var transport1 = CalculMontantsNoTVA('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0');
		var frais_transport = document.getElementById('frais_transport').value;
		frais_transport = parseFloat(frais_transport.replace(',','.'));
		var frais_transport_auto = document.getElementById('frais_transport_auto').value;
		frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		var Total = document.getElementById('Total_HTVA_0').value;
		Total = parseFloat(Total.replace(',','.'));
		resultat = parseFloat(Total+frais_transport+frais_transport_auto)
		resultat = resultat.toFixed(2);
		
		document.getElementById('Total_HTVA_0').value = resultat;
		document.getElementById('total_ttc_0').value = resultat;
		document.getElementById('a_payer').value = resultat;
	}
	AllSousTotaux();
	Apayer();
	
}

// Permet de générer tous les Totaux des tables de montants des pièces commerciales
function TransportProvider(PaysClient,DelivAddress,send){
	if(document.getElementById('company') != null || document.getElementById('company') != undefined){
		var company = document.getElementById('company').value;
	}else{
		var company = '1';
	}
	
	//alert(company);
	switch(company){
		case '1':
			BusinessRecordsBelgium(PaysClient,DelivAddress,send);
			break;
	
		case '2':
			BusinessRecordsFrench(PaysClient,DelivAddress,send);
			break;
	}
}

function BusinessRecordsFrench(PaysClient,DelivAddress,send){
	/* 
	 * Constantes
	 * */
	if(EXTENDTVA1 == '') var TVA1 = 0; else var TVA1 = parseFloat(EXTENDTVA1);
	if(EXTENDTVA2 == '') var TVA2 = 5.5; else var TVA2 = parseFloat(EXTENDTVA2);
	if(EXTENDTVABIS2 == '') var TVABIS2 = 1.055; else var TVABIS2 = parseFloat(EXTENDTVABIS2);
	if(EXTENDTVA3 == '') var TVA3 = 10; else var TVA3 = parseFloat(EXTENDTVA3);
	if(EXTENDTVABIS3 == '') var TVABIS3 = 1.10; else var TVABIS3 = parseFloat(EXTENDTVABIS3);
	if(EXTENDTVA4 == '') var TVA4 = 20; else var TVA4 = parseFloat(EXTENDTVA4);
	if(EXTENDTVABIS4 == '') var TVABIS4 = 1.20; else var TVABIS4 = parseFloat(EXTENDTVABIS4);
	// alert(TVA1);
	// alert(TVA2);
	// alert(TVABIS2);
	// alert(TVA3);
	// alert(TVABIS3);
	// alert(TVA4);
	// alert(TVABIS4);
	
	if(document.getElementById(PaysClient).value == 'FRANCE'){
		//MyGo('','TabMontant','tab_montant');
		
		var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
		var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
		var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
		var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
		// Si le champ frais de port existe
		if((document.getElementById('frais_transport') != null)){
			var frais_transport = document.getElementById('frais_transport').value;
			frais_transport = parseFloat(frais_transport.replace(',','.'));
			var frais_transport_auto = document.getElementById('frais_transport_auto').value;
			frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		}else{
			frais_transport_auto = 0.00;
			frais_transport = 0.00;
		}
		
		var Total = document.getElementById('Total_HTVA_21').value;
		Total = Total.replace('.','');
		Total = parseFloat(Total.replace(',','.'));
		
		// Si le champ "Remise Global" existe
		if((document.getElementById('remise') != null)){
			if(document.getElementById('remise').value == "") document.getElementById('remise').value = "0,00";
			var ValueDiscount = document.getElementById('remise').value;
			ValueDiscount = ValueDiscount.replace('.','');
			ValueDiscount = parseFloat(ValueDiscount.replace(',','.'));
			switch(document.getElementById('select-remise').value){
				case "1":
					// euro HTVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						(document.getElementById('percent-amount') != null)
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				case "2":
					// euro TTC
					// on divise par 1.21 la remise TTC pour un client assujetti pour recalculer la TVA
					ValueDiscount = ValueDiscount / TVABIS4;
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
				//	alert(PercentDiscount)
					
					break;
					
				case "3":
					// pourcentage
						
					//alert(ValueDiscount);
					var TotalTmp = (Total+frais_transport+frais_transport_auto) * (1-(ValueDiscount/100))
					//alert(TotalTmp);
					ValueDiscount = (Total+frais_transport+frais_transport_auto) - TotalTmp;
					//alert(ValueDiscount);
					DiscountHTVA = ValueDiscount;

					var PercentDiscount = DiscountHTVA;
					//alert(PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" &euro; HTVA");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				default :
					// default remise 0

					DiscountHTVA = 0;
					vider_element("percent-amount");	
			}
		}else{
			DiscountHTVA = 0;
		}
		
		//alert(DiscountHTVA);
		if((document.getElementById('taux_tva_frais_transport') != null)){
			switch(document.getElementById('taux_tva_frais_transport').value){
				case "0":
					document.getElementById('Total_HTVA_0').value = format(frais_transport,2,'.');
					document.getElementById('total_tva_0').value = '0,00';
					document.getElementById('total_ttc_0').value = format(frais_transport,2,'.');
					frais_transport = 0;
					break;
				
				case "21":
					
					break;
			}
		}
		
		document.getElementById('Total_HTVA_21').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
		var total_tva_21 = parseFloat((Total-DiscountHTVA+frais_transport+frais_transport_auto)*(TVA4/100));
		total_tva_212 = ArondirSuperieur(total_tva_21);
		total_tva_21 = format(ArondirSuperieur(total_tva_21),2,'.');
		document.getElementById('total_tva_21').value = total_tva_21;
		var total_ttc_0 = (Total-DiscountHTVA+frais_transport+frais_transport_auto+total_tva_212);
		total_ttc_0 = total_ttc_0.toFixed(2);
		
		total_ttc_0 = format(total_ttc_0,2,'.');
		//alert(total_ttc_0);
		document.getElementById('total_ttc_21').value = total_ttc_0;
	} else if(document.getElementById(DelivAddress).value == 'FRANCE'){
		var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
		var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
		var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
		var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
		if((document.getElementById('frais_transport') != null)){
			var frais_transport = document.getElementById('frais_transport').value;
			frais_transport = parseFloat(frais_transport.replace(',','.'));
			var frais_transport_auto = document.getElementById('frais_transport_auto').value;
			frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		}else{
			frais_transport_auto = 0.00;
			frais_transport = 0.00;
		}
		
		var Total = document.getElementById('Total_HTVA_21').value;
		Total = Total.replace('.','');
		Total = parseFloat(Total.replace(',','.'));
		
		// Si le champ "Remise Global" existe
		if((document.getElementById('remise') != null)){
			if(document.getElementById('remise').value == "") document.getElementById('remise').value = "0,00";
			var ValueDiscount = document.getElementById('remise').value;
			ValueDiscount = ValueDiscount.replace('.','');
			ValueDiscount = parseFloat(ValueDiscount.replace(',','.'));
			switch(document.getElementById('select-remise').value){
				case "1":
					// euro HTVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				case "2":
					// euro TTC
					// on divise par 1.21 la remise TTC pour un client assujetti pour recalculer la TVA
					ValueDiscount = ValueDiscount / TVABIS4;
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
				//	alert(PercentDiscount)
					
					break;
					
				case "3":
					// pourcentage
						
					//alert(ValueDiscount);
					var TotalTmp = (Total+frais_transport+frais_transport_auto) * (1-(ValueDiscount/100))
					//alert(TotalTmp);
					ValueDiscount = (Total+frais_transport+frais_transport_auto) - TotalTmp;
					//alert(ValueDiscount);
					DiscountHTVA = ValueDiscount;

					var PercentDiscount = DiscountHTVA;
					//alert(PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" &euro; HTVA");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				default :
					// default remise 0

					DiscountHTVA = 0;
					vider_element("percent-amount");	
			}
		}else{
			DiscountHTVA = 0;
		}
		
		if((document.getElementById('taux_tva_frais_transport') != null)){
			switch(document.getElementById('taux_tva_frais_transport').value){
				case "0":
					document.getElementById('Total_HTVA_0').value = format(frais_transport,2,'.');
					document.getElementById('total_tva_0').value = '0,00';
					document.getElementById('total_ttc_0').value = format(frais_transport,2,'.');
					frais_transport = 0;
					break;
					
				case "21":
					
					break;
			}
		}
		
		//alert(Total);
		document.getElementById('Total_HTVA_21').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
		var total_tva_21 = ((Total-DiscountHTVA+frais_transport+frais_transport_auto)*TVABIS4) - (Total-DiscountHTVA+frais_transport+frais_transport_auto);
		total_tva_21 = format(total_tva_21,2,'.');
		document.getElementById('total_tva_21').value = total_tva_21;
		var total_ttc_0 = ((Total-DiscountHTVA+frais_transport+frais_transport_auto)*TVABIS4);
		total_ttc_0 = format(total_ttc_0,2,'.');
		document.getElementById('total_ttc_21').value = total_ttc_0;
	} else{
		//alert('je passe');
		var transport1 = CalculMontantsNoTVA('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0');
		if((document.getElementById('frais_transport') != null)){
			var frais_transport = document.getElementById('frais_transport').value;
			frais_transport = parseFloat(frais_transport.replace(',','.'));
			var frais_transport_auto = document.getElementById('frais_transport_auto').value;
			frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		}else{
			frais_transport_auto = 0.00;
			frais_transport = 0.00;
		}
		
		var Total = document.getElementById('Total_HTVA_0').value;
		//alert(Total);
		Total = Total.replace('.','');
		Total = parseFloat(Total.replace(',','.'));
		
		// Si le champ "Remise Global" existe
		if((document.getElementById('remise') != null)){
			if(document.getElementById('remise').value == "") document.getElementById('remise').value = "0,00";
			var ValueDiscount = document.getElementById('remise').value;
			ValueDiscount = ValueDiscount.replace('.','');
			ValueDiscount = parseFloat(ValueDiscount.replace(',','.'));
			switch(document.getElementById('select-remise').value){
				case "1":
					// euro HTVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				case "2":
					// euro TTC
					// on divise par 1.21 la remise TTC pour un client assujetti pour recalculer la TVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
				//	alert(PercentDiscount)
					
					break;
					
				case "3":
					// pourcentage
						
					//alert(ValueDiscount);
					var TotalTmp = (Total+frais_transport+frais_transport_auto) * (1-(ValueDiscount/100))
					//alert(TotalTmp);
					ValueDiscount = (Total+frais_transport+frais_transport_auto) - TotalTmp;
					//alert(ValueDiscount);
					DiscountHTVA = ValueDiscount;

					var PercentDiscount = DiscountHTVA;
					//alert(PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" &euro; HTVA");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				default :
					// default remise 0

					DiscountHTVA = 0;
					vider_element("percent-amount");	
			}
		}else{
			DiscountHTVA = 0;
		}
		
		if((document.getElementById('taux_tva_frais_transport') != null)){
			switch(document.getElementById('taux_tva_frais_transport').value){
				case "0":
					
					break;
					
				case "21":
					var Total2 = document.getElementById('Total_HTVA_21').value;
					Total2 = Total.replace('.','');
					Total2 = parseFloat(Total.replace(',','.'));
					
					document.getElementById('Total_HTVA_21').value = format(frais_transport,2,'.');
					var total_tva_21 = parseFloat((frais_transport)*(TVA3-1));
					total_tva_212 = ArondirSuperieur(total_tva_21);
					total_tva_21 = format(ArondirSuperieur(total_tva_21),2,'.');
					document.getElementById('total_tva_21').value = total_tva_21;
					var total_ttc_0 = (frais_transport);
					total_ttc_0 = total_ttc_0.toFixed(2);
					
					total_ttc_0 = format(total_ttc_0,2,'.');
					//alert(total_ttc_0);
					document.getElementById('total_ttc_21').value = total_ttc_0;
					frais_transport = 0;
					break;
			}
		}
		
		//alert(Total);
		document.getElementById('Total_HTVA_0').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
		document.getElementById('total_tva_0').value = '0,00';
		document.getElementById('total_ttc_0').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
	}
	
	var Total_HTVA_0 = document.getElementById('Total_HTVA_0').value;
	Total_HTVA_0 = Total_HTVA_0.replace('.','');
	Total_HTVA_0 = parseFloat(Total_HTVA_0.replace(',','.'));
	
	var Total_HTVA_6 = document.getElementById('Total_HTVA_6').value;
	Total_HTVA_6 = Total_HTVA_6.replace('.','');
	Total_HTVA_6 = parseFloat(Total_HTVA_6.replace(',','.'));
	
	var Total_HTVA_12 = document.getElementById('Total_HTVA_12').value;
	Total_HTVA_12 = Total_HTVA_12.replace('.','');
	Total_HTVA_12 = parseFloat(Total_HTVA_12.replace(',','.'));
	
	var Total_HTVA_21 = document.getElementById('Total_HTVA_21').value;
	Total_HTVA_21 = Total_HTVA_21.replace('.','');
	Total_HTVA_21 = parseFloat(Total_HTVA_21.replace(',','.'));
	
	
	if((document.getElementById('frais_transport') != null)){
		var TotalHTVA = Total_HTVA_0 + Total_HTVA_6 + Total_HTVA_12 + Total_HTVA_21;
	}else{
		TotalHTVA = 101;
	}
	
	if((document.getElementById('menu2') != null)){
		//alert(document.getElementById('menu2'));
		switch(document.getElementById('menu2').value){
			case '14':
				TotalHTVA = 101;
				break;
				
			case '13':
				TotalHTVA = 101;
				break;
				
			case '16':
				TotalHTVA = 101;
				break;
			case '24':
				TotalHTVA = 101;
				break;
		}
	}
	
	if((document.getElementById('menu3') != null)){
		//alert(document.getElementById('menu2'));
		switch(document.getElementById('menu3').value){
			case '2':
				var menu = 2;
				break;
				
			default:
				var menu = -1;
		}
	}else{
		var menu = -1;
	}
	
	if(TotalHTVA < 100 && TotalHTVA != 0){
		var frais_transport = document.getElementById('frais_transport').value;
		frais_transport = parseFloat(frais_transport.replace(',','.'));
		var frais_transport_auto = document.getElementById('frais_transport_auto').value;
		frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		if(transport1 != 1 && transport2 != 1 && transport3 != 1 && transport4 != 1 && frais_transport_auto == 0 && frais_transport == 0 && menu == 2){
			jConfirm('Voulez-vous inclure des frais de transport fournisseur ? ', 'Devis inférieur à 100 euros', function(r) {
				if( r == true){
					MyGo('','div_traitement_formulaire','freight_charges');
					if(document.getElementById(PaysClient).value == 'FRANCE'){
						//MyGo('','TabMontant','tab_montant');
						var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
						var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
						var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
						var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
					} else if(document.getElementById(DelivAddress).value == 'FRANCE'){
						var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
						var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
						var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
						var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
					} else{
						var transport1 = CalculMontantsNoTVA('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0');
						
						var frais_transport = document.getElementById('frais_transport').value;
						frais_transport = parseFloat(frais_transport.replace(',','.'));
						var frais_transport_auto = document.getElementById('frais_transport_auto').value;
						frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
						var Total = document.getElementById('Total_HTVA_0').value;
						Total = parseFloat(Total.replace(',','.'));
						document.getElementById('Total_HTVA_0').value = Total+frais_transport+frais_transport_auto;
					}
					
				}else{
					AllSousTotaux();
					Apayer();
					if(send != null && send != undefined){
						//RecalculateTotaux(PaysClient,DelivAddress);
						is_empty('SelectClient;nosref','');
					}
				}
			});
		}else{
			AllSousTotaux();
			Apayer();
			if(send != null && send != undefined){
				//RecalculateTotaux(PaysClient,DelivAddress);
				is_empty('SelectClient;nosref','');
			}
		}
	}
	else{
		AllSousTotaux();
		Apayer();
		if(send != null && send != undefined){
			//RecalculateTotaux(PaysClient,DelivAddress);
			//alert();
			is_empty('SelectClient;nosref','');
		}
	}
}



function BusinessRecordsBelgium(PaysClient,DelivAddress,send){
	/* 
	 * Constantes
	 * */
	var TVA1 = 0;
	var TVA2 = 6;
	var TVABIS2 = 1.06;
	var TVA3 = 12;
	var TVABIS3 = 1.12;
	var TVA4 = 21;
	var TVABIS4 = 1.21;
	if(document.getElementById(PaysClient).value == 'BELGIQUE'){
		//MyGo('','TabMontant','tab_montant');
		
		var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
		var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
		var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
		var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
		// Si le champ frais de port existe
		if((document.getElementById('frais_transport') != null)){
			var frais_transport = document.getElementById('frais_transport').value;
			frais_transport = parseFloat(frais_transport.replace(',','.'));
			var frais_transport_auto = document.getElementById('frais_transport_auto').value;
			frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		}else{
			frais_transport_auto = 0.00;
			frais_transport = 0.00;
		}
		
		var Total = document.getElementById('Total_HTVA_21').value;
		Total = Total.replace('.','');
		Total = parseFloat(Total.replace(',','.'));
		
		// Si le champ "Remise Global" existe
		if((document.getElementById('remise') != null)){
			if(document.getElementById('remise').value == "") document.getElementById('remise').value = "0,00";
			var ValueDiscount = document.getElementById('remise').value;
			ValueDiscount = ValueDiscount.replace('.','');
			ValueDiscount = parseFloat(ValueDiscount.replace(',','.'));
			switch(document.getElementById('select-remise').value){
				case "1":
					// euro HTVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						(document.getElementById('percent-amount') != null)
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				case "2":
					// euro TTC
					// on divise par 1.21 la remise TTC pour un client assujetti pour recalculer la TVA
					ValueDiscount = ValueDiscount / TVABIS4;
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
				//	alert(PercentDiscount)
					
					break;
					
				case "3":
					// pourcentage
						
					//alert(ValueDiscount);
					var TotalTmp = (Total+frais_transport+frais_transport_auto) * (1-(ValueDiscount/100))
					//alert(TotalTmp);
					ValueDiscount = (Total+frais_transport+frais_transport_auto) - TotalTmp;
					//alert(ValueDiscount);
					DiscountHTVA = ValueDiscount;

					var PercentDiscount = DiscountHTVA;
					//alert(PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" &euro; HTVA");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				default :
					// default remise 0

					DiscountHTVA = 0;
					vider_element("percent-amount");	
			}
		}else{
			DiscountHTVA = 0;
		}
		
		//alert(DiscountHTVA);
		if((document.getElementById('taux_tva_frais_transport') != null)){
			switch(document.getElementById('taux_tva_frais_transport').value){
				case "0":
					document.getElementById('Total_HTVA_0').value = format(frais_transport,2,'.');
					document.getElementById('total_tva_0').value = '0,00';
					document.getElementById('total_ttc_0').value = format(frais_transport,2,'.');
					frais_transport = 0;
					break;
				
				case "21":
					
					break;
			}
		}
		
		document.getElementById('Total_HTVA_21').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
		var total_tva_21 = parseFloat((Total-DiscountHTVA+frais_transport+frais_transport_auto)*(TVA4/100));
		total_tva_212 = ArondirSuperieur(total_tva_21);
		total_tva_21 = format(ArondirSuperieur(total_tva_21),2,'.');
		document.getElementById('total_tva_21').value = total_tva_21;
		var total_ttc_0 = (Total-DiscountHTVA+frais_transport+frais_transport_auto+total_tva_212);
		total_ttc_0 = total_ttc_0.toFixed(2);
		
		total_ttc_0 = format(total_ttc_0,2,'.');
		//alert(total_ttc_0);
		document.getElementById('total_ttc_21').value = total_ttc_0;
	} else if(document.getElementById(DelivAddress).value == 'BELGIQUE'){
		var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
		var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
		var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
		var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
		if((document.getElementById('frais_transport') != null)){
			var frais_transport = document.getElementById('frais_transport').value;
			frais_transport = parseFloat(frais_transport.replace(',','.'));
			var frais_transport_auto = document.getElementById('frais_transport_auto').value;
			frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		}else{
			frais_transport_auto = 0.00;
			frais_transport = 0.00;
		}
		
		var Total = document.getElementById('Total_HTVA_21').value;
		Total = Total.replace('.','');
		Total = parseFloat(Total.replace(',','.'));
		
		// Si le champ "Remise Global" existe
		if((document.getElementById('remise') != null)){
			if(document.getElementById('remise').value == "") document.getElementById('remise').value = "0,00";
			var ValueDiscount = document.getElementById('remise').value;
			ValueDiscount = ValueDiscount.replace('.','');
			ValueDiscount = parseFloat(ValueDiscount.replace(',','.'));
			switch(document.getElementById('select-remise').value){
				case "1":
					// euro HTVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				case "2":
					// euro TTC
					// on divise par 1.21 la remise TTC pour un client assujetti pour recalculer la TVA
					ValueDiscount = ValueDiscount / TVABIS4;
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
				//	alert(PercentDiscount)
					
					break;
					
				case "3":
					// pourcentage
						
					//alert(ValueDiscount);
					var TotalTmp = (Total+frais_transport+frais_transport_auto) * (1-(ValueDiscount/100))
					//alert(TotalTmp);
					ValueDiscount = (Total+frais_transport+frais_transport_auto) - TotalTmp;
					//alert(ValueDiscount);
					DiscountHTVA = ValueDiscount;

					var PercentDiscount = DiscountHTVA;
					//alert(PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" &euro; HTVA");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				default :
					// default remise 0

					DiscountHTVA = 0;
					vider_element("percent-amount");	
			}
		}else{
			DiscountHTVA = 0;
		}
		
		if((document.getElementById('taux_tva_frais_transport') != null)){
			switch(document.getElementById('taux_tva_frais_transport').value){
				case "0":
					document.getElementById('Total_HTVA_0').value = format(frais_transport,2,'.');
					document.getElementById('total_tva_0').value = '0,00';
					document.getElementById('total_ttc_0').value = format(frais_transport,2,'.');
					frais_transport = 0;
					break;
					
				case "21":
					
					break;
			}
		}
		
		//alert(Total);
		document.getElementById('Total_HTVA_21').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
		var total_tva_21 = ((Total-DiscountHTVA+frais_transport+frais_transport_auto)*TVABIS4) - (Total-DiscountHTVA+frais_transport+frais_transport_auto);
		total_tva_21 = format(total_tva_21,2,'.');
		document.getElementById('total_tva_21').value = total_tva_21;
		var total_ttc_0 = ((Total-DiscountHTVA+frais_transport+frais_transport_auto)*TVABIS4);
		total_ttc_0 = format(total_ttc_0,2,'.');
		document.getElementById('total_ttc_21').value = total_ttc_0;
	} else{
		//alert('je passe');
		var transport1 = CalculMontantsNoTVA('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0');
		if((document.getElementById('frais_transport') != null)){
			var frais_transport = document.getElementById('frais_transport').value;
			frais_transport = parseFloat(frais_transport.replace(',','.'));
			var frais_transport_auto = document.getElementById('frais_transport_auto').value;
			frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		}else{
			frais_transport_auto = 0.00;
			frais_transport = 0.00;
		}
		
		var Total = document.getElementById('Total_HTVA_0').value;
		//alert(Total);
		Total = Total.replace('.','');
		Total = parseFloat(Total.replace(',','.'));
		
		// Si le champ "Remise Global" existe
		if((document.getElementById('remise') != null)){
			if(document.getElementById('remise').value == "") document.getElementById('remise').value = "0,00";
			var ValueDiscount = document.getElementById('remise').value;
			ValueDiscount = ValueDiscount.replace('.','');
			ValueDiscount = parseFloat(ValueDiscount.replace(',','.'));
			switch(document.getElementById('select-remise').value){
				case "1":
					// euro HTVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				case "2":
					// euro TTC
					// on divise par 1.21 la remise TTC pour un client assujetti pour recalculer la TVA
					DiscountHTVA = ValueDiscount;

					// On calcule le montant hors TVA remisé
					var DiscountValue = Total-DiscountHTVA+frais_transport+frais_transport_auto;
					//alert(DiscountValue)
					// on calcule le montant hors tva sans la remise
					var ValueOneHundred = Total+frais_transport+frais_transport_auto;
					//alert(ValueOneHundred)
					// On en déduit le pourcentage de la remise
					var PercentDiscount = (DiscountValue * 100) / ValueOneHundred;
					//alert(100 - PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(100 - PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" %");
					}else{
						vider_element("percent-amount");
					}
				//	alert(PercentDiscount)
					
					break;
					
				case "3":
					// pourcentage
						
					//alert(ValueDiscount);
					var TotalTmp = (Total+frais_transport+frais_transport_auto) * (1-(ValueDiscount/100))
					//alert(TotalTmp);
					ValueDiscount = (Total+frais_transport+frais_transport_auto) - TotalTmp;
					//alert(ValueDiscount);
					DiscountHTVA = ValueDiscount;

					var PercentDiscount = DiscountHTVA;
					//alert(PercentDiscount)
					if(DiscountHTVA > 0){
						var PercentDiscount =  format(ArondirSuperieur(PercentDiscount),2,'.');
						completer_element("percent-amount","soit "+PercentDiscount+" &euro; HTVA");
					}else{
						vider_element("percent-amount");
					}
					//alert(PercentDiscount)
					
					break;
					
				default :
					// default remise 0

					DiscountHTVA = 0;
					vider_element("percent-amount");	
			}
		}else{
			DiscountHTVA = 0;
		}
		
		if((document.getElementById('taux_tva_frais_transport') != null)){
			switch(document.getElementById('taux_tva_frais_transport').value){
				case "0":
					
					break;
					
				case "21":
					var Total2 = document.getElementById('Total_HTVA_21').value;
					Total2 = Total.replace('.','');
					Total2 = parseFloat(Total.replace(',','.'));
					
					document.getElementById('Total_HTVA_21').value = format(frais_transport,2,'.');
					var total_tva_21 = parseFloat((frais_transport)*(TVA3-1));
					total_tva_212 = ArondirSuperieur(total_tva_21);
					total_tva_21 = format(ArondirSuperieur(total_tva_21),2,'.');
					document.getElementById('total_tva_21').value = total_tva_21;
					var total_ttc_0 = (frais_transport);
					total_ttc_0 = total_ttc_0.toFixed(2);
					
					total_ttc_0 = format(total_ttc_0,2,'.');
					//alert(total_ttc_0);
					document.getElementById('total_ttc_21').value = total_ttc_0;
					frais_transport = 0;
					break;
			}
		}
		
		//alert(Total);
		document.getElementById('Total_HTVA_0').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
		document.getElementById('total_tva_0').value = '0,00';
		document.getElementById('total_ttc_0').value = format(Total-DiscountHTVA+frais_transport+frais_transport_auto,2,'.');
	}
	
	var Total_HTVA_0 = document.getElementById('Total_HTVA_0').value;
	Total_HTVA_0 = Total_HTVA_0.replace('.','');
	Total_HTVA_0 = parseFloat(Total_HTVA_0.replace(',','.'));
	
	var Total_HTVA_6 = document.getElementById('Total_HTVA_6').value;
	Total_HTVA_6 = Total_HTVA_6.replace('.','');
	Total_HTVA_6 = parseFloat(Total_HTVA_6.replace(',','.'));
	
	var Total_HTVA_12 = document.getElementById('Total_HTVA_12').value;
	Total_HTVA_12 = Total_HTVA_12.replace('.','');
	Total_HTVA_12 = parseFloat(Total_HTVA_12.replace(',','.'));
	
	var Total_HTVA_21 = document.getElementById('Total_HTVA_21').value;
	Total_HTVA_21 = Total_HTVA_21.replace('.','');
	Total_HTVA_21 = parseFloat(Total_HTVA_21.replace(',','.'));
	
	
	if((document.getElementById('frais_transport') != null)){
		var TotalHTVA = Total_HTVA_0 + Total_HTVA_6 + Total_HTVA_12 + Total_HTVA_21;
	}else{
		TotalHTVA = 101;
	}
	
	if((document.getElementById('menu2') != null)){
		//alert(document.getElementById('menu2'));
		switch(document.getElementById('menu2').value){
			case '14':
				TotalHTVA = 101;
				break;
				
			case '13':
				TotalHTVA = 101;
				break;
				
			case '16':
				TotalHTVA = 101;
				break;
			case '24':
				TotalHTVA = 101;
				break;
		}
	}
	
	if((document.getElementById('menu3') != null)){
		//alert(document.getElementById('menu3').value);
		switch(document.getElementById('menu3').value){
			case '2':
				var menu = 2;
				break;
				
			default:
				var menu = -1;
		}
	}else{
		var menu = -1;
	}

	if(TotalHTVA < 100 && TotalHTVA != 0){
		var frais_transport = document.getElementById('frais_transport').value;
		frais_transport = parseFloat(frais_transport.replace(',','.'));
		var frais_transport_auto = document.getElementById('frais_transport_auto').value;
		frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
		if(transport1 != 1 && transport2 != 1 && transport3 != 1 && transport4 != 1 && frais_transport_auto == 0 && frais_transport == 0 && menu == 2){
			jConfirm('Voulez-vous inclure des frais de transport fournisseur ? ', 'Devis inférieur à 100 euros', function(r) {
				if(r == true){
					MyGo('','div_traitement_formulaire','freight_charges');
					if(document.getElementById(PaysClient).value == 'BELGIQUE'){
						//MyGo('','TabMontant','tab_montant');
						var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
						var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
						var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
						var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
					} else if(document.getElementById(DelivAddress).value == 'BELGIQUE'){
						var transport1 = CalculMontants('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0',TVA1);
						var transport2 = CalculMontants('Total_HTVA_option_6','tableLineBusinessRecords','Total_HTVA_6',TVA2);
						var transport3 = CalculMontants('Total_HTVA_option_12','tableLineBusinessRecords','Total_HTVA_12',TVA3);
						var transport4 = CalculMontants('Total_HTVA_option_21','tableLineBusinessRecords','Total_HTVA_21',TVA4);
					} else{
						var transport1 = CalculMontantsNoTVA('Total_HTVA_option_0','tableLineBusinessRecords','Total_HTVA_0');
						
						var frais_transport = document.getElementById('frais_transport').value;
						frais_transport = parseFloat(frais_transport.replace(',','.'));
						var frais_transport_auto = document.getElementById('frais_transport_auto').value;
						frais_transport_auto = parseFloat(frais_transport_auto.replace(',','.'));
						var Total = document.getElementById('Total_HTVA_0').value;
						Total = parseFloat(Total.replace(',','.'));
						document.getElementById('Total_HTVA_0').value = Total+frais_transport+frais_transport_auto;
					}
					
				}else{
					AllSousTotaux();
					Apayer();
					if(send != null && send != undefined){
						//RecalculateTotaux(PaysClient,DelivAddress);
						is_empty('SelectClient;nosref','');
					}
				}
			});
		}else{
			AllSousTotaux();
			Apayer();
			if(send != null && send != undefined){
				//RecalculateTotaux(PaysClient,DelivAddress);
				is_empty('SelectClient;nosref','');
			}
		}
	}
	else{
		AllSousTotaux();
		Apayer();
		if(send != null && send != undefined){
			//RecalculateTotaux(PaysClient,DelivAddress);
			//alert();
			is_empty('SelectClient;nosref','');
		}
	}
}

function RecalculateValidate(tableau,PRMO){
	var max = document.getElementById(tableau).rows.length;
	var PrixAchatTotal = parseFloat(document.getElementById("PrixAchatTotal").value);
	var TotalVente = 0;
	var TotalVenteProvision = 0;
	var TotalPoids = 0;
	var TotalPrixAchat = 0;
	var TotalQte = 0;
	var TotalQteArticle = 0;
	var TotalMargeMoyenne = 0;
	for (var i=0; i<max; i++) {
		if(document.getElementById("PrixAchat_"+i) != undefined && document.getElementById("escape_"+i).value == 0){
			var prixAchat = document.getElementById("PrixAchat_"+i).value.replace('.','');
			prixAchat = parseFloat(document.getElementById("PrixAchat_"+i).value.replace(',','.'));
			var Quantite = document.getElementById("Quantite_"+i).value.replace('.','')
			Quantite = parseFloat(Quantite.replace(',','.'))
			var TotalLigne = document.getElementById("Total_ligne_"+i).value.replace('.','')
			TotalLigne = parseFloat(TotalLigne.replace(',','.'))
			//alert(document.getElementById("Total_ligne_"+i).value);
			TotalPrixAchat = parseFloat(TotalPrixAchat) + (prixAchat * Quantite);
			TotalVente = parseFloat(TotalVente) + TotalLigne;
			TotalQteArticle = parseFloat(TotalQteArticle) + Quantite;
		}
		if(document.getElementById("SelectProvision_"+i) != undefined){
			var Quantite = document.getElementById("Quantite_"+i).value.replace('.','')
			Quantite = parseFloat(Quantite.replace(',','.'))
			var TotalLigne = document.getElementById("Total_ligne_"+i).value.replace('.','')
			TotalLigne = parseFloat(TotalLigne.replace(',','.'))
			//alert(document.getElementById("Total_ligne_"+i).value);
			TotalVenteProvision = parseFloat(TotalVenteProvision) + TotalLigne;
			TotalPoids = parseFloat(TotalPoids) + parseFloat(document.getElementById("Poids_"+i).value.replace(',','.'));
			TotalQte = parseFloat(TotalQte) + Quantite;
			TotalMargeMoyenne = TotalMargeMoyenne + (Quantite * PRMO * document.getElementById("Poids_"+i).value.replace(',','.'));
		}
	} 
	TotalPrixAchat = TotalPrixAchat.toFixed(2);
	document.getElementById("td_total_prix_achat").innerHTML = "<b>"+format(TotalPrixAchat,2,'.')+"</b>";
	
	TotalVente = parseFloat(TotalVente);
	TotalVente = TotalVente.toFixed(2);
	document.getElementById("td_total_prix_vente").innerHTML = "<b>"+format(TotalVente,2,'.')+"</b>";
	
	var BeneficeDevis = parseFloat(TotalVente) - parseFloat(TotalPrixAchat);
	BeneficeDevis = parseFloat(BeneficeDevis);
	BeneficeDevis = BeneficeDevis.toFixed(2);
	document.getElementById("td_total_benef").innerHTML = "<b>"+format(BeneficeDevis,2,'.')+"</b>";
	
	var CoefMarge = parseFloat(TotalVente/TotalPrixAchat);
	CoefMarge = parseFloat(CoefMarge);
	CoefMarge = CoefMarge.toFixed(2);
	if(CoefMarge == "NaN") CoefMarge = 0;
	document.getElementById("td_coef_marge").innerHTML = "<b>"+format(CoefMarge,2,'.')+"</b>";
	
	TotalAchatProvision = parseFloat(TotalMargeMoyenne);
	TotalAchatProvision = TotalAchatProvision.toFixed(2);
	document.getElementById("td_total_prix_achat_provision").innerHTML = "<b>"+format(TotalAchatProvision,2,'.')+"</b>";
	
	TotalVenteProvision = parseFloat(TotalVenteProvision);
	TotalVenteProvision = TotalVenteProvision.toFixed(2);
	document.getElementById("td_total_prix_vente_provision").innerHTML = "<b>"+format(TotalVenteProvision,2,'.')+"</b>";
	 
	TotalVenteProvision2 = parseFloat(TotalVenteProvision - TotalMargeMoyenne);
	TotalVenteProvision2 = TotalVenteProvision2.toFixed(2);
	document.getElementById("td_total_benef_provision").innerHTML = "<b>"+format(TotalVenteProvision2,2,'.')+"</b>";
	//alert(TotalVenteProvision+'/'+TotalMargeMoyenne);
	TotalMargeMoyenne = parseFloat(TotalVenteProvision/TotalMargeMoyenne);
	TotalMargeMoyenne = TotalMargeMoyenne.toFixed(2);
	if(TotalMargeMoyenne == "NaN") TotalMargeMoyenne = 0;
	document.getElementById("td_coef_marge_provision").innerHTML = "<b>"+format(TotalMargeMoyenne,2,'.')+"</b>";
	
}

function AllSousTotaux(){
	var nbr_lignes = document.getElementById('tableLineBusinessRecords').rows.length;
    //var rows = table.tBodies[0].rows;
    var debugStr = "";
    var color = 0;
    for (var i=0; i<nbr_lignes; i++) {
    	debugStr += document.getElementById('tableLineBusinessRecords').rows[i].id+";";
    	var tab = document.getElementById('tableLineBusinessRecords').rows[i].id.split("_");
    	if(document.getElementById('tableLineBusinessRecords').rows[i].id == 'deb_line_'+tab[2]+'_section'){
        	CalculSousTotal('tableLineBusinessRecords',document.getElementById('deb_line_'+tab[2]+'_section').rowIndex,document.getElementById('fin_line_'+tab[2]+'_section').rowIndex,'Sous_Total_ligne_'+tab[2]+'_section');
        	var color = 1;
    	}
    	else if(document.getElementById('tableLineBusinessRecords').rows[i].id == 'fin_line_'+tab[2]+'_section'){
    		var color = 0;
    	}       
    	if(document.getElementById('tableLineBusinessRecords').rows[i].id == 'deb_line_'+tab[2]+'_option'){
        	CalculSousTotal('tableLineBusinessRecords',document.getElementById('deb_line_'+tab[2]+'_option').rowIndex,document.getElementById('fin_line_'+tab[2]+'_option').rowIndex,'Sous_Total_ligne_'+tab[2]+'_option');
        	var color = 1;
    	}
    	else if(document.getElementById('tableLineBusinessRecords').rows[i].id == 'fin_line_'+tab[2]+'_option'){
    		var color = 0;
    	}
    	if(document.getElementById('tableLineBusinessRecords').rows[i].id == 'deb_line_'+tab[2]+'_variante'){
        	CalculSousTotal('tableLineBusinessRecords',document.getElementById('deb_line_'+tab[2]+'_variante').rowIndex,document.getElementById('fin_line_'+tab[2]+'_variante').rowIndex,'Sous_Total_ligne_'+tab[2]+'_variante');
        	var color = 1;
    	}
    	else if(document.getElementById('tableLineBusinessRecords').rows[i].id == 'fin_line_'+tab[2]+'_variante'){
    		var color = 0;
    	}
    	
    	if(color == 0){
			if(document.getElementById('Titre_'+tab[1]) != undefined){
			var tableau = document.getElementById("tableLineBusinessRecords").rows[i].id;
				if(tableau != ""){
		    		$('#'+tableau).removeClass();
		    		$('#'+tableau).addClass("Title");
				}
	    	}
	    	else if(document.getElementById('SousTitre_'+tab[1]) != undefined){
	    		if(tableau != ""){
		    		var tableau = document.getElementById("tableLineBusinessRecords").rows[i].id;
		    		$('#'+tableau).removeClass();
		    		$('#'+tableau).addClass("SubTitle");
	    		}
	    	}
	    	else if(document.getElementById('SousSousTitre_'+tab[1]) != undefined){
	    		if(tableau != ""){
		    		var tableau = document.getElementById("tableLineBusinessRecords").rows[i].id;
		    		$('#'+tableau).removeClass();
		    		$('#'+tableau).addClass("SubSubTitle");
	    		}
	    	}
	    	else if(document.getElementById('SelectArticle_'+tab[1]) != undefined){
	    		if(tableau != ""){	
		    		var tableau = document.getElementById("tableLineBusinessRecords").rows[i].id;
		    		$('#'+tableau).removeClass();
		    		$('#'+tableau).addClass("Article");
	    		}
	    	}
    	}
    }
    //MyGo(debugStr,'OrderLine','OrderLine');
    document.getElementById("ObjectOfLineBusinessRecords").value = debugStr;
    //alert(debugStr);
//    var tableau = debugStr.split(";");
//    var count = 0;
//    for (i = 0; i < tableau.length; i++) {
//    	if(tableau[i] != ""){
//    	  count = count +1;
//    	}
//    }
    //alert(count);
//    if(count == 1){
//    	var number = tableau[1].split("_");
//    	if(parseInt(number[1]) != "NaN"){
//    		
//    	}
//    	else{
//    		if(parseInt(number[2]) != "NaN"){
//    			
//    		}
//    	}
//    }
//    else{
//    	
//    }
}

function CalculSousTotal(tableau,depart,fin,input){
	var TheTotal = 0;
	var depart2 = parseInt(depart);
	var fin2 = parseInt(fin);
	var tab = input.split('_');
	for (var i=depart2; i<fin2; i++) {
		var name = document.getElementById(tableau).rows[i].id.split('_');
		if(document.getElementById('Total_ligne_'+name[1]) != undefined){
			TotalTmp = document.getElementById('Total_ligne_'+name[1]).value;
			TotalTmp = TotalTmp.replace('.','');
			TotalTmp = parseFloat(TotalTmp.replace(',','.'));
		
			TheTotal = parseFloat(TheTotal)+ TotalTmp;
			switch (tab[4]){
				case 'option':
					$('#'+document.getElementById(tableau).rows[i].id).removeClass();
					$('#'+document.getElementById(tableau).rows[i].id).addClass("option"); 
					break;
					
				case 'variante':
					$('#'+document.getElementById(tableau).rows[i].id).removeClass();
					$('#'+document.getElementById(tableau).rows[i].id).addClass("variante"); 
					break;
					
				case 'section':
					$('#'+document.getElementById(tableau).rows[i].id).removeClass();
					$('#'+document.getElementById(tableau).rows[i].id).addClass('section'); 		
					break;
			}
		}
	}
	//alert(document.getElementById(input));
	if(document.getElementById(input) != null){
		TheTotal = format(TheTotal,2,'.');
		document.getElementById(input).value = TheTotal;  
	}
}

function CalculMontants(input2,tableau,input,tva,tvaintitul){ 
	var TotTVA = 0;
	var TheTotalOption = 0;
	var max = document.getElementById(tableau).rows.length;
	var option = 0;
	var variante = 0;
	var transport = 0;
	var desactivtransport = 1;
	var TheTotal = 0;
	if(tvaintitul == null || tvaintitul == undefined) tvaintitul = tva;
	//alert(tva+','+tvaintitul);
	for (var i=1; i<max; i++) {
		var name = document.getElementById(tableau).rows[i].id;
		var tab = document.getElementById(tableau).rows[i].id.split('_');
		//alert(tab);
		//alert(document.getElementById(tableau).rows[i].id);
		switch(document.getElementById(tableau).rows[i].id){
		case 'line_'+tab[1] :
			if((document.getElementById('taux_de_tva_'+tab[1]) != null) && (document.getElementById('taux_de_tva_'+tab[1]).value == tvaintitul) && (document.getElementById('Total_ligne_'+tab[1]) != null) && (option == 0) && (variante == 0) ){
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TheTotal = parseFloat(TheTotal)+ TtotalLigne;
				//alert(TheTotal+'////'+TtotalLigne);
			}
			
			if((document.getElementById('taux_de_tva_'+tab[1]) != null) && (document.getElementById('taux_de_tva_'+tab[1]).value == tva) && (document.getElementById('Total_ligne_'+tab[1]) != null) && (option == 1) && (variante == 0) ){
				//alert(document.getElementById('Total_ligne_'+tab[1]).value);
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TheTotalOption = parseFloat(TheTotalOption)+ TtotalLigne;
			}
			
			if(document.getElementById('SelectArticle_'+tab[1]) != undefined){
				if(document.getElementById('SelectArticle_'+tab[1]).value == 'TRANSPORTAUTO'){
					var transport = 1;
				}
			}
			
			if(document.getElementById('SelectAcompte_'+tab[1]) != undefined){
				if(document.getElementById('SelectAcompte_'+tab[1]).value == 'L'){
					desactivtransport = 0;
				}
			}
			break;
		
		case 'deb_line_'+tab[2]+'_option' :
			option = 1;
			var num_option = tab[2];
			break;
		
		case 'fin_line_'+num_option+'_option' :
			option = 0;
			var num_option = 0;
			break;
		
		case 'deb_line_'+tab[2]+'_variante' :
			variante = 1;
			var num_variante = tab[2];
			break;
	
		case 'fin_line_'+num_variante+'_variante' :
			variante = 0;
			var num_variante = 0;
			break;
		}
	}
	
	if(desactivtransport == 0) transport = 1;
	//alert(transport);
	//alert(TheTotal);
	TheTotal = ArondirSuperieur(TheTotal);
	//alert(input+': '+format(TheTotal,2,'.'));
	document.getElementById(input).value = format(TheTotal,2,'.');
	TTC = TheTotal * (1 + (parseInt(tva) /100));
	TotTVA = TTC - TheTotal;
	TotTVA = ArondirSuperieur(TotTVA);
	var tabtmp = input.split('_');
	//alert('total_tva_'+tva+': '+TotTVA);
	document.getElementById('total_tva_'+tabtmp[2]).value = format(TotTVA,2,'.');
	TTC = ArondirSuperieur(TTC);
	//alert('total_ttc_'+tva+': '+TTC);
	document.getElementById('total_ttc_'+tabtmp[2]).value = format(TTC,2,'.');
	
	TheTotalOption = ArondirSuperieur(TheTotalOption);
	document.getElementById(input2).value = format(TheTotalOption,2,'.');
	TTC = TheTotalOption * (1 + (parseInt(tva) /100));
	TotTVA = TTC - TheTotalOption;
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_option_'+tabtmp[2]).value = format(TotTVA,2,'.');
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_option_'+tabtmp[2]).value = format(TTC,2,'.');
	
	return transport;
}

function CalculMontantsNoTVA(input2,tableau,input){
	var TheTotal = 0;
	var TheTotalOption = 0;
	var max = document.getElementById(tableau).rows.length;
	var option = 0;
	var variante = 0;
	var transport = 0;
	for (var i=1; i<max; i++) {
		var name = document.getElementById(tableau).rows[i].id;
		var tab = document.getElementById(tableau).rows[i].id.split('_');
		//alert(tab);
		//alert(document.getElementById(tableau).rows[i].id);
		switch(document.getElementById(tableau).rows[i].id){
		case 'line_'+tab[1] :
			if((document.getElementById('taux_de_tva_'+tab[1]) != null) && (document.getElementById('Total_ligne_'+tab[1]) != null) && (option == 0) && (variante == 0) ){
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TheTotal = parseFloat(TheTotal)+ TtotalLigne;
				//alert(TheTotal+'////'+TtotalLigne);
			}
			
			if((document.getElementById('taux_de_tva_'+tab[1]) != null) && (document.getElementById('Total_ligne_'+tab[1]) != null) && (option == 1) && (variante == 0) ){
				//alert(document.getElementById('Total_ligne_'+tab[1]).value);
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TheTotalOption = parseFloat(TheTotalOption)+ TtotalLigne;
			}
			
			if(document.getElementById('SelectArticle_'+tab[1]) != undefined){
				if(document.getElementById('SelectArticle_'+tab[1]).value == 'TRANSPORTAUTO'){
					var transport = 1;
				}
			}
			break;
		
		case 'deb_line_'+tab[2]+'_option' :
			option = 1;
			var num_option = tab[2];
			break;
		
		case 'fin_line_'+num_option+'_option' :
			option = 0;
			var num_option = 0;
			break;
		
		case 'deb_line_'+tab[2]+'_variante' :
			variante = 1;
			var num_variante = tab[2];
			break;
	
		case 'fin_line_'+num_variante+'_variante' :
			variante = 0;
			var num_variante = 0;
			break;
		}
	}
	
	document.getElementById(input).value = format(TheTotal,2,'.');
	
	document.getElementById('total_tva_0').value = '0,00';

	document.getElementById('total_ttc_0').value = format(TheTotal,2,'.');
	
	TheTotalOption = ArondirSuperieur(TheTotalOption);
	document.getElementById(input2).value = format(TheTotalOption,2,'.');
	TTC = parseFloat(TheTotalOption);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_option_0').value = format(TotTVA,2,'.');
	ArondirSuperieur(TTC);
	document.getElementById('total_ttc_option_0').value = format(TTC,2,'.');
	
	document.getElementById('Total_HTVA_21').value = '0,00';
	TTC = parseFloat(0);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_21').value = '0,00';
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_21').value = '0,00';
	
	document.getElementById('Total_HTVA_option_21').value = '0,00';
	TTC = parseFloat(0);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_option_21').value = '0,00';
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_option_21').value = '0,00';
	
	document.getElementById('Total_HTVA_12').value = '0,00';
	TTC = parseFloat(0);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_12').value = '0,00';
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_12').value = '0,00';
	
	document.getElementById('Total_HTVA_option_12').value = '0.00';
	TTC = parseFloat(0);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_option_12').value = '0,00';
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_option_12').value = '0,00';
	
	document.getElementById('Total_HTVA_6').value = '0,00';
	TTC = parseFloat(0);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_6').value = '0,00';
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_6').value = '0,00';
	
	document.getElementById('Total_HTVA_option_6').value = '0,00';
	TTC = parseFloat(0);
	TotTVA = parseFloat(0);
	TotTVA = ArondirSuperieur(TotTVA);
	document.getElementById('total_tva_option_6').value = '0,00';
	TTC = ArondirSuperieur(TTC);
	document.getElementById('total_ttc_option_6').value = '0,00';
	
	return transport;
}

function ArondirSuperieur(valeur){
	valeur =  valeur * 100;
	valeur = Math.round(valeur);
	valeur = valeur / 100;
	
	return valeur;
}

function getArrondi(nb, N) {
  return Math.round(Math.pow(10,N)*nb)/Math.pow(10,N);
}

function verifTaxe(valeur,article,num_line){
	var max = document.getElementById("tableLineBusinessRecords").rows.length;
	for (var i=1; i<max; i++) {
		var name = document.getElementById("tableLineBusinessRecords").rows[i].id;
		var tab = document.getElementById("tableLineBusinessRecords").rows[i].id.split('_');
		if(document.getElementById('Tax_liee_'+tab[1]) != null){
			if(document.getElementById('Tax_liee_'+tab[1]).value == article+':'+num_line){
				document.getElementById('Quantite_'+tab[1]).value = valeur;
				var PrixUnitaire = document.getElementById('PrixUnitaire_'+tab[1]).value;
				PrixUnitaire = parseFloat(PrixUnitaire.replace(',','.'))
				total_line = parseFloat(valeur) * PrixUnitaire
				var total_line = ArondirSuperieur(total_line);
				document.getElementById('Total_ligne_'+tab[1]).value = format(total_line,2,'.');
			}
		}
	}
}

function verifArticleLink(valeur,article,num_line){
	var max = document.getElementById("tableLineBusinessRecords").rows.length;
	for (var i=1; i<max; i++) {
		var name = document.getElementById("tableLineBusinessRecords").rows[i].id;
		var tab = document.getElementById("tableLineBusinessRecords").rows[i].id.split('_');
		if(document.getElementById('Article_lie_'+tab[1]) != null){
			if(document.getElementById('Article_lie_'+tab[1]).value == article+':'+num_line){
				document.getElementById('Quantite_'+tab[1]).value = format(valeur,2,'.');
				var PrixUnitaire = document.getElementById('PrixUnitaire_'+tab[1]).value;
				PrixUnitaire = parseFloat(PrixUnitaire.replace(',','.'))
				total_line = parseFloat(valeur) * PrixUnitaire
				var total_line = ArondirSuperieur(total_line);
				document.getElementById('Total_ligne_'+tab[1]).value = format(total_line,2,'.');
			}
		}
	}
}

function DeleteRowTaxe(article,num_line){
	var max = document.getElementById("tableLineBusinessRecords").rows.length;
	for (var i=1; i<max; i++) {
		if(document.getElementById("tableLineBusinessRecords").rows[i] != undefined){
			var name = document.getElementById("tableLineBusinessRecords").rows[i].id;
			var tab = document.getElementById("tableLineBusinessRecords").rows[i].id.split('_');
			if(document.getElementById('Tax_liee_'+tab[1]) != null){
				if(document.getElementById('Tax_liee_'+tab[1]).value == article+':'+num_line){
					document.getElementById("tableLineBusinessRecords").deleteRow(i);
					if(document.getElementById('id_line_business_records_'+tab[1]) != null){
						$( "#id_line_business_records_"+tab[1] ).remove();
					}
					i--;
				}
			}
		}
	}
}

function UpdateRowTaxeVAT(article,num_line){
	var max = document.getElementById("tableLineBusinessRecords").rows.length;
	//alert(max)
	for (var i=0; i<max; i++) {
		if(document.getElementById("tableLineBusinessRecords").rows[i] != undefined){
			var name = document.getElementById("tableLineBusinessRecords").rows[i].id;
			var tab = document.getElementById("tableLineBusinessRecords").rows[i].id.split('_');
			if(document.getElementById('Tax_liee_'+tab[1]) != null){
				if(document.getElementById('Tax_liee_'+tab[1]).value == article+':'+num_line){
					document.getElementById('taux_de_tva_'+tab[1]).value = document.getElementById('taux_de_tva_'+num_line).value;
				}
			}
		}
	}
}

function DeleteRowLinkArticle(article,num_line){
	var max = document.getElementById("tableLineBusinessRecords").rows.length;
	for (var i=1; i<max; i++) {
		if(document.getElementById("tableLineBusinessRecords").rows[i] != undefined){
			var name = document.getElementById("tableLineBusinessRecords").rows[i].id;
			var tab = document.getElementById("tableLineBusinessRecords").rows[i].id.split('_');
			if(document.getElementById('Article_lie_'+tab[1]) != null){
				if(document.getElementById('Article_lie_'+tab[1]).value == article+':'+num_line){
					document.getElementById("tableLineBusinessRecords").deleteRow(i);
					if(document.getElementById('id_line_business_records_'+tab[1]) != null){
						$( "#id_line_business_records_"+tab[1] ).remove();
					}
					i--;
				}
			}
		}
	}
}


function verifMontant(){
	var nb = 1;
		if(document.getElementById('Total_HTVA_0').value == '0.00'){
			document.getElementById('Titre').deleteCell(nb);
			document.getElementById('HTVA').deleteCell(nb);
			document.getElementById('TVA').deleteCell(nb);
			document.getElementById('TTC').deleteCell(nb);
			document.getElementById('APAYER').deleteCell(nb);
		}
		else{
			nb++;
		}
	
		if(document.getElementById('Total_HTVA_6').value == '0.00'){
			document.getElementById('Titre').deleteCell(nb);
			document.getElementById('HTVA').deleteCell(nb);
			document.getElementById('TVA').deleteCell(nb);
			document.getElementById('TTC').deleteCell(nb);
			document.getElementById('APAYER').deleteCell(nb);
		}
		else{
			nb++;
		}
	
		if(document.getElementById('Total_HTVA_12').value == '0.00'){
			document.getElementById('Titre').deleteCell(nb);
			document.getElementById('HTVA').deleteCell(nb);
			document.getElementById('TVA').deleteCell(nb);
			document.getElementById('TTC').deleteCell(nb);
			document.getElementById('APAYER').deleteCell(nb);
		}
		else{
			nb++;
		}
	
		if(document.getElementById('Total_HTVA_21').value == '0.00'){
			document.getElementById('Titre').deleteCell(nb);
			document.getElementById('HTVA').deleteCell(nb);
			document.getElementById('TVA').deleteCell(nb);
			document.getElementById('TTC').deleteCell(nb);
			document.getElementById('APAYER').deleteCell(nb);
		}
		else{
			nb++;
		}
		
		var nb = 1;
		if(document.getElementById('Total_HTVA_option_0').value == '0.00'){
			document.getElementById('Titre_option').deleteCell(nb);
			document.getElementById('HTVA_option').deleteCell(nb);
			document.getElementById('TVA_option').deleteCell(nb);
			document.getElementById('TTC_option').deleteCell(nb);
			document.getElementById('APAYER_option').deleteCell(nb);
		}
		else{
			nb++;
		}
	
		if(document.getElementById('Total_HTVA_option_6').value == '0.00'){
			document.getElementById('Titre_option').deleteCell(nb);
			document.getElementById('HTVA_option').deleteCell(nb);
			document.getElementById('TVA_option').deleteCell(nb);
			document.getElementById('TTC_option').deleteCell(nb);
			document.getElementById('APAYER_option').deleteCell(nb);
		}
		else{
			nb++;
		}
	
		if(document.getElementById('Total_HTVA_option_12').value == '0.00'){
			document.getElementById('Titre_option').deleteCell(nb);
			document.getElementById('HTVA_option').deleteCell(nb);
			document.getElementById('TVA_option').deleteCell(nb);
			document.getElementById('TTC_option').deleteCell(nb);
			document.getElementById('APAYER_option').deleteCell(nb);
		}
		else{
			nb++;
		}
	
		if(document.getElementById('Total_HTVA_option_21').value == '0.00'){
			document.getElementById('Titre_option').deleteCell(nb);
			document.getElementById('HTVA_option').deleteCell(nb);
			document.getElementById('TVA_option').deleteCell(nb);
			document.getElementById('TTC_option').deleteCell(nb);
			document.getElementById('APAYER_option').deleteCell(nb);
		}
		
}

function Apayer(){
	var total_ttc_option_0 = document.getElementById('total_ttc_option_0').value;
	total_ttc_option_0 = total_ttc_option_0.replace('.','');
	total_ttc_option_0 = total_ttc_option_0.replace(',','.');
	total_ttc_option_0 = parseFloat(total_ttc_option_0);
	
	var total_ttc_option_6 = document.getElementById('total_ttc_option_6').value;
	total_ttc_option_6 = total_ttc_option_6.replace('.','');
	total_ttc_option_6 = total_ttc_option_6.replace(',','.');
	total_ttc_option_6 = parseFloat(total_ttc_option_6);
	
	var total_ttc_option_12 = document.getElementById('total_ttc_option_12').value;
	total_ttc_option_12 = total_ttc_option_12.replace('.','');
	total_ttc_option_12 = total_ttc_option_12.replace(',','.');
	total_ttc_option_12 = parseFloat(total_ttc_option_12);
	
	var total_ttc_option_21 = document.getElementById('total_ttc_option_21').value;
	total_ttc_option_21 = total_ttc_option_21.replace('.','');
	total_ttc_option_21 = total_ttc_option_21.replace(',','.');
	total_ttc_option_21 = parseFloat(total_ttc_option_21);
	
	APAYER = total_ttc_option_0 + total_ttc_option_6 + total_ttc_option_12 + total_ttc_option_21 ;
	document.getElementById('a_payer_option').value = format(APAYER,2,'.');
	
	var total_ttc_0 = document.getElementById('total_ttc_0').value;
	total_ttc_0 = total_ttc_0.replace('.','');
	total_ttc_0 = total_ttc_0.replace(',','.');
	total_ttc_0 = parseFloat(total_ttc_0);
	
	var total_ttc_6 = document.getElementById('total_ttc_6').value;
	total_ttc_6 = total_ttc_6.replace('.','');
	total_ttc_6 = total_ttc_6.replace(',','.');
	total_ttc_6 = parseFloat(total_ttc_6);
	
	var total_ttc_12 = document.getElementById('total_ttc_12').value;
	total_ttc_12 = total_ttc_12.replace('.','');
	total_ttc_12 = total_ttc_12.replace(',','.');
	total_ttc_12 = parseFloat(total_ttc_12);
	
	var total_ttc_21 = document.getElementById('total_ttc_21').value;
	total_ttc_21 = total_ttc_21.replace('.','');
	total_ttc_21 = total_ttc_21.replace(',','.');
	total_ttc_21 = parseFloat(total_ttc_21);
	
	APAYER = total_ttc_0 + total_ttc_6 + total_ttc_12 + total_ttc_21 ;
	document.getElementById('a_payer').value =  format(APAYER,2,'.');
	
	// if(document.getElementById('acompte').value != undefined){
		// if(document.getElementById('a_payer').value > 3000){
			// document.getElementById('SelectAcompte').value = "1";
			// SelAcompte('SelectAcompte','acompte','btn_acompte');
		// }
		// else{
			// SelAcompte('SelectAcompte','acompte','btn_acompte');
		// }
		// CalculAcompte();
	// }
	CalculAcompte();
	//verifMontant();

}

function CalculAcompte(){
	if(document.getElementById('type_demande_devis') != null){
		if(document.getElementById('type_demande_devis').value != 1){
			var APAYER = document.getElementById('a_payer').value;
			APAYER = APAYER.replace('.','');
			APAYER = APAYER.replace(',','.');
			APAYER = parseFloat(APAYER);
			if((APAYER < 3000) && (document.getElementById('SelectAcompte').value == "1")){
				resultat = 0;
			}
			else{
				var percent = document.getElementById('acompte').value;
				//alert(percent);
				percent = parseFloat(1) - (parseFloat(percent)/100);
				//alert(percent);
				var resultat = APAYER * percent;
				//alert(resultat);
				resultat = APAYER - resultat;
				//alert(resultat);
				
			}
			if(document.getElementById('SelectAcompte').value == "3"){
				resultat =0;
				document.getElementById('lblacompte').innerHTML = '0';
				document.getElementById('acompte').value = 0;
			}
			resultat = ArondirSuperieur(resultat);
			document.getElementById('montant_acompte').value = resultat.toFixed(2);
			document.getElementById('lblmontantacompte').innerHTML = format(resultat,2,'.');
			
		}else{
			document.getElementById('SelectAcompte').value = "3";
			document.getElementById('montant_acompte').value = 0;
			document.getElementById('lblmontantacompte').innerHTML = '0';
			document.getElementById('montant_acompte').value = 0;
			document.getElementById('lblacompte').innerHTML = '0';
			document.getElementById('acompte').value = 0;
		}
	}
}

function AddRow(element,elem,file){
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
	while(document.getElementById("line_"+nbr_lignes) != null){
		nbr_lignes = nbr_lignes + 1;
	}
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	$('#'+newRow.id).addClass("Article");
	
	if(file == null || file == undefined){ 
		file = 'actions_lines';
	
		var newCell = newRow.insertCell(0);
		newCell.id = "TDaction_"+nbr_lignes;
			MyGo('action;'+nbr_lignes,newCell.id,file);
			
		var newCell = newRow.insertCell(1);
		newCell.id = "TDreference_"+nbr_lignes;
			MyGo('champ;'+nbr_lignes,newCell.id,file);
			
		var newCell = newRow.insertCell(2);
		newCell.id = "TDmarque_"+nbr_lignes;
			newCell.innerHTML = ' ';	
			
		var newCell = newRow.insertCell(3);
		newCell.id = "TDdesignation_"+nbr_lignes;
			newCell.innerHTML = ' ';
			
		var newCell = newRow.insertCell(4);
		newCell.id = "TDrecurrence_"+nbr_lignes;
			newCell.innerHTML = ' ';
			
		var newCell = newRow.insertCell(5);
		newCell.id = "TDquantite_"+nbr_lignes;
			newCell.innerHTML = ' ';
		
		
		var newCell = newRow.insertCell(6);
		newCell.id = "TDcoefficient_"+nbr_lignes;
			newCell.innerHTML = ' ';
		
		var CellIndex = 7;
		if(document.getElementById(element).rows[0].cells.length > 12){
			var newCell = newRow.insertCell(CellIndex);
			newCell.id = "TDcoefficient_"+nbr_lignes;
				newCell.innerHTML = ' ';
				
				CellIndex++;
		}	
		var newCell = newRow.insertCell(CellIndex);
		newCell.id = "TDprix_unitaire_"+nbr_lignes;
			newCell.innerHTML = ' ';
			CellIndex++;
			
		var newCell = newRow.insertCell(CellIndex);
		newCell.id = "TDpourcentage_"+nbr_lignes;
			newCell.innerHTML = ' ';
			CellIndex++;
			
		var newCell = newRow.insertCell(CellIndex);
		newCell.id = "TDcoefficient_remise_"+nbr_lignes;
			newCell.innerHTML = ' ';
			CellIndex++;
			
		var newCell = newRow.insertCell(CellIndex);
		newCell.id = "TDprix_unitaire_remise_"+nbr_lignes;
			newCell.innerHTML = ' ';
			CellIndex++;
			
		var newCell = newRow.insertCell(CellIndex);
		newCell.id = "TDtotal_"+nbr_lignes;
			newCell.innerHTML = ' ';
			CellIndex++;
			
	} else{
		var newCell = newRow.insertCell(0);
		newCell.id = "TDaction_"+nbr_lignes;
			MyGo('action;'+nbr_lignes,newCell.id,file);
			
		var newCell = newRow.insertCell(1);
		newCell.id = "TDreference_"+nbr_lignes;
			newCell.innerHTML = 'Commission';
			
		var newCell = newRow.insertCell(2);
		newCell.id = "TDmarque_"+nbr_lignes;
			newCell.innerHTML = '<textarea name="description_'+nbr_lignes+'" id="description_'+nbr_lignes+'" rows="6" cols="50">Tapez la description de la commission</textarea>';	
			
		var newCell = newRow.insertCell(3);
		newCell.id = "TDdesignation_"+nbr_lignes;
			MyGo('quantite;'+nbr_lignes,newCell.id,file);
			
		var newCell = newRow.insertCell(4);
		newCell.id = "TDrecurrence_"+nbr_lignes;
			MyGo('prixUnitaire;'+nbr_lignes,newCell.id,file);
			
		var newCell = newRow.insertCell(5);
		newCell.id = "TDquantite_"+nbr_lignes;
			MyGo('total;'+nbr_lignes,newCell.id,file);
			
		var newCell = newRow.insertCell(6);
		newCell.id = "TDtotal_"+nbr_lignes;
			MyGo('imputation;'+nbr_lignes,newCell.id,file);
		
	}	
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
		Regenerate_table_drag_and_drop();
    
}

function AddRow2(element,elem,nb_cols,file){
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
	while(document.getElementById("line_"+nbr_lignes) != null){
		nbr_lignes = nbr_lignes + 1;
	}
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	
	if(file == null || file == undefined) file = 'add_row_supply';
	
	//alert(file);
	MyGo(nb_cols+';'+nbr_lignes,"line_"+nbr_lignes,file);
	
	var nbr_lignes = document.getElementById('tableLineBusinessRecords').rows.length;
	
	if(document.getElementById('Total_lignes') != null) document.getElementById('Total_lignes').value = nbr_lignes;
	
	Regenerate_table_drag_and_drop();
    
}

function AddRowTax(element,elem,chaine,file){
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
	while(document.getElementById("line_"+nbr_lignes) != null){
		nbr_lignes = nbr_lignes + 1;
	}
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	$('#'+newRow.id).addClass("Article");
	
	var newCell = newRow.insertCell(0);
	newCell.id = "TDaction_"+nbr_lignes;
		newCell.innerHTML = ' ';

		
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
		Regenerate_table_drag_and_drop();
		//alert(file);
		chaine = encodeURIComponent(chaine);
		if(file == null || file == undefined) file = 'get_taxes_articles';
		MyGo(chaine+";"+nbr_lignes+";"+nbr_lignes,"line_"+nbr_lignes,file);
    
}

function AddRowArticleLinked(element,elem,chaine){
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
	while(document.getElementById("line_"+nbr_lignes) != null){
		nbr_lignes = nbr_lignes + 1;
	}
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	$('#'+newRow.id).addClass("Article");
	
	var newCell = newRow.insertCell(0);
	newCell.id = "TDaction_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(1);
	newCell.id = "TDreference_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(2);
	newCell.id = "TDmarque_"+nbr_lignes;
		newCell.innerHTML = ' ';	
		
	var newCell = newRow.insertCell(3);
	newCell.id = "TDdesignation_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(4);
	newCell.id = "TDrecurrence_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(5);
	newCell.id = "TDquantite_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(6);
	newCell.id = "TDcoefficient_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(7);
	newCell.id = "TDprix_unitaire_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(8);
	newCell.id = "TDpourcentage_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(9);
	newCell.id = "TDcoefficient_remise_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(10);
	newCell.id = "TDprix_unitaire_remise_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(11);
	newCell.id = "TDtotal_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
		Regenerate_table_drag_and_drop();
		chaine = encodeURIComponent(chaine);
		MyGo(chaine+";"+nbr_lignes,"line_"+nbr_lignes,'get_info_link_article');
    
}

function AddRowSupplyLinked(element,elem,chaine){
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
	while(document.getElementById("line_"+nbr_lignes) != null){
		nbr_lignes = nbr_lignes + 1;
	}
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	$('#'+newRow.id).addClass("Provision");
	
	var newCell = newRow.insertCell(0);
	newCell.id = "TDaction_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(1);
	newCell.id = "TDreference_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(2);
	newCell.id = "TDmarque_"+nbr_lignes;
		newCell.innerHTML = ' ';	
		
	var newCell = newRow.insertCell(3);
	newCell.id = "TDdesignation_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(4);
	newCell.id = "TDrecurrence_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(5);
	newCell.id = "TDquantite_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(6);
	newCell.id = "TDcoefficient_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(7);
	newCell.id = "TDprix_unitaire_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(8);
	newCell.id = "TDpourcentage_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(9);
	newCell.id = "TDcoefficient_remise_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(10);
	newCell.id = "TDprix_unitaire_remise_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(11);
	newCell.id = "TDtotal_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
		Regenerate_table_drag_and_drop();
		chaine = encodeURIComponent(chaine);
		MyGo(chaine+";"+nbr_lignes,"line_"+nbr_lignes,'get_info_link_supply');
}

function AddRowConditionLinked(element,elem,chaine){
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
	while(document.getElementById("line_"+nbr_lignes) != null){
		nbr_lignes = nbr_lignes + 1;
	}
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	$('#'+newRow.id).addClass("Article");
	
	var newCell = newRow.insertCell(0);
	newCell.id = "TDaction_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(1);
	newCell.id = "TDreference_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(2);
	newCell.id = "TDmarque_"+nbr_lignes;
		newCell.innerHTML = ' ';	
		
	var newCell = newRow.insertCell(3);
	newCell.id = "TDdesignation_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(4);
	newCell.id = "TDrecurrence_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(5);
	newCell.id = "TDquantite_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(6);
	newCell.id = "TDcoefficient_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(7);
	newCell.id = "TDprix_unitaire_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(8);
	newCell.id = "TDpourcentage_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(9);
	newCell.id = "TDcoefficient_remise_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(10);
	newCell.id = "TDprix_unitaire_remise_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
	var newCell = newRow.insertCell(11);
	newCell.id = "TDtotal_"+nbr_lignes;
		newCell.innerHTML = ' ';
		
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
		Regenerate_table_drag_and_drop();
		chaine = encodeURIComponent(chaine);
		MyGo(chaine+";"+nbr_lignes,"line_"+nbr_lignes,'get_info_condition');
}

function VerifSuppRow(element,elem){
	var tab =element.split('_');
	
	var m = document.getElementById(elem).rowIndex; 
	var nbr_lignes = (document.getElementById(element).rows.length) + 1;
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "line_"+nbr_lignes;
	var newCell = newRow.insertCell(0);
	newCell.id = "action_"+nbr_lignes;
		MyGo('action;'+nbr_lignes,newCell.id,'actions_lines');
	var newCell = newRow.insertCell(1);
	newCell.id = "champ_"+nbr_lignes;
		MyGo('champ;'+nbr_lignes,newCell.id,'actions_lines');
	var newCell = newRow.insertCell(2);
	newCell.id = "resultat_"+nbr_lignes;
		newCell.innerHTML = '<div id="Get_info_article_'+nbr_lignes+'"></div>';
		
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
		Regenerate_table_drag_and_drop();
    
}

function AddRowSousTotal(element,elem,num,tag,tag2){
	var m = document.getElementById(elem).rowIndex; 
	document.getElementById(elem).id = "deb_line_"+num+"_"+tag2;
	//var nbr_lignes = (document.getElementById(element).rows.length) ;
    var newRow = document.getElementById(element).insertRow(m);
	newRow.id = "fin_line_"+num+"_"+tag2;
	MyGo(tag+';'+num,newRow.id,'load_format_or_article');
		
		/*
		http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
		*/
	Regenerate_table_drag_and_drop();
    
}

function DeleteRow(element,tableau){
	if(document.getElementById(element) != null){
		var m = document.getElementById(element).rowIndex; 
		document.getElementById(tableau).deleteRow(m);
		var tmp = element.split('_');
		
		if(tmp.length > 2) var tmp2 = tmp[2]; else var tmp2 = tmp[1];
		//alert(tmp2);
		if(document.getElementById('id_line_business_records_'+tmp2) != null){
			$( "#id_line_business_records_"+tmp2 ).remove();
		}
	}
}


function decrementation(valeur,valeur2,min){
	var format = document.getElementById(valeur).value;
	format = format.replace(",",".");
	if(parseFloat(format) - parseFloat(valeur2) >= min){
		variable = parseFloat(format);
		variable2 = parseFloat(valeur2);
		variable3 = variable - variable2;
		resultat = Math.round(variable3*100)/100;
		document.getElementById(valeur).value = resultat;
		document.getElementById(valeur).focus();
	}
}

function incrementation(valeur,valeur2,max){
	if(max != undefined){
		var format = document.getElementById(valeur).value;
		format = format.replace(",",".");
		if(parseFloat(format) + parseFloat(valeur2) <= max){
			variable = parseFloat(format);
			variable2 = parseFloat(valeur2);
			variable3 = variable + variable2;
			resultat = Math.round(variable3*100)/100;
			document.getElementById(valeur).value = resultat;
			document.getElementById(valeur).focus();
		}
	}
	else{	
		var format = document.getElementById(valeur).value;
		format = format.replace(",",".");
		variable = parseFloat(format);
		variable2 = parseFloat(valeur2);
		variable3 = variable + variable2;
		resultat = Math.round(variable3*100)/100;
		document.getElementById(valeur).value = resultat;
		document.getElementById(valeur).focus();
	}
}

function limit_max(valeur, limit){
	var format = document.getElementById(valeur).value;
	format = format.replace(",",".");
	if(format > limit){
		document.getElementById(valeur).value = limit;
		document.getElementById(valeur).focus();
	}
}

function limit_min(valeur, limit){
	var format = document.getElementById(valeur).value;
		format = format.replace(",",".");
	if(format < limit){
		document.getElementById(valeur).value = limit;
		document.getElementById(valeur).focus();
	}
}

function CodeCiel(ID,ID2,CODECIEL){
	switch(document.getElementById(ID).options[document.getElementById(ID).selectedIndex].text){
		case 'Prospect' :
			document.getElementById(CODECIEL).value = '400'+document.getElementById(ID2).value;
			break;
		
		case 'Fournisseur' :
			document.getElementById(CODECIEL).value = '440'+document.getElementById(ID2).value;
			break;
			
		case 'Client':
			document.getElementById(CODECIEL).value = '400'+document.getElementById(ID2).value;
			break;
			
		default :
			
			break;
	}
}

function verif_nombre(champ){
	var chiffres = new RegExp("[0-9]");
	var verif;
	var points = 0;
 
	for(x = 0; x < champ.value.length; x++)
	{
            verif = chiffres.test(champ.value.charAt(x));
	    if(champ.value.charAt(x) == "."){points++;}
            if(points > 1){verif = false; points = 1;}
  	    if(verif == false){champ.value = champ.value.substr(0,x) + champ.value.substr(x+1,champ.value.length-x+1); x--;}
	}
}

function verif_float(champ){
	var chiffres = new RegExp(/^[\+\-]?[0-9]+(([\.\,][0-9]{1})|([\.\,][0-9]{2}))?$/);
	var verif;
	var points = 0;

	for(x = 0; x < champ.value.length; x++)
	{
				verif = chiffres.test(champ.value.charAt(x));
		 if(champ.value.charAt(x) == "."){points++;}
				if(points > 1){verif = false; points = 1;}
		 if(verif == false){champ.value = champ.value.substr(0,x) + champ.value.substr(x+1,champ.value.length-x+1); x--;}
	}
}
  
function codeTouche(evenement)
{
for (prop in evenement)
{
if(prop == 'which') return(evenement.which);
}
return(evenement.keyCode);
}

function test1(str) {
	str = alltrim(str);
	return /^[-+]?[0-9]+(\.[0-9]+)?$/.test(str);
}

function scanTouche(evenement)
{
var reCarValides = /[\d\.,]/;

var codeDecimal = codeTouche(evenement);
var car = String.fromCharCode(codeDecimal);
var autorisation = reCarValides.test(car);

return autorisation;
}

function isFloatCalcul(value,id,id2){
	if (value != ""){
		var nombre = new String(value.replace(/,/,"."));
		if (isNaN(nombre) == true){
		jAlert("Veuillez entrer un nombre correct !");
		document.getElementById(id).value = "";
		document.getElementById(id2).value = "";
		document.getElementById(id).focus;
		}
	}
}

function isAlphanumeric( str ) {
	 
	return /^[0-9a-zA-Z]+$/.test(str);
	 
}

function isFloat(value,id){
	if (value != ""){
		var nombre = new String(value.replace(/,/,"."));
		if (isNaN(nombre) == true){
		jAlert("Veuillez entrer un nombre correct !");
		document.getElementById(id).value = "";
		document.getElementById(id).focus;
		}
	}
}

function regenerateTextarea(textarea){
var val = CKEDITOR.instances[textarea].getData();
document.getElementById(textarea).value = trim(val);

}

function CheckBox(id,id2){
    var cb2_state = document.getElementById(id2).checked;
	if (document.getElementById(id).checked == false){
    document.getElementById(id).checked = cb2_state;
	}
}

function DeCheckBox(id,id2){
    var cb2_state = document.getElementById(id2).checked;
	if (document.getElementById(id).checked == true){
    document.getElementById(id).checked = cb2_state;
	}
}

// Script du Code Barre : verifie si le code barre est valide ( si 13 chiffres) 
// ou génére le 13 ème chiffre (si 12 chiffres) et dessine le Code de barre
function EAN13(codeBarrebox,codeBarre,Value,table,champ){
   cb = document.getElementById(codeBarre).value;
   val = cb;
   if(val != ""){
	   if (isNaN(cb)||cb.length!=12) {
		   recup13 = cb.charAt(12); //Attention, le premier caractère a comme indice 0.
		   //alert(recup13);
		   recup12 = cb.substring(0,12);
		   cb = recup12;
		   //alert(cb);
		   divEAN = document.getElementById("EAN13CODE");
		   divEAN.innerHTML="";
		   codes = new Array();
		   for (var i=a=b=0;i<12;i++) {
			   codes[i] = eval(cb.charAt(i));
			   if (i%2)
				 b+=codes[i];
			   else
				 a+=codes[i];
		   }
			reste = (a+(b*3))%10;
			codes[12] = 10-(reste==0?10:reste);
			//alert(codes[12]);
			if(codes[12] == recup13){
				var bits = getBits(codes);
				bit = bits.split("");
				el = document.createElement("div");
				el.innerHTML= cb.charAt(0);
				el.className = "nombre1";
				divEAN.appendChild(el);
				for (var i=0;i<bit.length;i++) {
				   el = document.createElement("div");
				   longue =( i==0||i==2||i==46||i==48||i==92||i==94);
				   el.className = (longue?'l':'n')+bit[i];
				   divEAN.appendChild(el);
					if (i==3||i==50) {
					 el2 = document.createElement("div");
					 el2.innerHTML=(i==3)?cb.substr(1,6):cb.substr(7,6)+codes[12];
					 el2.className = "nombre";
					 el2.style.left = el.offsetLeft+"px";
					 el2.style.top = el.offsetHeight+"px";
					 divEAN.appendChild(el2);
				   }
				}
				unique(codeBarre,Value,codeBarrebox,table,champ);
			}
			else{
				jAlert("EAN13 incorrecte !");
				document.getElementById(codeBarre).value = "";
				return false;
			}
	   }
	   else{
		   divEAN = document.getElementById("EAN13CODE");
		   divEAN.innerHTML="";
		   codes = new Array();
		   for (var i=a=b=0;i<12;i++) {
			   codes[i] = eval(cb.charAt(i));
			   if (i%2)
				 b+=codes[i];
			   else
				 a+=codes[i];
		   }
			reste = (a+(b*3))%10;
			codes[12] = 10-(reste==0?10:reste);
			var bits = getBits(codes);
			bit = bits.split("");
			el = document.createElement("div");
			el.innerHTML= cb.charAt(0);
			el.className = "nombre1";
			divEAN.appendChild(el);
			for (var i=0;i<bit.length;i++) {
			   el = document.createElement("div");
			   longue =( i==0||i==2||i==46||i==48||i==92||i==94);
			   el.className = (longue?'l':'n')+bit[i];
			   divEAN.appendChild(el);
				if (i==3||i==50) {
				 el2 = document.createElement("div");
				 el2.innerHTML=(i==3)?cb.substr(1,6):cb.substr(7,6)+codes[12];
				 el2.className = "nombre";
				 el2.style.left = el.offsetLeft+"px";
				 el2.style.top = el.offsetHeight+"px";
				 divEAN.appendChild(el2);
			   }
			}
			document.getElementById(codeBarre).value = document.getElementById(codeBarre).value+codes[12];
			unique(codeBarre,document.getElementById(codeBarre).value,codeBarrebox,table,champ);
		}
   }
}

// Script du Code Barre : Calcul des chiffres
function getBits(codes) {
	var bitsCode = new Array(10);
	bitsCode[0] = new Array('0001101','0100111','1110010','000000');
	bitsCode[1] = new Array('0011001','0110011','1100110','001011');
	bitsCode[2] = new Array('0010011','0011011','1101100','001101');
	bitsCode[3] = new Array('0111101','0100001','1000010','001110');
	bitsCode[4] = new Array('0100011','0011101','1011100','010011');
	bitsCode[5] = new Array('0110001','0111001','1001110','011001');
	bitsCode[6] = new Array('0101111','0000101','1010000','011100');
	bitsCode[7] = new Array('0111011','0010001','1000100','010101');
	bitsCode[8] = new Array('0110111','0001001','1001000','010110');
	bitsCode[9] = new Array('0001011','0010111','1110100','011010');
   var bits = "101";
   var cle = bitsCode[codes[0]][3].split("");
   for (var i=1;i<7;i++)
      bits += bitsCode[codes[i]][cle[i-1]];
   bits += "01010";
   for (var i=7;i<13;i++)
      bits += bitsCode[codes[i]][2];
   bits += "101";
   return (bits);
}

//Arrondir un nombre à deux chiffres après la virgule
function arrondir(resultat) {
	//on remplace la virgule par un . pour le calcul
	var nombre = new String(resultat);
	var nombre2 = new String(nombre.replace(/,/,"."));
	//alert(nombre2);
	if(nombre2 != ""){
		var result = new String((Math.round(nombre2*100))/100);
	}else {
		var result = "";
		//alert(nombre2);
	}
	 
	//alert(result);
	// on remplace le . par une virgule pour l'affichage
	//var nombre3 = (result.replace(/"."/,","));
	//alert(nombre3);
    return result;
}

function MyRound(Valeur, Decimal,ValeurDefault) {
		var recup = document.getElementById(Valeur).value;
		recup = recup.replace(".",",");
		if (recup == 0 || recup == ""){
			//document.getElementById(Valeur).value = ValeurDefault+",00";
			
			document.getElementById(Valeur).value = "0";
			//jAlert("La valeur ne peut pas être vide ou à zéro."); 
			//document.getElementById(Valeur).value = ValeurDefault;
			//document.getElementById(Valeur).focus();
		}
		else { 
			var PosV = recup.indexOf(","); 
			if(PosV != -1){
				var Arrondi = recup.substr(0,PosV+1+Decimal); 
				document.getElementById(Valeur).value = Arrondi;
			}
			else{
				document.getElementById(Valeur).value = recup+",00";
			}
		} 
} 

function MyRoundLimited(Valeur, Decimal,ValeurDefault) {
	var recup = document.getElementById(Valeur).value;
	if (recup == 0 || recup == ""){
		document.getElementById(Valeur).value = format(ValeurDefault,2,'.');
		document.getElementById(Valeur).focus();
	}
	else { 
		if(recup > ValeurDefault){
			recup = recup.replace(".",",");
			var PosV = recup.indexOf(","); 
			if(PosV != -1){
				var Arrondi = recup.substr(0,PosV+1+Decimal); 
				document.getElementById(Valeur).value = Arrondi;
			}
			else{
				if(Decimal > 0)
					document.getElementById(Valeur).value = recup+",00";
			}
		}else{
			document.getElementById(Valeur).value = format(ValeurDefault,Decimal,'.');
		}
	} 
} 

function CalculLigne(Qte,Coef,Price,Discount,Total,PDiscount,CDiscount,PriceBuy,type){
	ValQte = document.getElementById(Qte).value;
	ValQte = ValQte.replace(".","");
	ValQte = ValQte.replace(",",".");
	ValPriceBuy = document.getElementById(PriceBuy).value;
	ValPriceBuy = ValPriceBuy.replace(',','.');
	ValPriceBuy = ArondirSuperieur(ValPriceBuy);
	if(type == '1'){
		ValCoef = document.getElementById(Coef).value;
		ValCoef = ValCoef.replace(",",".");
		PriceUnit = ValPriceBuy * ValCoef;
		PriceUnit = ArondirSuperieur(PriceUnit);
		PriceUnit = PriceUnit.toFixed(2);
	}
	else{
		PriceUnit = document.getElementById(Price).value;
		PriceUnit = PriceUnit.replace('.','');
		PriceUnit = PriceUnit.replace(',','.');
		PriceUnit = parseFloat(PriceUnit);
		ValCoef = PriceUnit/ValPriceBuy;
		ValCoef = ArondirSuperieur(ValCoef);
		ValCoef = ValCoef.toFixed(2);
	}
	//ValPrice = document.getElementById(Price).value;
	//ValPrice = ValPrice.replace(",",".");
	
	ValDiscount = document.getElementById(Discount).value;
	ValDiscount = ValDiscount.replace(",",".");
	if(ValDiscount != 0) ValDiscount = ValDiscount/100;
	var resultat = 1-ValDiscount;
	var PriceDiscount = PriceUnit * resultat;
	resultat = ValCoef * (PriceUnit * resultat);
	var CoeffDiscount = resultat / PriceUnit;
	resultat = PriceDiscount * ValQte;
	resultat = ArondirSuperieur(resultat);
	document.getElementById(Total).value = format(resultat,2,'.');
	//alert(type);
	if(type == '1'){
		PriceUnit = ArondirSuperieur(PriceUnit);
		if(isNaN(PriceUnit) == true) PriceUnit = 0;
		document.getElementById(Price).value = format(PriceUnit,2,'.');
	}
	else{
		PriceUnit = ArondirSuperieur(PriceUnit);
		if(isNaN(PriceUnit) == true) PriceUnit = 0;
		document.getElementById(Price).value = format(PriceUnit,2,'.');
		if(isNaN(ValCoef) == true) ValCoef = 1;
		if(format(ValCoef,2,'.') == "Infinity") ValCoef = 1;
		document.getElementById(Coef).value = format(ValCoef,2,'.');
	}
	PriceDiscount = ArondirSuperieur(PriceDiscount);
	if(isNaN(PriceDiscount) == true) PriceDiscount = 0;
	document.getElementById(PDiscount).value = format(PriceDiscount,2,'.');
	CoeffDiscount = ArondirSuperieur(CoeffDiscount);
	if(isNaN(CoeffDiscount) == true) CoeffDiscount = 0;
	if(format(CoeffDiscount,2,'.') == "Infinity") CoeffDiscount = 1;
	document.getElementById(CDiscount).value = format(CoeffDiscount,2,'.');
}

function CalculQtySellingPriceDiscount(Quantite,PrixUnitaire,Pourcentage,PrixUnitaireRemise,TotalLigne){
	
	var Qte = document.getElementById(Quantite).value;
	Qte = parseFloat(Qte.replace(",","."));
	
	var PU = document.getElementById(PrixUnitaire).value;
	PU = parseFloat(PU.replace(",","."));
	
	var Percent = document.getElementById(Pourcentage).value;
	Percent = parseFloat(Percent.replace(",","."));
	
	if(Percent != 0) Percent = Percent/100;
	Percent = 1-Percent;
	
	var PUDiscount = PU * Percent;
	var Total = PUDiscount * Qte;
	
	PUDiscount = PUDiscount.toFixed(2);
	//PUDiscount = PUDiscount.replace(".",",");
	
	Total = Total.toFixed(2);
	//Total = Total.replace(".",",");
	
	document.getElementById(PrixUnitaireRemise).value = format(PUDiscount,2,'.');
	document.getElementById(TotalLigne).value = format(Total,2,'.');
}

function SelAcompte(selectoption,input,btn){
	if(document.getElementById('type_demande_devis').value != 1){
		switch(document.getElementById(selectoption).options[document.getElementById(selectoption).selectedIndex].text){
			case 'Forcé à non':
				$('#'+input).removeClass(); 
				$('#'+input).addClass('toolTip idleField readonly'); 
				document.getElementById(input).setAttribute('type', 'hidden'); 
				document.getElementById("lbl"+input).innerHTML="0";
				document.getElementById(input).value = 0;
				document.getElementById('montant_acompte').value = '';
				document.getElementById('montant_acompte').setAttribute('type', 'hidden');
				document.getElementById("lblmontant"+input).innerHTML="0";
				document.getElementById(btn).style.display = "none";
				break;
				
			case 'Forcé à oui':
				$('#'+input).removeClass(); 
				$('#'+input).addClass('toolTip idleField'); 
				document.getElementById(input).setAttribute('type', 'text'); 
				document.getElementById(input).removeAttribute('readonly'); 
				document.getElementById("lbl"+input).innerHTML="";
				document.getElementById(input).value = '0';
				document.getElementById('montant_acompte').setAttribute('type', 'hidden');
				document.getElementById("lblmontant"+input).innerHTML="0";
				document.getElementById('montant_acompte').value = '';
				document.getElementById(btn).style.display = "";
				break;
			
			default:
				$('#'+input).removeClass(); 
				$('#'+input).addClass('toolTip idleField readonly'); 
				document.getElementById(input).setAttribute('type', 'hidden'); 
				document.getElementById('montant_acompte').setAttribute('type', 'hidden');
				document.getElementById("lbl"+input).innerHTML="30";			
				document.getElementById(input).value = 30;
				document.getElementById(btn).style.display = "none";
				document.getElementById('montant_acompte').value = '';
				break;
		}
	}
}



//Test des champs obligatoire
function is_empty(chaine,chaine_champ_dynamique){
var error = false;
var reg = new RegExp("[;]+", "g");
var tableauChaine = chaine.split(reg);
if(chaine_champ_dynamique != ""){
	var tableauChaineChampDynamique = chaine_champ_dynamique.split(reg);
}
	for (var i=0; i<tableauChaine.length; i++) {
		//alert(tableauChaine[i]);
			//alert(document.getElementById(tableauChaine[i]));
			if(document.getElementById(tableauChaine[i]) != null){
				var isvide = document.getElementById(tableauChaine[i]).value;
				if(isvide == ""){
					//alert("je suis vide");
					var champs = tableauChaine[i];
					//$("label[for="+champs+"]").addClass("required"); 
					//$("label[for="+Id+"_"+i+"]").text("Fournisseur par défaut *");
					$("#"+champs).removeClass("idleField");
					$("#"+champs).addClass("required");
					$("#error_"+champs).addClass("required_text");
					$("#error_"+champs).text("Obligatoire.");
					error = true;
				}
				else{
					//alert("je suis pas vide");
				}
			}
	}
	
	if(chaine_champ_dynamique != ""){
		if(document.getElementById(tableauChaineChampDynamique[0]) == null){
			parcourir = 0;
		}
		else{
			var parcourir = parseInt(document.getElementById(tableauChaineChampDynamique[0]).value);
			parcourir = parcourir + 1;
		}
		for (var i=1; i<tableauChaineChampDynamique.length; i++) {
			//alert(tableauChaineChampDynamique[i] != "separate");
			if((tableauChaineChampDynamique[i] !== "separate") != true){
				//alert("separate existe");
				parcourir = parseInt(document.getElementById(tableauChaineChampDynamique[i]).value);	
				parcourir = parcourir + 1;
				i = i+1;
			}
			
			var champ_dynamique = tableauChaineChampDynamique[i];
			//alert(parcourir);
			for (var y=0; y<parcourir; y++){
				if(document.getElementById(champ_dynamique+"_"+y) != null){
				var isvide = document.getElementById(champ_dynamique+"_"+y).value;
					//alert(champ_dynamique+"_"+y);
					if(isvide == ""){
						var champs = tableauChaineChampDynamique[i]+"_"+y;
						//alert(champs);
						$("#"+champs).removeClass("idleField");
						$("#"+champs).addClass("required");
						$("#error_"+champs).addClass("required_text");
						$("#error_"+champs).text("Obligatoire.");
						error = true;
					}
					else{
						//alert("je suis pas vide");
					}
				}	
			}
		}
	}
	if(error != true){
		formObj.submit(); 
	}
	else{
		$('.ActionButton').show();
		jAlert("Un ou plusieurs champs obligatoires n'ont pas été remplis!","Erreur");
	}
}
	
function checkedOrNotCheckbox(checkbox){
	for(i=1;i<document.getElementById('formulaire').length;i++){
		if(document.getElementById('formulaire').elements[i].type=="checkbox"){
			if(document.getElementById(checkbox).checked == true){
				document.getElementById('formulaire').elements[i].checked=true;
			} else{
				document.getElementById('formulaire').elements[i].checked=false;
			}
		}
	}	
}

function checkedOrNotCheckbox2(checkbox,id){
	for(i=0;i<document.getElementById('formulaire').length;i++){
		var name = document.getElementById('formulaire').elements[i].name;
		if(name != undefined){
			var tab = name.split('_');
			if(document.getElementById('formulaire').elements[i].name == id+tab[2]){
				if(document.getElementById(checkbox).checked == true){
					document.getElementById('formulaire').elements[i].checked=true;
				}
				else{
					document.getElementById('formulaire').elements[i].checked=false;
				}
			}
		}
	}
}

function generer_password(champ_cible,chaine,longueur) {
    var ok = chaine;
    var pass = '';
    for(i=0;i<longueur;i++){
        var wpos = Math.round(Math.random()*ok.length);
        pass+=ok.substring(wpos,wpos+1);
    }
    document.getElementById(champ_cible).value = pass;
}

function SplitEquipmentsAndFees(tableau){
	var max = document.getElementById(tableau).rows.length;
	var TotalEquipment = 0;
	var TotalFees = 0;
	for (var i=1; i<max; i++) {
		var name = document.getElementById(tableau).rows[i].id;
		var tab = document.getElementById(tableau).rows[i].id.split('_');
		//alert(tab);
		//alert(document.getElementById(tableau).rows[i].id);
		switch(document.getElementById(tableau).rows[i].id){
		case 'line_'+tab[1] :
			if(document.getElementById('Auvibel_'+tab[1]) != null){
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TotalFees = parseFloat(TotalFees)+ TtotalLigne;
			}else if(document.getElementById('Recupel_'+tab[1]) != null){
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TotalFees = parseFloat(TotalFees)+ TtotalLigne;
			}else if(document.getElementById('Reprobel_'+tab[1]) != null){
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TotalFees = parseFloat(TotalFees)+ TtotalLigne;
			}else if(document.getElementById('Bebat_'+tab[1]) != null){
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TotalFees = parseFloat(TotalFees)+ TtotalLigne;
			}else{
				TtotalLigne = document.getElementById('Total_ligne_'+tab[1]).value;
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace('.','');
				//alert(TtotalLigne);
				TtotalLigne = TtotalLigne.replace(',','.');
				//alert(TtotalLigne);
				TtotalLigne = parseFloat(TtotalLigne);
				//alert(TtotalLigne);
				TotalEquipment = parseFloat(TotalEquipment)+ TtotalLigne;
			}
			break;
		}
	}
	//alert(TheTotal);
	TotalFees = ArondirSuperieur(TotalFees);
	TotalEquipment = ArondirSuperieur(TotalEquipment);
	
	document.getElementById('AmountFees').innerHTML = format(TotalFees,2,'.');
	document.getElementById('AmountEquipment').innerHTML = format(TotalEquipment,2,'.');
}


/*
 * validation formulaire véhicule côté client
 */
function checkMatriculation(value) {
	value=value.toUpperCase();
	var reg = new RegExp("^[a-zA-Z0-9-]{0,9}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkChassisNumber(value) {
	value=value.toUpperCase();
	var reg = new RegExp("^[a-zA-Z0-9]*$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkModel(value) {
	var reg = new RegExp("^[a-zA-Z0-9]*$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkCurrentKilometers(value) {
	var reg = new RegExp("^[0-9.]{0,7}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkFiscalHorsepower(value) {
	var reg = new RegExp("^[0-9]{0,2}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkKilowatts(value) {
	var reg = new RegExp("^[0-9]{0,3}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkCO2Emission(value) {
	var reg = new RegExp("^[0-9]{0,3}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkSerialNumber(value) {
		var reg = new RegExp("^[a-zA-Z0-9-+# ]{0,50}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function checkEmail(value) {
		var reg = new RegExp("^[a-zA-Z0-9-._@]{0,100}$");
	if (reg.test(value)==false) {
		value=value.replace(value, "");
	}
	return value;
}

function AddRowInventory(){
	var nbr_lignes = (document.getElementById('tableLineBusinessRecords').rows.length);
	//alert(nbr_lignes);
	var newRow = document.getElementById('tableLineBusinessRecords').insertRow(nbr_lignes);
	var idline = nbr_lignes-1;
	newRow.id = "line_"+idline;
	newRow.style.backgroundColor = "#F9361A";
	document.getElementById("total_ligne").value = nbr_lignes;
	MyGo(document.getElementById('family').value+';'+idline+';',"line_"+idline,'add_row_inventory');
	
}

function RegenerateFixedHeader(table_id,width,height){
		$('#'+table_id).fixedHeaderTable('hide');
		$('#'+table_id).fixedHeaderTable('destroy');
		$('#'+table_id).fixedHeaderTable({ footer: false, cloneHeadToFoot: false, autoShow: true, width: width, height: height });
}

function CountNbQuantity(){
	var nbr_lignes = (document.getElementById('tableLineBusinessRecords').rows.length);
	var TotalQty = 0;
	var Qtytmp = 0;
	for(i=1;i<nbr_lignes;i++){
		var name = document.getElementById('tableLineBusinessRecords').rows[i].id;
		var tab = document.getElementById('tableLineBusinessRecords').rows[i].id.split('_');
		//alert(document.getElementById('quantite_commandee_'+tab[1]));
		if(document.getElementById('quantite_commandee_'+tab[1]) != undefined){
			Qtytmp = document.getElementById('Quantite_'+tab[1]).value;
			Qtytmp = Qtytmp.replace(".","");
			Qtytmp = parseFloat(Qtytmp.replace(",","."));
			TotalQty = TotalQty + Qtytmp;
			
		}
	}	
	
	jAlert('Nombre d\'articles réceptionnés : '+TotalQty);
}

function force_check_if_value(elementid2,elementid,value){
	var tmp = document.getElementById(elementid2).value;
	tmp = tmp.replace(".","");
	tmp = parseFloat(tmp.replace(",","."));
	if(tmp == value){
		document.getElementById(elementid).checked = true;
		document.getElementById(elementid).disabled = true;
	}else{
		document.getElementById(elementid).disabled = false;
	}
}

function FadeInOut(element){
	x = document.getElementById(element);
	if(x.offsetWidth == 0){
		$('#'+element).fadeIn('slow');
		MyGo('1;'+element,element+'_indicator','change_indicator');
		//completer_element(element+'_indicator','<img src="./css/images/keep.png" onclick="FadeInOut('+element+');" />');
	}else{
		$('#'+element).fadeOut('slow');
		MyGo('2;'+element,element+'_indicator','change_indicator');
		//completer_element(element+'_indicator','<img src="./css/images/drop.png" onclick="FadeInOut('+element+');" />');
	}
}