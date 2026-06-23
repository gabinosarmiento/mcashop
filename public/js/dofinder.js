/**
 * Dofinder (Vanilla JavaScript)
 *
 * Provides a confirmation modal component built entirely
 * with native DOM methods and classes, designed for
 * Bootstrap-like styling without jQuery.
 *
 * Features:
 * - Customizable title, message, and action buttons
 * - Supports multiple actions with callbacks
 * - No external dependencies
 *
 * @author   Gabino Sarmiento
 * @updated  March 07, 2026
 * @version  2.0
 */
(function() {
   Element.prototype.dofinder = function(action, options) {

      var instance = this;

      var settings = Object.assign({
         delay: 300,
         url: '/buscar',
         classOpen: 'dofinder-open',
         modalId: 'dofinder-modal',
         modalSelector: '#dofinder-modal',
         closeSelector: '.dofinder-close',
         inputSelector: 'input[name="dofinder-input"]',
         filterSelector: '#dofilter-form',
         classShowing: 'dofinder-showing',
         classShown: 'dofinder-shown',
         classHiding: 'dofinder-hiding',
         overlayClass: 'dofinder-overlay',
         overlayDuration: 100,
         partialSelector: '#dofinder-content'
      }, options);

      function getForm() {
         return instance;
      }

      function getInput() {
         return instance.querySelector(settings.inputSelector);
      }

      function getFilterForm() {
         return document.querySelector(settings.filterSelector);
      }

      function getOverlay() {
         return document.querySelector('.' + settings.overlayClass);
      }

      function getModal() {
         return document.querySelector(settings.modalSelector);
      }

      function getProgress() {
         var modal = getModal();

         if (!modal) {
            return null;
         }

         return modal.querySelector('.dofinder-progress');
      }

      function getProgressBar() {
         var modal = getModal();

         if (!modal) {
            return null;
         }

         return modal.querySelector('.dofinder-progress-bar');
      }

      function showProgress() {
         var progress = getProgress();

         if (!progress) {
            return;
         }

         progress.style.opacity = '1';
      }

      function hideProgress() {
         var progress = getProgress();

         if (!progress) {
            return;
         }

         progress.style.opacity = '0';
      }

      function startProgress(refs) {
         var bar = getProgressBar();

         if (!bar) {
            return;
         }

         stopProgressTimer(refs);

         refs.progressValue = 8;

         showProgress();

         bar.style.transition = 'none';
         bar.style.width = '0%';

         requestAnimationFrame(function() {
            bar.style.transition = 'width 0.25s ease';
            bar.style.width = refs.progressValue + '%';
         });

         refs.progressTimer = setInterval(function() {
            advanceProgress(refs);
         }, 180);
      }

      function advanceProgress(refs) {
         var bar = getProgressBar();

         if (!bar) {
            return;
         }

         if (refs.progressValue >= 85) {
            return;
         }

         if (refs.progressValue < 25) {
            refs.progressValue += 12;
            bar.style.width = refs.progressValue + '%';
            return;
         }

         if (refs.progressValue < 45) {
            refs.progressValue += 8;
            bar.style.width = refs.progressValue + '%';
            return;
         }

         if (refs.progressValue < 65) {
            refs.progressValue += 4;
            bar.style.width = refs.progressValue + '%';
            return;
         }

         refs.progressValue += 2;
         bar.style.width = refs.progressValue + '%';
      }

      function stopProgressTimer(refs) {
         if (!refs.progressTimer) {
            return;
         }

         clearInterval(refs.progressTimer);
         refs.progressTimer = null;
      }

      function finishProgress(refs) {
         var bar = getProgressBar();

         if (!bar) {
            return;
         }

         stopProgressTimer(refs);

         refs.progressValue = 100;
         bar.style.transition = 'width 0.18s ease';
         bar.style.width = '100%';

         setTimeout(function() {
            bar.style.transition = 'none';
            bar.style.width = '0%';
            hideProgress();
         }, 220);
      }

      function resetProgress(refs) {
         var bar = getProgressBar();

         stopProgressTimer(refs);

         refs.progressValue = 0;

         if (!bar) {
            return;
         }

         bar.style.transition = 'none';
         bar.style.width = '0%';
         hideProgress();
      }

      function isOpen() {
         return document.body.classList.contains(settings.classOpen) && getModal();
      }

      function createOverlay() {
         var overlay = getOverlay();

         if (overlay) {
            return overlay;
         }

         overlay = document.createElement('div');
         overlay.className = settings.overlayClass;
         document.body.appendChild(overlay);

         requestAnimationFrame(function() {
            document.body.classList.add(settings.classOpen);
         });

         return overlay;
      }

      function removeOverlay() {
         var overlay = getOverlay();

         if (!overlay) {
            return;
         }

         document.body.classList.remove(settings.classOpen);

         overlay.addEventListener('transitionend', function handler(e) {
            if (e.target !== overlay) {
               return;
            }

            overlay.removeEventListener('transitionend', handler);
            overlay.remove();
         });
      }

      function removeOldModal() {
         var oldModal = getModal();

         if (!oldModal) {
            return;
         }

         oldModal.remove();
      }

      function openModal(modal) {
         createOverlay();

         modal.classList.add(settings.classShowing);
         modal.offsetHeight;

         requestAnimationFrame(function() {
            modal.classList.add(settings.classShown);
         });
      }

      function closeModalEmpty(refs) {
         document.body.classList.remove(settings.classOpen);
         removeOverlay();
         resetProgress(refs);
         refs.isOpen = false;
      }

      function abortRequest(refs) {
         if (!refs.controller) {
            return;
         }

         refs.controller.abort();
         refs.controller = null;
         resetProgress(refs);
      }

      function close(refs) {
         var input = getInput();

         if (input) {
            input.value = '';
         }

         var modal = getModal();

         if (!modal) {
            closeModalEmpty(refs);
            return;
         }

         abortRequest(refs);

         modal.classList.remove(settings.classShown);
         modal.classList.add(settings.classHiding);

         modal.addEventListener('transitionend', function handler(e) {
            if (e.target !== modal) {
               return;
            }

            modal.removeEventListener('transitionend', handler);
            modal.remove();
            document.body.classList.remove(settings.classOpen);
            removeOverlay();
         });

         refs.isOpen = false;
      }

      function buildParams(query, partial) {
         var params = new URLSearchParams();

         params.set('param', query);

         if (!partial) {
            return params.toString();
         }

         params.set('partial', 'true');

         var filterForm = getFilterForm();

         if (filterForm) {
            var formData = new FormData(filterForm);

            formData.forEach(function(value, key) {
               params.append(key, value);
            });
         }

         return params.toString();
      }

      function search(refs, query, partial) {
         refs.requestId += 1;

         var currentId = refs.requestId;

         if (refs.controller) {
            refs.controller.abort();
         }

         refs.controller = new AbortController();

         startProgress(refs);

         var url = settings.url + '?' + buildParams(query, partial);

         fetch(url, {
            signal: refs.controller.signal
         }).then(function(response) {
            if (response.ok) {
               return response.text();
            }

            throw new Error('Search failed');
         }).then(function(html) {
            if (currentId !== refs.requestId) {
               return;
            }

            finishProgress(refs);

            var existingModal = getModal();

            if (partial) {
               if (!existingModal) {
                  return;
               }

               var inner = existingModal.querySelector(settings.partialSelector);

               if (!inner) {
                  return;
               }

               inner.innerHTML = html;
               return;
            }

            if (existingModal) {
               var tmp = document.createElement('div');
               tmp.innerHTML = html;

               var newModal = tmp.querySelector(settings.modalSelector);

               if (!newModal) {
                  return;
               }

               existingModal.innerHTML = newModal.innerHTML;
               return;
            }

            removeOldModal();

            var form = getForm();

            if (!form) {
               return;
            }

            form.insertAdjacentHTML('afterend', html);

            var modal = getModal();

            if (!modal) {
               return;
            }

            openModal(modal);
            refs.isOpen = true;
         }).catch(function(error) {
            if (error.name === 'AbortError') {
               return;
            }

            resetProgress(refs);
            console.error(error);
         });
      }

      function handlePreventEnter(e) {
         if (e.key === 'Enter') {
            e.preventDefault();
         }
      }

      function handleInput(refs) {
         clearTimeout(refs.inputTimer);

         refs.inputTimer = setTimeout(function() {
            var input = getInput();
            var query = '';

            if (input) {
               query = input.value.trim();
            }

            if (query.length === 0) {
               close(refs);
               return;
            }

            search(refs, query, false);
         }, settings.delay);
      }

      function handleFilterChange(refs) {
         var input = getInput();
         var query = '';

         if (input) {
            query = input.value.trim();
         }

         if (query.length === 0) {
            return;
         }

         if (!isOpen()) {
            return;
         }

         search(refs, query, true);
      }

      function handleClick(refs, e) {
         var closeBtn = e.target.closest(settings.closeSelector);

         if (closeBtn) {
            close(refs);
         }
      }

      function handlePointerDown(refs, e) {
         if (!refs.isOpen) {
            return;
         }

         var modal = getModal();

         if (!modal) {
            return;
         }

         if (instance.contains(e.target)) {
            return;
         }

         if (modal.contains(e.target)) {
            return;
         }

         close(refs);
      }

      function handleKeyDown(refs, e) {
         if (!refs.isOpen) {
            return;
         }

         if (e.key === 'Escape') {
            close(refs);
         }
      }

      function bind() {
         var form = getForm();
         var input = getInput();

         if (!form) {
            return;
         }

         if (!input) {
            return;
         }

         if (instance.__dofinderBound) {
            return;
         }

         instance.__dofinderBound = true;

         var refs = {
            isOpen: false,
            controller: null,
            requestId: 0,
            inputTimer: null,
            progressTimer: null,
            progressValue: 0
         };

         input.addEventListener('keydown', function(e) {
            handlePreventEnter(e);
         });

         input.addEventListener('input', function() {
            handleInput(refs);
         });

         document.addEventListener('click', function(e) {
            handleClick(refs, e);
         });

         document.addEventListener('pointerdown', function(e) {
            handlePointerDown(refs, e);
         });

         document.addEventListener('keydown', function(e) {
            handleKeyDown(refs, e);
         });

         document.addEventListener('change', function(e) {
            var filterForm = getFilterForm();

            if (!filterForm) {
               return;
            }

            if (!filterForm.contains(e.target)) {
               return;
            }

            handleFilterChange(refs);
         });

         instance.__dofinderRefs = refs;
      }

      function execute(action) {
         if (action === 'init') {
            bind();
            return;
         }

         var refs = instance.__dofinderRefs;

         if (!refs) {
            return;
         }

         if (action === 'close') {
            close(refs);
            return;
         }

         if (action === 'search') {
            var input = getInput();
            var query = '';

            if (input) {
               query = input.value.trim();
            }

            if (query.length === 0) {
               close(refs);
               return;
            }

            search(refs, query, false);
         }
      }

      execute(action);
   };

   document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('dofinder-form');

      if (form) {
         form.dofinder('init');
      }
   });
})();