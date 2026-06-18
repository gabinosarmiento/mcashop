/**
 * General Tools (Vanilla JavaScript)
 *
 * A small collection of utility extensions for DOM elements,
 * focused on UI feedback and inline editing behaviors.
 *
 * Included tools:
 * - shakeIt(): Triggers a CSS-based shake animation on an element
 * - makeEditable(): Enables inline editing for static elements
 * - inputReset: Adds a clear (×) button to text inputs
 *
 * Features:
 * - No external dependencies
 * - Uses native DOM APIs only
 * - Designed to be framework-agnostic
 *
 * Notes:
 * - Intended for administrative and interactive UI components
 * - Validation and persistence logic are delegated to the caller
 *
 * @author   Gabino Sarmiento
 * @updated  February 02, 2026
 * @version  2.0
 */
/* =========================================================
 * Copy Tool — Vanilla JS
 * ========================================================= */
(function () {

   function normalizeText(str) {
      return String(str || '').replace(/\s+/g, ' ').trim();
   }

   function elementToText(element) {
      if (!element) {
         return '';
      }

      const lines = [];

      const rows = element.querySelectorAll('tr');
      if (rows.length) {
         rows.forEach(function (tr) {
            const cells = tr.querySelectorAll('td, th');
            const parts = [];

            cells.forEach(function (cell) {
               const value = normalizeText(cell.textContent);
               if (value) {
                  parts.push(value);
               }
            });

            if (parts.length) {
               lines.push(parts.join(' '));
            }
         });

         return lines.join('\n');
      }

      const items = element.querySelectorAll('li');
      if (items.length) {
         items.forEach(function (li) {
            const value = normalizeText(li.textContent);
            if (value) {
               lines.push(value);
            }
         });

         return lines.join('\n');
      }

      return normalizeText(element.textContent);
   }

   function legacyCopy(text) {
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.setAttribute('readonly', 'readonly');

      textarea.style.position = 'fixed';
      textarea.style.top = '-9999px';
      textarea.style.left = '-9999px';

      document.body.appendChild(textarea);
      textarea.select();

      document.execCommand('copy');
      document.body.removeChild(textarea);
   }

   function setTooltip(button, text) {
      if (!button) {
         return;
      }

      button.setAttribute('data-tooltip', text);

      if (button.__copyTooltipTimer) {
         clearTimeout(button.__copyTooltipTimer);
      }

      button.__copyTooltipTimer = setTimeout(function () {
         button.removeAttribute('data-tooltip');
         button.__copyTooltipTimer = null;
      }, 1500);
   }

   function animateButton(button) {
      if (!button) {
         return;
      }

      if (!button.animate) {
         return;
      }

      button.animate([
         { transform: 'scale(1)' },
         { transform: 'scale(1.12)' },
         { transform: 'scale(1)' }
      ], {
         duration: 220,
         iterations: 1,
         easing: 'ease-in-out'
      });
   }

   function copyText(text, done) {
      if (!text) {
         done(false);
         return;
      }

      if (navigator.clipboard && navigator.clipboard.writeText) {
         navigator.clipboard.writeText(text).then(function () {
            done(true);
         }).catch(function () {
            legacyCopy(text);
            done(true);
         });

         return;
      }

      legacyCopy(text);
      done(true);
   }

   document.addEventListener('click', function (e) {
      const button = e.target.closest('.btn-copy');

      if (!button) {
         return;
      }

      e.preventDefault();
      e.stopPropagation();

      const selector = button.getAttribute('data-target');

      if (!selector) {
         setTooltip(button, 'Sin destino');
         return;
      }

      const element = document.querySelector(selector);

      if (!element) {
         setTooltip(button, 'No encontrado');
         return;
      }

      const text = elementToText(element);

      copyText(text, function (ok) {
         if (!ok) {
            setTooltip(button, 'Sin texto');
            return;
         }

         setTooltip(button, 'Copiado');
         animateButton(button.firstElementChild || button);
      });
   });

})();

/* =========================================================
 * Input Reset (SVG) — Vanilla JS, zero-force
 * ========================================================= */
(function () {

   function refocus(input) {
      requestAnimationFrame(function () {
         if (!input.isConnected) {
            return;
         }

         input.focus({ preventScroll: true });
      });
   }

   function initInput(input) {
      if (!input) {
         return;
      }

      if (input.dataset.resetReady) {
         return;
      }

      const parent = input.parentNode;

      if (!parent) {
         return;
      }

      if (!parent.classList.contains('reset-wrap')) {
         const wrap = document.createElement('div');
         wrap.className = 'reset-wrap';
         parent.insertBefore(wrap, input);
         wrap.appendChild(input);
         refocus(input);
      }

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'reset-btn';
      btn.hidden = true;
      btn.setAttribute('aria-label', 'Borrar');

      btn.innerHTML =
         '<svg width="10" height="10" viewBox="0 0 10 10" aria-hidden="true">' +
            '<path d="M1 1 L9 9 M9 1 L1 9" ' +
            'stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>' +
         '</svg>';

      input.after(btn);
      input.dataset.resetReady = '1';

      function sync() {
         if (!input.isConnected) {
            return;
         }

         btn.hidden = true;

         if (input.disabled) {
            return;
         }

         if (input.readOnly) {
            return;
         }

         if (input.value === '') {
            return;
         }

         btn.hidden = false;
      }

      input.addEventListener('input', sync);
      input.addEventListener('change', sync);

      btn.addEventListener('click', function () {
         input.value = '';
         input.dispatchEvent(new Event('input', { bubbles: true }));
         input.focus();
         sync();
      });

      sync();
   }

   // Inicializa SOLO cuando el usuario interactúa
   document.addEventListener('focusin', function (ev) {
      const el = ev.target;

      if (!el) {
         return;
      }

      if (!el.matches) {
         return;
      }

      if (!el.matches('input.form-reset')) {
         return;
      }

      initInput(el);
   });

})();

/* =========================================================
 * HTMLElement.prototype.shakeIt
 * ========================================================= */
HTMLElement.prototype.shakeIt = function() {
   this.classList.remove('shake-it');

   void this.offsetWidth;

   this.classList.add('shake-it');

   if (this.shakeTimeout) {
      clearTimeout(this.shakeTimeout);
   }

   const el = this;

   this.shakeTimeout = setTimeout(function() {
      el.classList.remove('shake-it');
      el.shakeTimeout = null;
   }, 6000);
};

/* =========================================================
 * HTMLElement.prototype.makeEditable
 * ========================================================= */
HTMLElement.prototype.makeEditable = function(options, validate) {
   const defaults = {
      type: 'local',
      route: '/form'
   };

   const opts = (function() {
      const result = {};
      for (const key in defaults) {
         result[key] = defaults[key];
      }
      if (options && typeof options === 'object') {
         for (const key in options) {
            result[key] = options[key];
         }
      }
      return result;
   })();

   if (this.__isEditing) {
      return;
   }
   this.__isEditing = true;

   if (window.currentEditableInput) {
      const activeForm = window.currentEditableInput;
      const mainInput = activeForm.querySelector('#editable-main');
      const oldVal = activeForm.getAttribute('editable-original-value');

      if (mainInput) {
         const newVal = mainInput.value.trim();
         const isValid = validate(mainInput);

         if (isValid === false) {
            restoreEditable(activeForm, activeForm._originalElement, oldVal);
         }

         if (isValid !== false) {
            restoreEditable(activeForm, activeForm._originalElement, newVal);
         }
      }

      window.currentEditableInput = null;
   }

   const editable = this;

   const raw = editable.getAttribute('editable-form');
   if (!raw) {
      this.__isEditing = false;
      return;
   }

   const attribute = JSON.parse(raw);
   const oldValue = opts.value.trim();
   editable.setAttribute('editable-original-value', oldValue);

   for (const field of attribute.fields) {
      if (field.id === 'editable-main') {
         field.value = oldValue;
      }
   }

   if (opts.type === 'ajax') {
      const query = encodeURIComponent(JSON.stringify(attribute));
      const route = opts.route.concat('?form=', query);

      fetch(route, {
         method: 'GET',
         headers: {'X-Requested-With': 'XMLHttpRequest'}
      }).then(function(response) {
         return response.text();
      }).then(function(html) {
         const range = document.createRange();
         const fragment = range.createContextualFragment(html.trim());
         const form = fragment.firstElementChild;

         form._originalElement = editable;
         form.setAttribute('editable-original-value', oldValue);

         window.currentEditableInput = form;
         editable.replaceWith(form);

         attachEditableHandlers(form, editable, oldValue, opts, validate);
      }).catch(function() {
         editable.__isEditing = false;
      });
   } else {
      const form = document.createElement('form');
      form.setAttribute('id', attribute.id);
      form.setAttribute('class', attribute.class);

      for (const field of attribute.fields) {
         const input = document.createElement('input');
         input.type = field.type || 'text';
         if (field.id) input.id = field.id;
         if (field.name) input.name = field.name;
         if (field.class) input.className = field.class;
         if (field.value) input.value = field.value;

         form.appendChild(input);
      }

      form._originalElement = editable;
      form.setAttribute('editable-original-value', oldValue);

      window.currentEditableInput = form;
      editable.replaceWith(form);

      attachEditableHandlers(form, editable, oldValue, opts, validate);
   }

   function attachEditableHandlers(form, original, oldValue, opts, validate) {
      if (form.__handlersAttached === true) {
         return;
      }
      form.__handlersAttached = true;

      const mainInput = form.querySelector('#editable-main');
      if (!mainInput) {
         original.__isEditing = false;
         return;
      }

      mainInput.focus();

      form.addEventListener('keydown', function(ev) {
         if (ev.key === 'Escape') {
            restoreEditable(form, original, oldValue);
            window.currentEditableInput = null;
         }
      });

      form.addEventListener('keydown', function(ev) {
         if (ev.key === 'Enter') {
            ev.preventDefault();
            const result = validate(mainInput);
            if (result === null) {
               restoreEditable(form, original, oldValue);
               window.currentEditableInput = null;
               return;
            }
            if (result === false) {
               mainInput.shakeIt();
               mainInput.focus();
               return;
            }
            if (opts.type === 'ajax') {
               submitForm(form, original, mainInput.value.trim());
            } else {
               restoreEditable(form, original, mainInput.value.trim());
               window.currentEditableInput = null;
            }
         }
      });

      mainInput.addEventListener('blur', function() {
         const result = validate(mainInput);
         if (result === null) {
            restoreEditable(form, original, oldValue);
            window.currentEditableInput = null;
            return;
         }
         if (result === false) {
            mainInput.shakeIt();
            mainInput.focus();
            return;
         }
         if (opts.type === 'ajax') {
            submitForm(form, original, mainInput.value.trim());
         } else {
            restoreEditable(form, original, mainInput.value.trim());
            window.currentEditableInput = null;
         }
      });
   }

   function submitForm(form, original, newValue) {
      const action = form.action;
      if (!action) {
         restoreEditable(form, original, newValue);
         window.currentEditableInput = null;
         return;
      }

      const data = new FormData(form);
      fetch(action, {
         method: 'POST',
         body: data,
         credentials: 'same-origin',
         headers: {'X-Requested-With': 'XMLHttpRequest'}
      }).then(function(response) {
         if (!response.ok) {
            return response.json().then(function(error) {
               const msg = error.message || 'Unknown error';
               showEditableError(form, msg);
               const mainInput = form.querySelector('#editable-main');
               if (mainInput) {
                  mainInput.shakeIt();
                  mainInput.focus();
               }
            });
         }

         const output = form.getAttribute('output');
         if (output) {
            return response.text().then(function(html) {
               const target = document.querySelector(output);
               if (target) {
                  target.innerHTML = html;
               }
               window.currentEditableInput = null;
               original.__isEditing = false;
            });
         }

         restoreEditable(form, original, newValue);
         window.currentEditableInput = null;
      }).catch(function() {
         showEditableError(form, 'Network error');
         const mainInput = form.querySelector('#editable-main');
         if (mainInput) {
            mainInput.shakeIt();
            mainInput.focus();
         }
      });
   }

   function restoreEditable(form, original, value) {
      const tag = original.tagName.toLowerCase();
      const el = document.createElement(tag);

      for (const attr of original.attributes) {
         el.setAttribute(attr.name, attr.value);
      }

      el.textContent = value;

      form.replaceWith(el);
      original.__isEditing = false;
   }

   function showEditableError(form, message) {
      const prev = form.querySelector('.make-error');
      if (prev) {
         prev.remove();
      }
      const span = document.createElement('span');
      span.className = 'make-error';
      span.textContent = message;
      form.appendChild(span);

      span.style.opacity = '1';
      setTimeout(function() {
         let opacity = 1;
         const step = 0.20;
         const interval = 20;
         const fadeTimer = setInterval(function() {
            opacity = opacity - step;
            if (opacity <= 0) {
               clearInterval(fadeTimer);
               span.remove();
               return;
            }
            span.style.opacity = String(opacity);
         }, interval);
      }, 6000);
   }
};
/* =========================================================
 * Card Menu Dropdown — Vanilla JS
 * ========================================================= */
(function () {
   document.addEventListener('click', function (event) {
      const button = event.target.closest('.menu-button');

      if (!button) {
         if (!event.target.closest('.menu-dropdown')) {
            closeCardMenus();
         }

         return;
      }

      event.preventDefault();
      event.stopPropagation();

      const wrap = button.closest('.menu-wrap');

      if (!wrap) {
         return;
      }

      const dropdown = wrap.querySelector('.menu-dropdown');

      if (!dropdown) {
         return;
      }

      closeCardMenus(dropdown);

      dropdown.removeAttribute('style');
      dropdown.classList.add('active');

      requestAnimationFrame(function () {
         positionCardMenu(button, wrap, dropdown);
      });
   });

   function positionCardMenu(button, wrap, dropdown) {
      const gap = 0;
      const margin = 10;
      const boundary = getCardMenuBoundary(wrap);

      const buttonRect = button.getBoundingClientRect();
      const wrapRect = wrap.getBoundingClientRect();
      const dropdownRect = dropdown.getBoundingClientRect();
      const boundaryRect = getCardMenuRect(boundary);

      let top = buttonRect.bottom - wrapRect.top + gap;
      let left = buttonRect.left - wrapRect.left;

      if (buttonRect.bottom + gap + dropdownRect.height > boundaryRect.bottom) {
         top = buttonRect.top - wrapRect.top - dropdownRect.height - gap;
      }

      if (buttonRect.left + dropdownRect.width > boundaryRect.right) {
         left = buttonRect.right - wrapRect.left - dropdownRect.width;
      }

      const minTop = boundaryRect.top - wrapRect.top + margin;
      const maxTop = boundaryRect.bottom - wrapRect.top - dropdownRect.height - margin;
      const minLeft = boundaryRect.left - wrapRect.left + margin;
      const maxLeft = boundaryRect.right - wrapRect.left - dropdownRect.width - margin;

      dropdown.style.top = clamp(top, minTop, maxTop) + 'px';
      dropdown.style.left = clamp(left, minLeft, maxLeft) + 'px';
   }

   function getCardMenuBoundary(element) {
      let parent = element.parentElement;

      while (parent && parent !== document.body) {
         if (hasCardMenuBoundary(parent)) {
            return parent;
         }

         parent = parent.parentElement;
      }

      return document.documentElement;
   }

   function hasCardMenuBoundary(element) {
      const style = window.getComputedStyle(element);
      const pattern = /^(auto|scroll|hidden|clip)$/;

      if (pattern.test(style.overflow)) {
         return true;
      }

      if (pattern.test(style.overflowX)) {
         return true;
      }

      if (pattern.test(style.overflowY)) {
         return true;
      }

      return false;
   }

   function getCardMenuRect(boundary) {
      if (boundary === document.documentElement) {
         return {
            top: 0,
            left: 0,
            right: window.innerWidth,
            bottom: window.innerHeight
         };
      }

      return boundary.getBoundingClientRect();
   }

   function clamp(value, min, max) {
      if (max < min) {
         return min;
      }

      return Math.min(Math.max(value, min), max);
   }

   function closeCardMenus(except) {
      document.querySelectorAll('.menu-dropdown').forEach(function (dropdown) {
         if (dropdown !== except) {
            dropdown.classList.remove('active');
         }
      });
   }

})();