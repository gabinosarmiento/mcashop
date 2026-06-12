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
Element.prototype.notification = function(options) {
    var instance = this;
    var settings = Object.assign({
        body: "",
        type: "primary",
        duration: 9000,
        width: "500px",
        zIndex: 1080,
        right: "30px",
        top: "30px",
        margin: "30px",
        direction: "prepend",
        animationDuration: 300
    }, options || {});

    var containerId = "bootstrap-show-notification-container";
    var container = document.getElementById(containerId);

    if (!container) {
        container = document.createElement('div');
        container.id = containerId;
        document.body.appendChild(container);

        var css = "#" + containerId + "{position:fixed;right:" + settings.right + ";top:" + settings.top + ";z-index:" + settings.zIndex + ";width:" + settings.width + ";max-width:calc(100% - 60px)}#" + containerId + " .alert{width:100%;max-width:none;margin-bottom:4px}#" + containerId + " .alert-dismissible .btn-close{position:absolute;top:20px;right:10px;z-index:2}";

        var style = document.createElement('style');
        (document.head || document.getElementsByTagName('head')[0]).appendChild(style);
        style.appendChild(document.createTextNode(css));
    }

    var wrapper = document.createElement('div');
    wrapper.innerHTML = "<div class='alert alert-" + settings.type + " alert-dismissible fade' role='alert'>" + settings.body + "<button type='button' class='btn-close' aria-label='Cerrar'></button></div>";

    var el = wrapper.firstElementChild;

    if (settings.direction === 'prepend') {
        container.insertBefore(el, container.firstChild);
    }

    if (settings.direction !== 'prepend') {
        container.appendChild(el);
    }

    requestAnimationFrame(function() {
        el.classList.add('show');
    });

    var closeBtn = el.querySelector('.btn-close');

    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            el.classList.remove('show');

            var remove = function() {
                el.remove();
                el.removeEventListener('transitionend', remove);
            };

            el.addEventListener('transitionend', remove);
            setTimeout(remove, settings.animationDuration);
        });
    }

    if (settings.duration) {
        setTimeout(function() {
            if (closeBtn) {
                closeBtn.click();
            }

            if (!closeBtn) {
                el.classList.remove('show');

                var remove = function() {
                    el.remove();
                    el.removeEventListener('transitionend', remove);
                };

                el.addEventListener('transitionend', remove);
                setTimeout(remove, settings.animationDuration);
            }
        }, settings.duration);
    }

    return el;
};