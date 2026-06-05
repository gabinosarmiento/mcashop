/**
 * Notification (Vanilla JavaScript)
 *
 * Provides a Bootstrap v4-style notification component
 * built with native DOM methods and classes.
 *
 * Features:
 * - Lightweight, minimal configuration
 * - Uses Bootstrap's existing utility classes
 * - No external dependencies beyond Bootstrap CSS
 *
 * @author   Gabino Sarmiento
 * @version  3.0
 * @updated  2025-08-27
 */

Element.prototype.notification=function(e){var t=Object.assign({body:"",type:"primary",duration:9e3,width:"500px",zIndex:1080,right:"30px",top:"20px",margin:"30px",direction:"prepend"},e||{}),i="bootstrap-show-notification-container",n=document.getElementById(i);if(!n){(n=document.createElement("div")).id=i,document.body.appendChild(n);var a="#"+i+"{position:fixed;right:"+t.right+";top:"+t.top+";z-index:"+t.zIndex+";width:"+t.width+";max-width:calc(100% - 60px)}#"+i+" .alert{width:100%;max-width:none;margin-bottom:4px}",r=document.createElement("style");(document.head||document.getElementsByTagName("head")[0]).appendChild(r),r.appendChild(document.createTextNode(a))}var o=document.createElement("div");o.innerHTML="<div class='alert alert-"+t.type+" alert-dismissible fade' role='alert'>"+t.body+"<button type='button' class='close' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>";var d=o.firstElementChild;"prepend"===t.direction?n.insertBefore(d,n.firstChild):n.appendChild(d),requestAnimationFrame(function(){d.classList.add("show")});var s=d.querySelector(".close");return s&&s.addEventListener("click",function(){d.classList.remove("show");var e=function(){d.remove(),d.removeEventListener("transitionend",e)};d.addEventListener("transitionend",e),setTimeout(e,t.animationDuration)}),t.duration&&setTimeout(function(){if(s)s.click();else{d.classList.remove("show");var e=function(){d.remove(),d.removeEventListener("transitionend",e)};d.addEventListener("transitionend",e),setTimeout(e,t.animationDuration)}},t.duration),d};