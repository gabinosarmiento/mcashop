/*
 * Bootstrap Cookie Alert by Wruczek
 * https://github.com/Wruczek/Bootstrap-Cookie-Alert
 * Released under MIT license
 */
!function(){"use strict";var e=document.querySelector(".cookiealert"),t=document.querySelector(".acceptcookies");if(e){getCookie("acceptCookies")||requestAnimationFrame(function(){e.classList.add("show")}),t.addEventListener("click",function(){setCookie("acceptCookies",!0,365),e.classList.remove("show"),window.dispatchEvent(new Event("cookieAlertAccept"))})}function setCookie(e,t,o){var n=new Date;n.setTime(n.getTime()+24*o*60*60*1e3);var c="expires="+n.toUTCString();document.cookie=e+"="+t+";"+c+";path=/"}function getCookie(e){for(var t=e+"=",o=decodeURIComponent(document.cookie).split(";"),n=0;n<o.length;n++){for(var c=o[n];" "==c.charAt(0);)c=c.substring(1);if(0==c.indexOf(t))return c.substring(t.length,c.length)}return""}}();