/*
 Ajax Tabs v1.0
 Copyright 2006 HavocStudios.com
 
 http://web.archive.org/web/20060415145746/www.havocstudios.com/articles/ajax/ajax_tabs/
	
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:
 
 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
			
		function CloseTab(tabId)
		{
			//alert(tabId);
			var lastTabId = "";
			var somethingHasFocus = false;
			
			var closeTab = true;
			var closeJS = "if (window.tabClose"+tabId+") { closeTab = tabClose"+tabId+"(); }";
			eval(closeJS);
			if (!closeTab) // user cancelled close tab
			{
				//alert(closeTab);
				return;
			}
			
			///////////////////////////////////////////
			var valueonclick = String(document.getElementById("add").onclick);
			/////////////////////////////////////////

			/* Remove all the event functions for this tab */
			eval("if (window.tabOpen"+tabId+") { tabOpen"+tabId+" = null; }");
			eval("if (window.tabFocus"+tabId+") { tabFocus"+tabId+" = null; }");
			eval("if (window.tabBlur"+tabId+") { tabBlur"+tabId+" = null; }");
			eval("if (window.tabClose"+tabId+") { tabClose"+tabId+" = null; }");
			
			/* Remove the tab */
			var tabList = document.getElementById('tabList');
			if(tabList.childNodes.length == 2) return alert("Impossible de supprimer le dernier onglet");
			for (i=0; i < tabList.childNodes.length; i++)
			{
				if (tabList.childNodes[i] && tabList.childNodes[i].tagName == "LI" )
				{
					if (tabList.childNodes[i].getAttribute('id') == tabId)
					{
						tabList.removeChild(tabList.childNodes[i]);
					}
				}
			}

			/* Remove the panel */
			var panelList = document.getElementById('tabPanels');
			for (i=0; i < panelList.childNodes.length; i++)
			{
				if (panelList.childNodes[i] && panelList.childNodes[i].tagName == "DIV" )
				{
					if (panelList.childNodes[i].getAttribute('id') == "panel_" + tabId)
					{
						panelList.removeChild(panelList.childNodes[i]);
					}
				}
			}
		
			// If we closed the tab that had focus, focus on another tab.
			for (i=0; i < tabList.childNodes.length; i++)
			{
				if (tabList.childNodes[i] && tabList.childNodes[i].tagName == "LI" )
				{
					lastTabId = tabList.childNodes[i].getAttribute('id');
					if (tabList.childNodes[i].getAttribute('tabColor') + "current" == tabList.childNodes[i].className)
					{
						somethingHasFocus = true;
					}
				}
			}
			
			var tabList = document.getElementById('tabList');
			for (i=0; i < tabList.childNodes.length; i++)
			{
				if(tabList.childNodes[i] && tabList.childNodes[i].tagName == "LI" ){
					number = tabList.childNodes[i].id;
				}
			}
			//alert(number);
			//alert(valueonclick);
			MoveAdd(number,valueonclick);
			
			if (!somethingHasFocus)
			{
				FocusTab(lastTabId);
			}
		}
				
		function CreateNewTab(tabId, tabLabel, tabURL, tabIsCloseable, tabColor)
		{
			// create the tab
			var newLabel = document.createElement('span');
			newLabel.setAttribute("id", "tabSpan" + tabId);
			newLabel.className = tabColor;
			newLabel.setAttribute("tabColor", tabColor);
			if (tabIsCloseable)
			{
				newLabel.innerHTML = "<div class=\"tabHandle\" id=\"tab"+tabId+"\">" + tabLabel + "</div> <img src=\"../CSS/images/x.png\" border=\"0\"  width=\"14\" height=\"14\" onclick=\"CloseTab('" + tabId + "');return false;\" />";
			}
			else
			{
				newLabel.innerHTML = "<div class=\"tabHandle\">" + tabLabel + "</div> <img src=\"../CSS/images/spacer.gif\" border=\"0\" width=\"14\" height=\"14\" />";
			}
			
			var newTab = document.createElement('li');
			newTab.className = tabColor;
			newTab.setAttribute("id", tabId);
			newTab.setAttribute("tabId", tabId);
			newTab.setAttribute("tabLabel", tabLabel);
			newTab.setAttribute("tabColor", tabColor);
			newTab.onclick = function () { FocusTab(tabId); }
			newTab.setAttribute("tabIsCloseable", "0");
			
			if (tabIsCloseable)
			{
				newTab.setAttribute("tabIsCloseable", "1");
			}
			newTab.setAttribute('isFocused','true');
			newTab.appendChild(newLabel);
			document.getElementById('tabList').appendChild(newTab);
			
			// create the panel
			var newPanel = document.createElement('div');
			newPanel.setAttribute('id','panel_' + tabId);
			newPanel.setAttribute("panelURL", tabURL);
			newPanel.setAttribute("tabColor", tabColor);
			newPanel.className = tabColor + "Panel";
			
			/* newPanel.style.display = "none"; */
			document.getElementById('tabPanels').appendChild(newPanel);

			FocusTab(tabId); // this will get run before the tab has any tabFocus() function, so tabFocus() won't get run. (make your tabOpen() run something if you need it to)
			RefreshTab(tabId); // load the page up

		}
		
		function GetFocusedTabId()
		{
			var tabList = document.getElementById('tabList');
			for (i=0; i < tabList.childNodes.length; i++)
			{
				if (tabList.childNodes[i] && tabList.childNodes[i].tagName == "LI" )
				{
					if (tabList.childNodes[i].getAttribute('tabColor') + "current" == tabList.childNodes[i].className)
					{
						return tabList.childNodes[i].getAttribute('id');
					}
				}
			}
		}
		
		function FocusTab(tabId)
		{
			var currentFocusedTabId = GetFocusedTabId();
			
			
			var tabList = document.getElementById("tabList");
			for (j=0; j < tabList.childNodes.length; j++)
			{
				if (tabList.childNodes[j] && tabList.childNodes[j].tagName == "LI" )
				{
					var className = tabList.childNodes[j].getAttribute("tabColor");
					var currentTabId = tabList.childNodes[j].getAttribute("tabId");
					if (currentTabId == tabId)
					{
						tabList.childNodes[j].className = className + "current";
						document.getElementById("tabSpan" + tabList.childNodes[j].getAttribute("id")).className = className + "current";
						document.getElementById("panel_" + currentTabId).style.display = "block";
					}
					else
					{
						tabList.childNodes[j].className = className;
						document.getElementById("tabSpan" + tabList.childNodes[j].getAttribute("id")).className = className;
						document.getElementById("panel_" + currentTabId).style.display = "none";
					}
				}
			}
			
			var valueonclick = String(document.getElementById("add").onclick);
			MoveAdd(tabId,valueonclick);
			
			if (tabId != currentFocusedTabId)
			{
				eval("if (window.tabBlur"+currentFocusedTabId+") { tabBlur"+currentFocusedTabId+"(); }");
				eval("if (window.tabFocus"+tabId+") { tabFocus"+tabId+"(); }");
			}
		}
		
		function RefreshTab(tabId)
		{
			/* document.getElementById("panel_" + tabId).innerHTML = "Hello, World.<br/>" + document.getElementById("panel_" + tabId).getAttribute("panelURL"); */
			
			var http = getXhr();
			var panel = document.getElementById('panel_' + tabId);
			var page = panel.getAttribute('panelURL');
			var url = page;
			var now = new Date();
			var openFuncExists = false;
			var timeoutId;
			
			// hack to get IE to refresh all the time by making each url unique by adding a timestamp onto it. (ie tries to cache everything)
			if (url.indexOf("?") > -1) // this url has get params somewhere
			{
				if (url.substr(url.length-1) == "&") // has a & at the end, no need to append another
				{
					url = url + "t=" + now.getTime();
				}
				else // no & on the end, append it
				{
					url = url + "&t=" + now.getTime();
				}
			}
			else // no params on this url. append a ?
			{
				url = url + "?t=" + now.getTime();
			}
			// end IE hack				

			http.open("GET", url, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4) {
					if (http.status == 200)
					{
						window.clearTimeout(timeoutId);
						var htmlDoc = http.responseText;
						
						document.getElementById('panel_' + tabId).innerHTML = htmlDoc;
						
						var body = document.getElementsByTagName("body")[0]; // on spécifie ou se trouve le javascript ici c'est dans <body></body>
						var scr;
						var scrajx = document.getElementById('panel_' + tabId).getElementsByTagName('script'); // on spécifie les balises où est contenu le javascript <script></script>
						for( var i in scrajx ) // boucle qui parcourt toutes les balises script et execute leur contenu
						{	scr = document.createElement("script");
							scr.type = "text/javascript";
							scr.text = scrajx[i].text;
							body.appendChild(scr);			
						}
						
						if (document.getElementById('script_' + tabId))
						{
							/* Setup the event functions for this tab */
							var script = document.getElementById('script_' + tabId).innerHTML;
							eval(script);
							eval("if (window.tabOpen"+tabId+") { tabOpen"+tabId+"(); }");
						}
					}
				}
			}
			document.getElementById('panel_' + tabId).innerHTML = "<div class='loadingBox'><b>Chargement...</b> <img src='../CSS/images/indicator.gif' /></div>";
			
			http.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			http.send(null);
			
			timeoutId = window.setTimeout(
				function() {
					switch (http.readyState) {
						case 1:
						case 2:
						case 3:
							http.abort();
							document.getElementById('panel_' + tabId).innerHTML = "<h2>Error Loading Data</h2><a href=\"javascript:void(0)\" onclick=\"RefreshTab('" + tabId + "');\">Retry</a>";
							alert("Oops. There was an error retreiving data from the server. Please try again in a few moments.");
							break;
						default:
							break;
					}
				},
				20000 // twenty seconds
			);

		}
		
		function TabExists(tabId)
		{
			var exists = false;
			var tabList = document.getElementById("tabList");
			//alert(tabList);
			for (j=0; j < tabList.childNodes.length; j++)
			{
				if (tabList.childNodes[j] && tabList.childNodes[j].tagName == "LI" )
				{
					var currentTabId = tabList.childNodes[j].getAttribute("tabId");
					if (currentTabId == tabId)
					{
						exists = true;
					}
				}
			}
			return exists;
		}
		
		function OpenTab(tabId, tabLabel, tabURL, tabIsCloseable, tabColor)
		{
			if (TabExists(tabId))
			{
				FocusTab(tabId);
			}
			else
			{
				CreateNewTab(tabId, tabLabel, tabURL, tabIsCloseable, tabColor);
			}
		}
		
		function SetTabURL(tabId, url)
		{
			document.getElementById('panel_' + tabId).setAttribute('panelURL', url);
			RefreshTab(tabId);
		}
		
		function MoveAdd(number,valueonclick){
			number = number.replace("tab_page","");
			//alert(valueonclick)
			if(valueonclick != null && document.getElementById("tabtab_page"+number) != undefined){
				Var = valueonclick.replace(/\"/g,"\\\'");
				Var = Var.replace("function onclick(event) {","");
				Var = Var.replace("}","");
				valueonclick = Var;
				//alert(Var);
				if(document.getElementById("add") != undefined){
					var element = document.getElementById("add");
					element.parentNode.removeChild(element);
				}
				//alert("tabtab_page"+number)
				document.getElementById("tabtab_page"+number).innerHTML = "<a id=\"add\" href=\"javascript:void(0)\" onclick=\""+valueonclick+"\"><img src=\"./CSS/images/plus.png\"></a>"+document.getElementById("tabtab_page"+number).innerHTML
			}
		}
