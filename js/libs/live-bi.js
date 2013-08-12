/*
  Live.js - One script closer to Designing in the Browser
  Written for Handcraft.com by Martin Kool (@mrtnkl).

  Version 4.
  Recent change: Made stylesheet and mimetype checks case insensitive.

  http://livejs.com
  http://livejs.com/license (MIT)
  @livejs

  Include live.js#css to monitor css changes only.
  Include live.js#js to monitor js changes only.
  Include live.js#html to monitor html changes only.
  Mix and match to monitor a preferred combination such as live.js#html,css

  By default, just include live.js to monitor all css, js and html changes.

  Live.js can also be loaded as a bookmarklet. It is best to only use it for CSS then,
  as a page reload due to a change in html or css would not re-include the bookmarklet.
  To monitor CSS and be notified that it has loaded, include it as: live.js#css,notify
*/(function(){var e={Etag:1,"Last-Modified":1,"Content-Length":1,"Content-Type":1},t={},n={},r={},i={},s=1e3,o=!1,u={html:1,css:1,js:1},a={heartbeat:function(){if(document.body){o||a.loadresources();a.checkForChanges()}setTimeout(a.heartbeat,s)},loadresources:function(){function e(e){var t=document.location,n=new RegExp("^\\.|^/(?!/)|^[\\w]((?!://).)*$|"+t.protocol+"//"+t.host);return e.match(n)}var n=document.getElementsByTagName("script"),i=document.getElementsByTagName("link"),s=[];for(var f=0;f<n.length;f++){var l=n[f],c=l.getAttribute("src");c&&e(c)&&s.push(c);if(c&&c.match(/\blive.js#/)){for(var h in u)u[h]=c.match("[#,|]"+h)!=null;c.match("notify")&&alert("Live.js is loaded.")}}u.js||(s=[]);u.html&&s.push(document.location.href);for(var f=0;f<i.length&&u.css;f++){var p=i[f],d=p.getAttribute("rel"),v=p.getAttribute("href",2);if(v&&d&&d.match(new RegExp("stylesheet","i"))&&e(v)){s.push(v);r[v]=p}}for(var f=0;f<s.length;f++){var m=s[f];a.getHead(m,function(e,n){t[e]=n})}var g=document.getElementsByTagName("head")[0],y=document.createElement("style"),b="transition: all .3s ease-out;";css=[".livejs-loading * { ",b," -webkit-",b,"-moz-",b,"-o-",b,"}"].join("");y.setAttribute("type","text/css");g.appendChild(y);y.styleSheet?y.styleSheet.cssText=css:y.appendChild(document.createTextNode(css));o=!0},checkForChanges:function(){for(var e in t){if(n[e])continue;a.getHead(e,function(e,n){var r=t[e],i=!1;t[e]=n;for(var s in r){var o=r[s],u=n[s],f=n["Content-Type"];switch(s.toLowerCase()){case"etag":if(!u)break;default:i=o!=u}if(i){a.refreshResource(e,f);break}}})}},refreshResource:function(e,t){switch(t.toLowerCase()){case"text/css":var n=r[e],s=document.body.parentNode,o=n.parentNode,u=n.nextSibling,f=document.createElement("link");s.className=s.className.replace(/\s*livejs\-loading/gi,"")+" livejs-loading";f.setAttribute("type","text/css");f.setAttribute("rel","stylesheet");f.setAttribute("href",e+"?now="+new Date*1);u?o.insertBefore(f,u):o.appendChild(f);r[e]=f;i[e]=n;a.removeoldLinkElements();break;case"text/html":if(e!=document.location.href)return;case"text/javascript":case"application/javascript":case"application/x-javascript":document.location.reload()}},removeoldLinkElements:function(){var e=0;for(var t in i){try{var n=r[t],s=i[t],o=document.body.parentNode,u=n.sheet||n.styleSheet,f=u.rules||u.cssRules;if(f.length>=0){s.parentNode.removeChild(s);delete i[t];setTimeout(function(){o.className=o.className.replace(/\s*livejs\-loading/gi,"")},100)}}catch(l){e++}e&&setTimeout(a.removeoldLinkElements,50)}},getHead:function(t,r){n[t]=!0;var i=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XmlHttp");i.open("HEAD",t,!0);i.onreadystatechange=function(){delete n[t];if(i.readyState==4&&i.status!=304){i.getAllResponseHeaders();var s={};for(var o in e){var u=i.getResponseHeader(o);o.toLowerCase()=="etag"&&u&&(u=u.replace(/^W\//,""));o.toLowerCase()=="content-type"&&u&&(u=u.replace(/^(.*?);.*?$/i,"$1"));s[o]=u}r(t,s)}};i.send()}};if(document.location.protocol!="file:"){window.liveJsLoaded||a.heartbeat();window.liveJsLoaded=!0}else window.console&&console.log("Live.js doesn't support the file protocol. It needs http.")})();