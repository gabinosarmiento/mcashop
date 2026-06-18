/**
 * Vanilla listeners for mcashop.mx
 *
 * Script for display items and sidebar open function
 *
 * @property  mcashop.mx
 * @author    Gabino Sarmiento
 * @updated   March 7, 2026
 */
(function() {
   document.addEventListener('DOMContentLoaded', function() {
      if (window.innerWidth < 992) {
         const row = document.querySelector('.row-carousel');
         if (row) {
            row.remove();
         }
      }
   });
})();