
Dropzone.autoDiscover = false;

$(document).ready(function () {

	/**
     * Module - cloud-scripts.js
     *
     * @usage:  load.script('/static/module.cloud-scripts.min.js', function(){});
     */

	/* global $, app, ace, bootbox */
	var cloud_scripts = (function() {
		var image_upload = function(){
			try {
				/**
                 * Image upload
                 */
				$("#imgupload").dropzone({
					maxFiles:1,
					maxFilesize: 5, //mb
					acceptedFiles: "image/*",
					init: function() {
						this.on("maxfilesexceeded", function(file) {
							this.removeAllFiles();
							this.addFile(file);
						});
					},
					url: "/deployers/image-upload",
					addRemoveLinks: true,
					accept: function(file, done){
						$('.dropzone').css('background', '#f9f9f9');
						var re = /(?:\.([^.]+))?$/;
						var ext = re.exec(file.name)[1];
						ext = ext.toUpperCase();
						if (ext == "JPG" || ext == "JPEG" || ext == "PNG") {
							done();
						}else { 
							file.previewElement.classList.add("dz-error");
							this.defaultOptions.error(file, 'PNG or JPG files only.');  
						}
					},
					success: function(file, response){
						$('.dropzone').css('background', '#f9f9f9');
						file.previewElement.classList.add("dz-success");
						$('form #logo').val(response.image);
					},
					error: function (file, response) {
						file.previewElement.classList.add("dz-error");
					}
				});
			} catch(err) {
				location.reload();
			}
		};

		/**
         *
         */
		var source_editor = function(options) {
			if ($('#source').length > 0) {
				var textarea = $('textarea[name="source"]').hide();
				var editor = ace.edit("source");
				editor.getSession().setUseWorker(false);
				editor.setTheme("ace/theme/eclipse");
				editor.getSession().setMode("ace/mode/sh");
				editor.setOptions({
					minLines: 20,
					maxLines: Infinity
				});

				editor.getSession().setValue(textarea.val());
				editor.getSession().on('change', function() {
					textarea.val(editor.getSession().getValue());
				});
			}
		};

		/**
         * Form events,
         * @param object state - contains data passed from view
         */
		var form_events = function(options) {

		};

		var init = function(options) {
			form_events(options);
			source_editor(options);
			image_upload();
		};

		return {
			init: init
		};
	})();

	cloud_scripts.init(options);

});
