/**
 * Confirm (Vanilla JavaScript)
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
 * @updated  June 25, 2026
 * @version  3.0
 */
Element.prototype.confirm = function(options) {
   const buttons = [];

   const settings = Object.assign({
      title: {
         text: 'Confirm',
         show: false
      },
      message: {
         text: 'Are you sure?'
      },
      top: null,
      right: null,
      bottom: null,
      left: null,
      actions: {
         confirm: {
            text: 'Confirm',
            callback: function() {}
         }
      }
   }, options || {});

   settings.title = Object.assign({
      text: 'Confirm',
      show: false
   }, settings.title || {});

   settings.message = Object.assign({
      text: 'Are you sure?'
   }, settings.message || {});

   const html = {
      overlay: '<div class="confirm-action-overlay"></div>',
      modal: '<div class="confirm-action-modal"></div>',
      header: '<div class="confirm-action-modal-header"></div>',
      title: '<div class="confirm-action-modal-title">Confirm</div>',
      content: '<div class="confirm-action-modal-content"></div>',
      message: '<div class="confirm-action-modal-message"></div>',
      actions: '<div class="confirm-action-modal-actions"></div>',
      button: '<button type="button" class="confirm-action-modal-button">Confirm</button>'
   };

   const components = {};

   for (let key in html) {
      const wrapper = document.createElement('div');
      wrapper.innerHTML = html[key];
      components[key] = wrapper.firstElementChild;
   }

   if (settings.title.show) {
      components.title.textContent = settings.title.text;

      if (settings.title.class) {
         components.title.classList.add(settings.title.class);
      }

      components.header.append(components.title);
   }

   components.message.innerHTML = settings.message.text
      .replace(/`(.*?)`/g, '<code>$1</code>')
      .replace(/\*(.*?)\*/g, '<strong>$1</strong>')
      .replace(/_(.*?)_/g, '<em>$1</em>')
      .replace(/~(.*?)~/g, '<del>$1</del>');

   const cancel = components.button.cloneNode(true);
   cancel.textContent = 'Cancelar';
   cancel.setAttribute('data-confirm-action-close', 'true');

   buttons.push(cancel);

   for (let key in settings.actions) {
      const action = settings.actions[key];
      const button = components.button.cloneNode(true);

      button.textContent = action.text;
      button.setAttribute('data-confirm-action-id', key);

      if (action.class) {
         button.classList.add(action.class);
      } else {
         button.classList.add('danger');
      }

      buttons.push(button);
   }

   components.actions.append(...buttons);
   components.content.append(components.message);
   components.modal.append(
      components.header,
      components.content,
      components.actions
   );

   const overlay = components.overlay;
   const modal = components.modal;

   document.body.appendChild(overlay);
   document.body.appendChild(modal);

   ['top', 'right', 'bottom', 'left'].forEach(function(position) {
      if (settings[position] !== null) {
         modal.style.setProperty('--confirm-' + position, settings[position] + 'px');
      }
   });

   if (
      settings.top !== null ||
      settings.right !== null ||
      settings.bottom !== null ||
      settings.left !== null
   ) {
      modal.style.setProperty('--confirm-transform', 'none');
   }

   function closeModal() {
      modal.remove();

      function handleTransitionEnd() {
         overlay.remove();
         overlay.removeEventListener('transitionend', handleTransitionEnd);
      }

      overlay.classList.remove('show');
      overlay.addEventListener('transitionend', handleTransitionEnd);
   }

   modal.querySelectorAll('[data-confirm-action-close]').forEach(function(button) {
      button.addEventListener('click', closeModal);
   });

   modal.querySelectorAll('[data-confirm-action-id]').forEach(function(button) {
      button.addEventListener('click', function(e) {
         e.preventDefault();

         const key = button.getAttribute('data-confirm-action-id');
         const action = settings.actions[key];

      if (action && typeof action.callback === 'function') {
         action.callback(closeModal);
      }

      closeModal();
   });
});

   overlay.offsetHeight;
   overlay.classList.add('show');

   return modal;
};