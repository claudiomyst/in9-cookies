/**
 * IN9 Cookies - Admin JavaScript
 */

(function ($) {
    'use strict';

    $(function () {
        // Auto-trim Tracking IDs on paste or blur
        $('#in9_ga4_id, #in9_gtm_id, #in9_meta_pixel_id').on('blur', function () {
            var val = $(this).val().trim();
            $(this).val(val);
        });

        // Format GA4 input automatically
        $('#in9_ga4_id').on('input', function () {
            var val = $(this).val().trim().toUpperCase();
            $(this).val(val);
        });

        // Format GTM input automatically
        $('#in9_gtm_id').on('input', function () {
            var val = $(this).val().trim().toUpperCase();
            $(this).val(val);
        });

        // Numerical only for Meta Pixel
        $('#in9_meta_pixel_id').on('input', function () {
            var val = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(val);
        });
    });

})(jQuery);
