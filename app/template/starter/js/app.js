/**
 * Module - app
 */

/* global $ */

window.app = (function() {

    /**
     * Init construct
     */
    var init = function() {

        // event handlers
        events();
    };

    /**
     * Event handlers
     */
    var events = function() {

        /**
         * Bootstrap tooltips
         */
        $(document).find('[data-toggle="tooltip"]').tooltip();

    };

    return {
        init: init
    };
})();

$(document).ready(function() {
    window.app.init();
});
