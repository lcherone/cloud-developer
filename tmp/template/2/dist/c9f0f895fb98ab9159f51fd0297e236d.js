
$(document).ready(function() {
	/**
     * Module - cloud-scripts.js
     *
     * @usage:  load.script('/static/module.cloud-scripts.min.js', function(){});
     */

	/* global $, app, ace, bootbox */
	var cloud_scripts = (function() {

		/**
             * Table events,
             * @param object state - contains data passed from view
             */
		var table_events = function(options) {
			$(document).find('.remove_script').on('click', function(e) {
				e.preventDefault();

				//var tr = $(this).closest('tr');
				var id = $(this).data('id');
				var name = $(this).data('name');

				bootbox.confirm({
					message: "Are you sure you want to remove " + name + " deployer?",
					buttons: {
						confirm: {
							label: 'Yes',
							className: 'btn-success'
						},
						cancel: {
							label: 'No',
							className: 'btn-danger'
						}
					},
					callback: function(result) {
						if (result) {
							$.ajax({
								method: "POST",
								url: options.goto + '/delete/' + id,
								dataType: "html",
								data: {
									'csrf': options.csrf
								},
								beforeSend: function(jqXHR) {
									if (options.csrf) {
										jqXHR.setRequestHeader('X-CSRF-TOKEN', options.csrf);
										if ($(document).find('#csrf').length > 0) {
											$(document).find('#csrf').val(options.csrf);
										}
									}
									$.xhrPool.push(jqXHR);
								},
								complete: function(jqXHR) {
									options.csrf = jqXHR.getResponseHeader('X-CSRF-TOKEN');
									if ($(document).find('#csrf').length > 0) {
										$(document).find('#csrf').val(options.csrf);
									}
									var i = $.xhrPool.indexOf(jqXHR);
									if (i > -1) $.xhrPool.splice(i, 1);
								},
								success: function(response) {
									window.location = options.goto;
								},
								error: function(response) {
									window.location = options.goto;
								}
							});
						}
					}
				});
			});

		};

		var init = function(options) {
			table_events(options);
		};

		return {
			init: init
		};
	})();

	cloud_scripts.init(options);
});