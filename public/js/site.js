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
   document.addEventListener("click", function(e) {
      const sidebar = e.target.closest("#sidebar-open");
      if (sidebar) {
         const overlap = document.getElementById('overlap-sidebar');
         if (overlap && typeof overlap.overlap === "function") {
            overlap.overlap('show', {
               empty: false
            });
         }
      }
   });
   document.addEventListener('DOMContentLoaded', function() {
      if (window.innerWidth < 992) {
         const row = document.querySelector('.row-carousel');
         if (row) {
            row.remove();
         }
      }
   });
})();