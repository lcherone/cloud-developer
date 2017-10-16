
$(document).ready(function () {
	/* global $, app */
	web_forwards = (function() {

		/**
             * Modal form events,
             *  - add domain rows
             *  - add upstream rows
             * 
             * @param object state - contains data passed from view
             */
		var form_events = function(state) {

			/* add domain rows */
			$(document).find('.input-multi-domains').on('click', '.add_row', function() {
				var html =
					'<div class="form-group-wrap input-domain domain input-domains-' + state.rows + '">' +
					'   <div class="input-group">' +
					'       <input type="text" name="domains[]" class="form-control" placeholder="">' +
					'       <span class="input-group-btn">' +
					'            <a href="javascript:void(0)" class="btn btn-sm btn-danger delete_row"><i class="fa fa-times"></i></a>' +
					'       </span>' +
					'   </div>' +
					'   <span class="help-block hidden"></span>' +
					'</div>';
				$(this).closest('div.form-group-wrap').after(html);

				state.rows++;
			});

			/* remove domain rows */
			$(document).find('.input-multi-domains').on('click', '.delete_row', function() {
				$(this).closest('div.form-group-wrap').remove();
				state.rows--;
			});

			/* add upstream row */
			$(document).find(".input-multi-upstreams").on('click', '.add_upstream_row', function() {
				var html =
					'<div class="form-group-wrap">' +
					'    <div class="input-group input-upstreams input-upstreams-' + state.upstream_rows + '" style="width:100%">' +
					'       <input type="text" name="upstreams[' + state.upstream_rows + '][ip]" id="input-upstreams-ip" class="form-control" placeholder="IP address..." style="width:65%">' +
					'       <input type="text" name="upstreams[' + state.upstream_rows + '][port]" id="input-upstreams-port" class="form-control" placeholder="Port..." style="width:35%">' +
					'       <span class="input-group-btn">' +
					'           <a href="javascript:void(0)" class="btn btn-sm btn-danger delete_row"><i class="fa fa-times"></i></a>' +
					'       </span>' +
					'   </div>' +
					'</div>';

				$(this).closest('div.form-group-wrap').after(html);
				state.upstream_rows++;
			});

			/* remove upstream rows */
			$(document).find(".input-multi-upstreams").on('click', '.delete_row', function() {
				$(this).closest('div.form-group-wrap').remove();
				state.upstream_rows--;
			});

			/* ajax form post, closes modal or populates modal with response */
			$(document).find(".web-forward-form").on('submit', function(e) {
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
            						if ($('<div />').html(response).find('#web-forwards').length > 0) {
            							$(document).find('#web-forwards').replaceWith($('<div />').html(response).find('#web-forwards')[0]);
            							form_events(state);
            					    } 
            					},
            					error: function(){
            						
            					}
            				});
						} else if (response == 'Invalid CSRF token') {
							// invlid csrf token, user is double clicking submit button
						} else {
							// check web-forward-wrap is in response dom, could of been signed out..
							if ($('<div />').html(response).find('.web-forward-wrap').length > 0) {
								$(document).find('.web-forward-wrap').replaceWith($('<div />').html(response).find('.web-forward-wrap')[0]);    
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
			
			$(document).find('.ajax-web-forward-link').on('click', function(e) {
                e.preventDefault();
                // stop all timers
                timers.stopAll();
                $.ajax({
					method: 'GET',
					url: $(this).attr('href'),
					dataType: 'html',
					success: function(response) {
						if ($('<div />').html(response).find('#web-forwards').length > 0) {
							$(document).find('#web-forwards').replaceWith($('<div />').html(response).find('#web-forwards')[0]);
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
