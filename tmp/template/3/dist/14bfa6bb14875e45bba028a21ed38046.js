$(document).ready(function () {
	/* global $, app */
	port_forwards = (function() {

		/**
             * Modal form events,
             *  - add domain rows
             *  - add upstream rows
             * 
             * @param object state - contains data passed from view
             */
		var form_events = function(state) {

			/* ajax form post, closes modal or populates modal with response */
			$(document).find(".port-forward-form").on('submit', function(e) {
				e.preventDefault();

				var form = $(this);
				var btn = $(document.activeElement);

				if (form.has(btn)) {
					btn.addClass('disabled');
				}

				$.ajax({
					method: form.attr('method'),
					url: form.attr('action'),
					data: form.serialize(),
					dataType: 'html',
					success: function(response) {
						if (response == 'success') {
							$.ajax({
            					method: 'GET',
            					url: location.pathname.split('/').pop(),
            					dataType: 'html',
            					success: function(response) {
            						if ($('<div />').html(response).find('#port-forwards').length > 0) {
            							$(document).find('#port-forwards').replaceWith($('<div />').html(response).find('#port-forwards')[0]);
            							form_events(state);
            					    } 
            					},
            					error: function(){
            						
            					}
            				});
						} else if (response == 'Invalid CSRF token') {
							// invlid csrf token, user is double clicking submit button
						} else {
							// check port-forward-wrap is in response dom, could of been signed out..
							if ($('<div />').html(response).find('.port-forward-wrap').length > 0) {
								$(document).find('.port-forward-wrap').replaceWith($('<div />').html(response).find('.port-forward-wrap')[0]);    
							} else {
								app.ajax_load(location.pathname.split('/').pop(), '.ajax-container');
							}
						}
					},
					error: function(){
						if (form.has(btn)) {
							btn.off("submit");
							btn.addClass('btn-danger');
						}
					}
				});
			});
			
			$(document).find('.ajax-port-forward-link').on('click', function(e) {
                e.preventDefault();
                //
                var url = $(this).attr('href');
                // stop all timers
                timers.stopAll();
                //
                $.ajax({
					method: 'GET',
					url: url,
					dataType: 'html',
					success: function(response) {
						if ($('<div />').html(response).find('#port-forwards').length > 0) {
							$(document).find('#port-forwards').replaceWith($('<div />').html(response).find('#port-forwards')[0]);
							form_events(state);
					    } 
					},
					error: function(){
					}
				});
            });
		};

		var init = function(state) {
			form_events(state);
		};

		return {
			init: init
		};
	})();
});
