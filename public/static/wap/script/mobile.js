function g(a) {
	return document.getElementById(a)
}
var getElementsByClassName = function(f, g, h) {
		if (document.getElementsByClassName) {
			getElementsByClassName = function(a, b, c) {
				c = c || document;
				var d = c.getElementsByClassName(a),
					nodeName = (b) ? new RegExp("\\b" + b + "\\b", "i") : null,
					returnElements = [],
					current;
				for (var i = 0, il = d.length; i < il; i += 1) {
					current = d[i];
					if (!nodeName || nodeName.test(current.nodeName)) {
						returnElements.push(current)
					}
				}
				return returnElements
			}
		} else if (document.evaluate) {
			getElementsByClassName = function(a, b, c) {
				b = b || "*";
				c = c || document;
				var d = a.split(" "),
					classesToCheck = "",
					xhtmlNamespace = "http://www.w3.org/1999/xhtml",
					namespaceResolver = (document.documentElement.namespaceURI === xhtmlNamespace) ? xhtmlNamespace : null,
					returnElements = [],
					elements, node;
				for (var j = 0, jl = d.length; j < jl; j += 1) {
					classesToCheck += "[contains(concat(' ', @class, ' '), ' " + d[j] + " ')]"
				}
				try {
					elements = document.evaluate(".//" + b + classesToCheck, c, namespaceResolver, 0, null)
				} catch (e) {
					elements = document.evaluate(".//" + b + classesToCheck, c, null, 0, null)
				}
				while ((node = elements.iterateNext())) {
					returnElements.push(node)
				}
				return returnElements
			}
		} else {
			getElementsByClassName = function(a, b, c) {
				b = b || "*";
				c = c || document;
				var d = a.split(" "),
					classesToCheck = [],
					elements = (b === "*" && c.all) ? c.all : c.getElementsByTagName(b),
					current, returnElements = [],
					match;
				for (var k = 0, kl = d.length; k < kl; k += 1) {
					classesToCheck.push(new RegExp("(^|\\s)" + d[k] + "(\\s|$)"))
				}
				for (var l = 0, ll = elements.length; l < ll; l += 1) {
					current = elements[l];
					match = false;
					for (var m = 0, ml = classesToCheck.length; m < ml; m += 1) {
						match = classesToCheck[m].test(current.className);
						if (!match) {
							break
						}
					}
					if (match) {
						returnElements.push(current)
					}
				}
				return returnElements
			}
		}
		return getElementsByClassName(f, g, h)
	};


function checkSearchForm() {
	if (g("searchTextbox").value == "") {
		alert("木有字囧么搜索啊！？");
		return false
	}
	return true
}
function goTop() {
	window.scrollTo(0, 1)
}
function forceNormalTheme() {
	setCookie("force_normal_theme", "true", 96);
	window.location.reload()
}
function showSubmenu(a) {
	if (g(a) == null) {
		return false
	}
	if (null != g("submenu_bg_div")) {
		hideAllSubmenu();
		return false
	}
	hideAllSubmenu();
	createBgDiv();
	g(a).style.display = "block";
	if (a == "nav_search") {
		g("searchTextbox").focus()
	}
}
function createBgDiv() {
	var a = document.createElement("DIV");
	a.id = "submenu_bg_div";
	a.style.top = 0;
	a.style.left = 0;
	a.style.display = "block";
	a.style.zIndex = 997;
	a.style.background = '#000';
	a.style.visibility = 'visible';
	a.style.position = "absolute";
	a.style.height = document.body.clientHeight + "px";
	a.style.width = document.body.clientWidth + "px";
	a.style.opacity = 0.8;
	document.body.appendChild(a);
	a.onclick = hideAllSubmenu
}
function delBgDiv() {
	var a = g("submenu_bg_div");
	if (null != a) a.parentNode.removeChild(a)
}
function hideAllSubmenu() {
	if (null != g("searchTextbox")) g("searchTextbox").blur();
	delBgDiv();
	var a = document.getElementsByClassName("submenu");
	for (var i = 0; i < a.length; i++) {
		var a = document.getElementsByClassName("submenu");
		a[i].style.display = "none"
	}
}
function changeOrientation() {
	var a = g("submenu_bg_div");
	if (null != a) {
		a.style.width = document.body.clientWidth + "px";
		a.style.height = document.body.clientHeight + "px"
	}
}
if (/(iPhone|iPad|iPod)/i.test(navigator.userAgent)) {
	addEventListener("onorientationchange" in window ? "orientationchange" : "resize", changeOrientation, false)
} else {
	addEventListener("resize", changeOrientation, false)
}
