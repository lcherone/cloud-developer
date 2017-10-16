
/* pub/sub helper */
(function () {
	var jq=$({});
	$.each({
		trigger: 'publish',
		on: 'subscribe',
		off: 'unsubscribe'
	}, function(k, v) {
		$[v] = function() {
			jq[k].apply(jq, arguments)
		};
	});
})(jQuery);

//
var operations = [];
var progression = [];

//
var updateProgress = function () {
	var trs = document.querySelectorAll('.table-body tr');
	for (var i=0; i<trs.length; i++) {
		var tr = trs[i];
		var pr = tr.querySelector('.tr-progress');
		if (pr) {
			pr.style.width = (tr.dataset.progress)+'%';
			pr.style.height = tr.clientHeight + 'px';
		}
	}
}

// poll server for operation id
$.subscribe('operation/id', function (e, data) {
	//
	$('#status_'+data.id).html('Queued');
	//
	operations['id_' + data.id] = setInterval(function() {
		$.ajax({
			url: '/api/server',
			method: 'POST',
			data: {
				'id': data.id,
				'action': 'operation'
			},
			dataType: 'json',
			cache: false,
			success: function (response, status, request) {
				if (response) {
					$.xhrPool.abortAll();
					clearInterval(operations['id_' + data.id]);
					data.elm[0].dataset.progress = 0;
					data.response = response;
					$.publish('operation/status', data);
				}
			},
			error: function() {
				$.xhrPool.abortAll();
				clearInterval(operations['id_' + data.id]);
				data.elm[0].dataset.progress = 100;
				updateProgress();
			}
		});
	}, 2000);
});

// poll server for operation status
$.subscribe('operation/status', function (e, data) {
	//
	$('#status_'+data.id).html('Building: 0%');
	//
	progression[data.id] = 0;
	//
	operations['status_' + data.id] = setInterval(function() {
		$.ajax({
			url: '/api/operation',
			method: 'POST',
			data: {
				'id': data.response.id,
				'server': data.id
			},
			dataType: 'json',
			cache: false,
			success: function(response, status, request) {
				if (response.id != data.response.id) {
					$.xhrPool.abortAll();
					setTimeout(function(){
						clearInterval(operations['status_' + data.id]);
						// reload server page
						app.ajax_load('/', '.ajax-container');
					}, 1500);
					data.elm[0].dataset.progress = 100;
					$('#status_'+data.id).html('Building: 100%');
					updateProgress();
					return;
				}

				/* running 103, finished, 200 */
				if (response.status_code == 103) {
					// update progression value
					if (progression[data.id] < 100) {
						progression[data.id] += Math.floor(Math.random() * (20 - 5 + 1)) + 5;
					}
					// protect from overflow
					if (progression[data.id] > 100) {
						progression[data.id] = 100;
					}

					data.elm[0].dataset.progress = progression[data.id];
				}
				else if (response.status_code == 400) {
					$.xhrPool.abortAll();
					setTimeout(function(){
						clearInterval(operations['status_' + data.id]);
					}, 1000);
					data.elm[0].dataset.progress = 100;
				}
				else {
					$.xhrPool.abortAll();
					setTimeout(function(){
						clearInterval(operations['status_' + data.id]);
						// reload container page
						app.ajax_load('/', '.ajax-container');
					}, 1000);
					data.elm[0].dataset.progress = 100;
				}

				$('#status_'+data.id).html('Building: '+data.elm[0].dataset.progress+'%');
				updateProgress();
			},
			error: function() {
				$.xhrPool.abortAll();
				setTimeout(function(){
					clearInterval(operations['status_' + data.id]);
				}, 1000);
				data.elm[0].dataset.progress = 100;
				updateProgress();
			}
		});
	}, 1500);
});

//
$(document).ready(function() {
	if ($('[data-progress]').length > 0) {
		$('[data-progress]').each(function(idx, elm) {
			$.publish('operation/id', {
				id:  $(this).data('id'),
				elm: $(this)
			});
		});
	}
});

//
$(document).ready(function() {
	/* global $, app, ace, bootbox */
	var cloud_servers = (function() {

		/**
         * Table events,
         * @param object state - contains data passed from view
         */
		var table_events = function(options) {
			$(document).find('.remove_server').off('click').on('click', function(e) {
				e.preventDefault();
				//
				var id = $(this).data('id');
				var name = $(this).data('name');
				//
				bootbox.confirm({
					message: "Are you sure you want to terminate " + name + "?<br><br><p class=\"text-center\"><strong class=\"text-danger\">This action cannot be undone!</strong></p>",
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
								url: '/server/delete/' + id,
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

	cloud_servers.init({
		'csrf': csrf,
		'goto': '/'
	});
});

function CountDownTimer(dt, id)
{
	var t = dt.split(/[- :]/);
	var end = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
	var second = 1000;
	var minute = second * 60;
	var hour = minute * 60;
	var day = hour * 24;
	var timer;

	function showRemaining() {
		var now = new Date();
		var distance = end - now;
		if (distance < 0) {
			clearInterval(timer);
			document.getElementById(id).innerHTML = 'EXPIRED!';
			return;
		}

		var days    = Math.floor(distance / day);
		var hours   = Math.floor((distance % day) / hour);
		var minutes = Math.floor((distance % hour) / minute);
		var seconds = Math.floor((distance % minute) / second);

		if (document.getElementById(id)) {
			document.getElementById(id).innerHTML = '';
			if (days != 0) {
				document.getElementById(id).innerHTML = days + 'days ';
			}
			if (hours != 0) {
				document.getElementById(id).innerHTML += hours + 'hrs ';
			}
			document.getElementById(id).innerHTML += minutes + 'mins ';
			document.getElementById(id).innerHTML += seconds + 'secs';
		}
	}
	timer = setInterval(showRemaining, 1000);
}
