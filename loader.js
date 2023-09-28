"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};!function o(a,r,d){function l(i,t){if(!r[i]){if(!a[i]){var e="function"==typeof require&&require;if(!t&&e)return e(i,!0);if(s)return s(i,!0);throw new Error("Cannot find module '"+i+"'")}var n=r[i]={exports:{}};a[i][0].call(n.exports,function(t){var e=a[i][1][t];return l(e||t)},n,n.exports,o,a,r,d)}return r[i].exports}for(var s="function"==typeof require&&require,t=0;t<d.length;t++)l(d[t]);return l}({1:[function(require,module,exports){var adflex={getAdflexHost:function(){return window.adflex.host+"/"},debounce:function(n,o,a){var r;return function(){var t=this,e=arguments,i=a&&!r;clearTimeout(r),r=setTimeout(function(){r=null,a||n.apply(t,e)},o),i&&n.apply(t,e)}},throttle:function(i,n,o){var a,r,d,l=null,s=0;o||(o={});var p=function(){s=!1===o.leading?0:Date.now(),l=null,d=i.apply(a,r),l||(a=r=null)};return function(){var t=Date.now();s||!1!==o.leading||(s=t);var e=n-(t-s);return a=this,r=arguments,e<=0||n<e?(l&&(clearTimeout(l),l=null),s=t,d=i.apply(a,r),l||(a=r=null)):l||!1===o.trailing||(l=setTimeout(p,e)),d}},parseURL:function(t){var e=document.createElement("a");return e.href=t,e},stringShortener:function(t){return 30<t.length&&(t=t.slice(0,8)+"..."+t.slice(-8)),t},objToUrl:function(t,e){e=e||"";var i=[];for(var n in t)if(t.hasOwnProperty(n)){var o=encodeURIComponent(n),a=encodeURIComponent(t[n]);i.push(o+"="+a)}return e+i.join("&")},parseJson:function(t){try{return JSON.parse(t)}catch(t){return console.log("Adflex: error JSON parse"),null}},ajax:function(t){var e=t.method||"GET",i=t.data||"",n=t.url,o=t.callback||function(){},a=t.isJSON||!1,r=new XMLHttpRequest;r.onreadystatechange=function(){4===this.readyState&&200===this.status&&o(!0,a?adflex.parseJson(r.responseText):r.responseText),299<this.status&&4===this.readyState&&o(!1,r.statusText)},r.onerror=function(){o(!1,r.responseText)},"POST"===e?(r.open(e,n,!0),r.setRequestHeader("Content-type","application/x-www-form-urlencoded"),r.setRequestHeader("X-Requested-With","XMLHttpRequest"),r.send(adflex.objToUrl(i)||null)):(r.open(e,n+adflex.objToUrl(i,"?"),!0),r.setRequestHeader("X-Requested-With","XMLHttpRequest"),r.send())},isVisibleElement:function(t){var e,i=window.innerWidth,n=window.innerHeight;return(e="string"==typeof t?document.querySelector(t).getBoundingClientRect():t.getBoundingClientRect()).center_x=e.left+e.width/2,e.center_y=e.top+e.height/2,0<e.center_x&&e.center_x<i&&0<e.center_y&&e.center_y<n},runJs:function runJs(id){for(var div=document.getElementById(id).getElementsByTagName("script"),head=document.getElementsByTagName("head")[0],i=0;i<div.length;i++)if(div[i].src){var script=document.createElement("script");script.type="text/javascript",script.innerText=div[i].innerHTML,script.src=div[i].src,head.appendChild(script),head.removeChild(script)}else eval(div[i].innerHTML)},setCookie:function(t,e,i){var n=(i=i||{}).expires;if("number"==typeof n&&n){var o=new Date;o.setTime(o.getTime()+1e3*n),n=i.expires=o}n&&n.toUTCString&&(i.expires=n.toUTCString());var a=t+"="+(e=encodeURIComponent(e));for(var r in i){a+="; "+r;var d=i[r];!0!==d&&(a+="="+d)}document.cookie=a},getCookie:function(t){var e=document.cookie.match(new RegExp("(?:^|; )"+t.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g,"\\$1")+"=([^;]*)"));return e?decodeURIComponent(e[1]):void 0},config:{filename:"loader.js",unit_class:"adflexbox",dsa_class:"adflex-dsa",b_class:"adflex-b-box",a_class:"adflex-a-box",m_class:"adflex-m-box",debug:-1!==location.href.indexOf("adflex_debug")?1:0}};adflex.config.host=adflex.getAdflexHost(),adflex.config.provider_url=adflex.config.host+"provider",adflex.config.view_url=adflex.config.host+"view",adflex.config.click_url=adflex.config.host+"click",adflex.config.view_third_party_url=adflex.config.host+"view_third_party",adflex.config.click_third_party_url=adflex.config.host+"click_third_party",module.exports=adflex},{}],2:[function(t,e,i){var n=t("domready"),o=t("./render"),a=t("./stat");n(function(){o(function(t){a(t)})})},{"./render":3,"./stat":5,domready:6}],3:[function(a,t,e){var p=a("./adflex");function f(t){return t?'<a href="'+p.config.host+'" target="_blank" class="adflex-tip">ad</a>':""}function r(t,e,i){if(e.data){var n=p.config.click_url+"/?"+e.data.link,o='<div id="'+e.data.hash_id+'" class="adflex-b-reset adflex-b-box adflex-dsa">\n                <div style="position: relative; display: inline-block; padding: 0; margin: 0;"> \n                    <a href="'+n+'" class="adflex-b-reset" target="_blank">\n                    <img class="adflex-b-reset" \n                         src="'+e.data.img_url+'"\n                         style="width: '+e.data.img_width+'px; max-width: 100% !important;">\n                    </a>\n                    '+f(i)+"\n                    </div>\n                </div>";document.getElementById(t).innerHTML+=o}else 1==e.params.third_party_status&&e.params.third_party_code&&(document.getElementById(t).innerHTML+=e.params.third_party_code,p.runJs(t))}function d(t,e,i){if(e.data){var n="background-color:"+e.params.unitBgColor+"; border-color:"+e.params.unitBorderColor+";",o="color:"+e.params.titleColor+"; font-family:"+e.params.fontFamily+";",a="color:"+e.params.descriptionColor+"; font-family:"+e.params.fontFamily+";",r="background-color:"+e.params.buttonBgColor+";\n                       border-color:"+e.params.buttonBorderColor+";\n                       color:"+e.params.buttonColor+";\n                       font-family:"+e.params.fontFamily+";",d=p.config.click_url+"/?"+e.data.link,l=e.data.img_url?1:0,s='<div id="'+e.data.hash_id+'" style="'+n+'" data-is-image="'+l+'" class="adflex-unit adflex-dsa">\n                    <a href="'+d+'" class="image" style="background: url('+e.data.img_url+') no-repeat center center;" target="_blank"></a>\n                    <div class="body">\n                        <a style="'+o+'" href="'+d+'" class="title" target="_blank">'+e.data.title+'</a>\n                        <div style="'+a+'" class="description">'+e.data.description+'</div>\n                        <a style="'+r+'" class="button" href="'+d+'" target="_blank">'+(e.data.action_text||e.data.ad_domain)+"</a>\n                    </div>\n                    "+f(i)+"\n                </div>";document.getElementById(t).innerHTML+=s,m(t)}}function m(t){if("a"==t[0]){var e=document.getElementById(t).getElementsByTagName("div")[0],i=e.getAttribute("data-is-image");e.parentElement.offsetWidth<500?e.classList.add("adflex-unit-vertical"):e.classList.remove("adflex-unit-vertical"),1!=i?e.classList.contains("adflex-unit-vertical")?e.classList.add("adflex-unit-vertical-noimage"):e.classList.add("adflex-unit-noimage"):(e.classList.remove("adflex-unit-noimage"),e.classList.remove("adflex-unit-vertical-noimage"))}}var i=null;window.addEventListener("resize",p.throttle(function(){var t=i||document.getElementsByClassName(p.config.unit_class);i=t;for(var e=0;e<t.length;e++)""!==t[e].id&&m(t[e].id)},600)),t.exports=function(o){!function(t,e){if(t){if(p.config.debug)var i={units_hash_ids:t,debug:p.config.debug};else i={units_hash_ids:t};p.ajax({url:p.config.provider_url,data:i,isJSON:!0,callback:e})}else console.log("Adflex: units not found")}(function(){for(var t=[],e=document.getElementsByClassName(p.config.unit_class),i=0;i<e.length;i++)e[i].id&&-1===t.indexOf(e[i].id)&&t.push(e[i].id);return t}(),function(t,e){var i,n;t&&e?(i=" .adflex-unit { position: relative !important; margin: 0 auto !important; width: 100% !important; max-width: 728px !important; min-width: 300px !important; height: 200px !important; /*background: #f3f3f3 !important;*/ border-width: 1px !important; border-style: solid !important; /*border-color: #a8a8a8 !important;*/ padding: 0 !important; overflow: hidden !important; box-sizing: border-box !important; text-align: left !important; } .adflex-unit .image { display: block !important; float: left !important; padding: 0 !important; margin: 0 !important; width: 40% !important; height: 100% !important; /*background-image: url(/assets/imgs/some.png);*/ background-repeat: no-repeat !important; background-size: cover !important; background-position: center center !important; box-sizing: border-box !important; } .adflex-unit .body { position: relative !important; float: right !important; width: 60% !important; height: 100% !important; background: transparent !important; padding: 10px 10px 15px 15px !important; box-sizing: border-box !important; } .adflex-unit .body .title { /*font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;*/ width: 100% !important; margin: 0 !important; padding: 0 0 10px 0 !important; display: block !important; font-size: 20px !important; font-weight: bold !important; /*color: #3079ED !important;*/ text-decoration: none !important; box-sizing: border-box !important; text-align: left !important; } .adflex-unit .body .title:hover, .adflex-unit .body .title:active { /*color: #3079ED !important;*/ text-decoration: underline !important; } .adflex-unit .body .title:visited { /*color: #3079ED !important;*/ } .adflex-unit .body .description { /*font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;*/ width: 100% !important; box-sizing: border-box !important; margin: 0 !important; /*color: #000000 !important;*/ font-size: 16px !important; text-align: left !important; } .adflex-unit .body .button { /*font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;*/ position: absolute !important; bottom: 15px !important; left: 15px !important; /*background: #4D90FE !important;*/ /*border-color: #3079ED !important;*/ border-style: solid !important; border-width: 1px !important; border-radius: 4px !important; /*color: #ffffff !important;*/ padding: 5px 10px !important; font-size: 14px !important; text-decoration: none !important; } .adflex-unit .body .button:hover, .adflex-unit .body .button:active { text-decoration: none !important; /*color: #ffffff !important;*/ /*background: #3079ED !important;*/ } .adflex-unit .body .button:visited { text-decoration: none !important; /*color: #ffffff !important;*/ } .adflex-unit-noimage .image { display: none !important; } .adflex-unit-noimage .body { width: 100% !important; } .adflex-unit-vertical { width: 300px !important; height: 250px !important; } .adflex-unit-vertical .image { width: 100% !important; height: 150px !important; float: none !important; } .adflex-unit-vertical .body { width: 100% !important; height: 100px !important; float: none !important; padding: 5px 15px !important; } .adflex-unit-vertical .body .title { font-size: 16px !important; } .adflex-unit-vertical .body .description { display: none !important; } .adflex-unit-vertical .body .button { padding: 5px 10px !important; font-size: 12px !important; } .adflex-unit-vertical-noimage .image { display: none !important; } .adflex-unit-vertical-noimage .body { width: 100% !important; height: 100% !important; float: none !important; padding: 5px 15px !important; } .adflex-unit-vertical-noimage .body .title { padding-top: 10px !important; font-size: 20px !important; } .adflex-unit-vertical-noimage .body .description { display: block !important; } .adflex-unit-vertical-noimage .body .button { padding: 5px 10px !important; font-size: 16px !important; }  .adflex-b-box{ text-align: center !important; position: relative; !important; } .adflex-tip{ position: absolute !important; top: 0 !important; right: 0 !important; display: inline !important; background: #000 !important; //z-index: 20000 !important; cursor: pointer !important; color: #fff !important; font-size: 12px !important; padding: 3px 5px !important; text-decoration: none !important; border-bottom-left-radius: 2px !important; } .adflex-b-box a{ //font-size: 0 !important; } .adflex-b-box img{ overflow: hidden !important; padding: 0 !important; margin:0 !important; border: none !important; } .adflex-b-reset{ background: none !important; border: none !important; border-radius: 0 !important; border-spacing: 0 !important; border-collapse: collapse !important; clear: none !important; float: none !important; font-variant: normal !important; letter-spacing: normal !important; line-height: normal !important; margin: 0 !important; max-height: none !important; max-width: none !important; min-height: 0 !important; min-width: 0 !important; outline: none !important; padding: 0 !important; position: static !important; text-decoration: none !important; text-indent: 0 !important; text-transform: none !important; vertical-align: baseline !important; visibility: visible !important; word-spacing: normal !important; } .adflex-mobile-box { position: fixed; z-index: 1000000; bottom: 0; left: 0; width: 100%; height: 100px; background: #ececec; border: 1px solid #e2e2e2; } .adflex-mobile-box-top { top: 0; bottom: auto; } .adflex-mobile-box__close { position: absolute; top: 0; right: 0; width: 30px; height: 30px; background: #000; color: #fff; font-size: 30px; line-height: 30px; font-weight: bold; text-align: center; z-index: 2; } .adflex-mobile-box__inner { display: block; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; } .adflex-mobile-box__image { position: absolute; top: 0; left: 0; height: 100px; width: 100px; object-fit: cover; } .adflex-mobile-box__title { position: absolute; top: 10px; left: 110px; font-size: 16px; font-weight: bold; padding-right: 30px; color: #1528ff; } .adflex-mobile-box__link { display: inline-block; position: absolute; bottom: 10px; left: 110px; padding: 3px 7px; font-size: 14px; font-weight: normal; background: #1528ff; border: 1px solid #121ca4; color: #fff; border-radius: 5px; } .adflex-mobile-box__noimage .adflex-mobile-box__image { display: none; } .adflex-mobile-box__noimage .adflex-mobile-box__title, .adflex-mobile-box__noimage .adflex-mobile-box__link { left: 10px; } ",(n=document.createElement("style")).type="text/css",n.styleSheet?n.styleSheet.cssText=i:n.appendChild(document.createTextNode(i)),document.getElementsByTagName("head")[0].appendChild(n),function(t){var e,i,n=1==t.units.visible_tip;for(var o in t.units)"b"===o[0]?r(o,t.units[o],n):"a"===o[0]?d(o,t.units[o],n):"m"===o[0]&&(e=o,i=t.units[o],a("./renderMobileUnit")(e,i))}(e),setTimeout(function(){o(e)},100)):console.log("Adflex: error render units")})}},{"./adflex":1,"./renderMobileUnit":4}],4:[function(t,e,i){var a=t("./adflex");function n(t){t.style.display=window.innerWidth<=768?"block":"none"}function o(t,e,i){var n;if(i.data&&(n=e,void 0===window.adflex.mobileUnitId&&(window.adflex.mobileUnitId=n),window.adflex.mobileUnitId==n)&&!/adflex-mobile-box/.test(t.className)&&1!=a.getCookie("adflex_m_close_exp")){var o=a.config.click_url+"/?"+i.data.link;t.className+=" adflex-mobile-box",i.data.img_url.length||(t.className+=" adflex-mobile-box__noimage"),"top"==i.params.position&&(t.className+=" adflex-mobile-box-top"),t.innerHTML='\n            <div data-hidden-period="'+i.params.hidden_period+'" class="adflex-mobile-box__close">&times;</div>\n            \n            <a id="'+i.data.hash_id+'" target="_blank" class="adflex-mobile-box__inner adflex-dsa" href="'+o+'">\n                <img class="adflex-mobile-box__image" src="'+i.data.img_url+'">\n                <div class="adflex-mobile-box__title">'+i.data.title+'</div>\n                <div class="adflex-mobile-box__link">'+(i.data.action_text||i.data.ad_domain)+"</div>\n            </a>\n    "}}document.onclick=function(t){if("adflex-mobile-box__close"==t.target.className){t.stopPropagation();try{var e=t.target.attributes["data-hidden-period"].value}catch(t){e=10}return t.target.parentNode.style.display="none",a.setCookie("adflex_m_close_exp","1",{expires:parseInt(e)}),!1}},e.exports=function(t,e){var i=document.getElementById(t);i&&(window.addEventListener("resize",a.throttle(function(){o(i,t,e),n(i)},500),!0),o(i,t,e),n(i))}},{"./adflex":1}],5:[function(t,e,i){var r=t("./adflex"),d=[];function l(t){for(var e=document.getElementById(t).getElementsByClassName(r.config.dsa_class),i=[],n=0;n<e.length;n++)30<e[n].offsetWidth&&30<e[n].offsetHeight&&i.push(e[n].id);return i}function n(t){for(var e=[],i=function(){for(var t=[],e=document.getElementsByClassName(r.config.unit_class),i=0;i<e.length;i++)""!==e[i].id&&-1===d.indexOf(e[i].id)&&r.isVisibleElement(e[i])&&(t.push(e[i].id),d.push(e[i].id));return t}(),n=0;n<i.length;n++){var o=l(i[n]);0!=o.length&&void 0!==t.units&&void 0!==t.units[i[n]]&&void 0!==t.units[i[n]].hmac&&void 0!==t.units[i[n]].time&&e.push({uid:i[n],aids:o,hmac:t.units[i[n]].hmac,time:t.units[i[n]].time})}if(0!==e.length){if(r.config.debug)var a={units:JSON.stringify(e),debug:r.config.debug};else a={units:JSON.stringify(e)};r.ajax({url:r.config.view_url,data:a,method:"POST",callback:function(t,e){e&&console.log(e)}})}}e.exports=function(t){n(t),window.onresize=r.throttle(function(){n(t)},600),window.onscroll=r.throttle(function(){n(t)},600)}},{"./adflex":1}],6:[function(t,i,e){!function(t,e){void 0!==i?i.exports=e():"function"==typeof define&&"object"==_typeof(define.amd)?define(e):this.domready=e()}(0,function(){var t,e=[],i=document,n=i.documentElement.doScroll,o="DOMContentLoaded",a=(n?/^loaded|^c/:/^loaded|^i|^c/).test(i.readyState);return a||i.addEventListener(o,t=function(){for(i.removeEventListener(o,t),a=1;t=e.shift();)t()}),function(t){a?setTimeout(t,0):e.push(t)}})},{}]},{},[2]);