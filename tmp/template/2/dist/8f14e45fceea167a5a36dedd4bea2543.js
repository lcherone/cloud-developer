
$(document).ready(function() {

	if ($('#assigning-ip').length > 0) {
		assigningIp = setInterval(function(){
			$.ajax({
				url: '/api/server',
				method: 'POST',
				data: {
					'id': options.action,
					'action': 'ip'
				},
				dataType: 'json',
				cache: false,
				success: function (response, status, request) {
					if (response && response.length > 5) {
						$.xhrPool.abortAll();
						clearInterval(assigningIp);
						app.ajax_load('/servers/'+options.action, '.ajax-container');
					}
				},
				error: function() {
					$.xhrPool.abortAll();
					$('#assigning-ip').replaceWith('Error');
					clearInterval(assigningIp);
				}
			});
		}, 2000);
	}

	$(document).find('[href="#tab-console"]').on('click', function(e) {
		var src = $('#container-console').attr('data-src');
		if ($("#container-console iframe").attr("src") == "") {
			$("#container-console iframe").attr("src", src);
		}
		$("#ssh_frame iframe").height(400);
	});

	if (typeof Storage !== "undefined") {
		current_tab = sessionStorage.getItem("current-tab");
		if (current_tab == '#container-console') {
			var src = $('#container-console').attr('data-src');

			if ($("#container-console iframe").attr("src") == "") {
				$("#container-console iframe").attr("src", src);
			}
		}
	}

	$("#ssh_fullscreen").on('click', function(){
		if (!$("#ssh_wrapper").hasClass("ssh_wrap_fullscreen")) {
			$("#ssh_wrapper").addClass("ssh_wrap_fullscreen");
			$(".heading-text").html('&nbsp;');

			$(this).removeClass("btn-default").addClass('btn-danger');
			$(this).html("<i class=\"fa fa-window-minimize\" aria-hidden=\"true\"></i> Exit fullscreen");
			$(this).attr("title", "Minimize");

			height = $(window).height() - $("p#ssh_action").outerHeight() - ($("#ssh_frame").outerHeight() - $("#ssh_frame").height());
			$("#ssh_frame iframe").height(height);
			$(".nav-tabs").css('z-index', '-1');

			height = $("#ssh_frame").innerHeight();
			$(".ssh_wrap_fullscreen").height(height);
		} else{
			$(".heading-text").html('Console');
			$("#ssh_wrapper").removeClass("ssh_wrap_fullscreen");
			$(".nav-tabs").css('z-index', '2');
			$(this).removeClass("btn-danger").addClass('btn-default');
			$(this).html("<i class=\"fa fa-window-maximize\" aria-hidden=\"true\"></i> Fullscreen");
			$(this).attr("title", "Maximize console");

			$("#ssh_frame iframe").removeAttr("style");
			$("#ssh_frame").removeAttr("style");
			$("#ssh_wrapper").removeAttr("style");
		}
	});

	$(window).resize(function(){
		height = $(window).height() - $("p#ssh_action").outerHeight() - ($("#ssh_frame").outerHeight() - $("#ssh_frame").height());
		$(".ssh_wrap_fullscreen iframe").height(height);

		height = $("#ssh_frame").innerHeight();
		$(".ssh_wrap_fullscreen").height(height);
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

$(document).ready(function() {
	CountDownTimer(options.expirers, 'countdown_'+options.action);
});
