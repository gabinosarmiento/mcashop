/**
 * Overlap (Vanilla JavaScript)
 *
 * Provides utility methods to create an overlapping modal
 * with backdrop effect.
 *
 * Methods:
 * - show(target): Displays the element with backdrop
 * - hide(target): Hides the element and removes backdrop
 *
 * Notes:
 * - Effect can be toggled by calling `show()` or `exec(action)`.
 * - No external dependencies; works with native DOM APIs.
 *
 * @author   Gabino Sarmiento
 * @updated  March 07, 2026
 * @version  3.0
 */
Element.prototype.overlap = function(action, options) {
    var instance = this;
    var overlap = instance.id;

    var settings = Object.assign({
        backdrop: true,
        backdropClass: 'backdrop',
        backdropDuration: 300,
        animationDuration: 300,
        zIndexBase: 1060,
        empty: true
    }, options);

    function createBackdrop(level) {
        if (settings.backdrop) {
            var backdrop = document.createElement('div');
            backdrop.className = settings.backdropClass + ' ' + overlap;
            backdrop.style.zIndex = settings.zIndexBase + level;

            instance.parentNode.insertBefore(backdrop, instance);

            setTimeout(function() {
                backdrop.classList.add('backdrop-showing');
            }, 50);
        }
    }

    function removeBackdrop() {
        if (settings.backdrop) {
            var backdrop = instance.parentNode.querySelector('.' + settings.backdropClass + '.' + overlap);

            if (backdrop) {
                backdrop.classList.remove('backdrop-showing');
                backdrop.classList.add('backdrop-hiding');
                backdrop.addEventListener('transitionend', function handler() {
                    backdrop.removeEventListener('transitionend', handler);
                    backdrop.remove();
                });
            }
        }
    }

    function updateBody() {
        const anyOpen = document.querySelector('.overlap-showing, .overlap-shown');
        document.body.classList.toggle('overlap-open', !!anyOpen);
    }

    function execute(action) {
        if (action === 'show') {
            if (!instance.classList.contains('overlap-shown')) {

                var level = document.querySelectorAll('.overlap-showing, .overlap-shown').length;

                instance.style.zIndex = settings.zIndexBase + (level + 1);

                createBackdrop(level);

                instance.classList.add('overlap-showing');
                instance.addEventListener('transitionend', function handler() {
                    instance.removeEventListener('transitionend', handler);
                    instance.classList.add('overlap-shown');
                    updateBody();
                });

                updateBody();
            }
        }

        if (action === 'hide') {
            if (!instance.classList.contains('overlap-hidden')) {
                instance.classList.remove('overlap-showing');
                instance.classList.add('overlap-hiding');
                instance.addEventListener('transitionend', function handler() {
                    instance.removeEventListener('transitionend', handler);
                    instance.classList.remove('overlap-shown');
                    instance.classList.remove('overlap-hiding');

                    instance.removeAttribute('style');

                    if (settings.empty) {
                        instance.innerHTML = '';
                    }

                    updateBody();
                });

                removeBackdrop();
            }
        }
    }

    if (!instance.__overlapClickBound) {
        instance.__overlapClickBound = true;

        instance.addEventListener('click', function(e) {
            if (e.target.closest('.overlap-close')) {
                execute('hide');
            }
        });
    }

    execute(action);
};