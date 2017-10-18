/**
 * Module - template
 * 
 * @usage:  load.script('/js/module/template.js?developer', function(){});
 */
/*global $, load, ace, Dropzone*/
var template = (function() {

    var init = function(options) {

    };

    var index = function(options) {

    };

    var add = function(options) {
        var textarea = $('textarea[name="source"]').hide(),
            editor = ace.edit("source"),
            editorSession = editor.getSession();

        editor.setTheme("ace/theme/eclipse");
        editor.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSession.setUseWorker(false);
        editorSession.setMode("ace/mode/php");
        editorSession.setValue(textarea.val());
        editorSession.on('change', function() {
            textarea.val(editorSession.getValue());
        });
    };

    var edit = function(options) {
        $('.fmBreadCrumbs').first('li').html('/var/www/html');
        $('iframe#template-preview').attr('src', $('iframe#template-preview').data('src'));

        var myDropzone = new Dropzone("form.dropzone", {
            url: "/admin/template/upload-file/" + options.route_id
        });

        var textarea = $('textarea[name="source"]').hide();
        var editor = ace.edit("source");
        editor.getSession().setUseWorker(false);
        editor.setTheme("ace/theme/eclipse");
        editor.setOptions({
            minLines: 20,
            maxLines: Infinity
        });
        editor.getSession().setMode("ace/mode/php");

        var whichForm = 'save-details';
        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function() {
            whichForm = 'save-file';
            textarea.val(editor.getSession().getValue());
        });

        load.script('/js/filebrowser.js', function() {
            $(document).find("#fileList").fileBrowser({
                json: options.files,
                path: '/',
                view: 'details',
                select: false,
                breadcrumbs: true,
                onSelect: function(obj, file, folder, type) {
                    $('button.new-file').data('folder', folder);
                },
                onOpen: function(obj, file, folder, type) {
                    if (type == 'file') {
                        if (folder == '/') {
                            folder = '';
                        }

                        $('.remove-file').removeClass('hidden').data('file', folder + '/' + file);
                        $('.save-file').removeClass('hidden').data('file', folder + '/' + file);
                        $('.new-file').data('file', folder + '/' + file);

                        $('.dropzone').addClass('hidden');

                        var path = folder + '/' + file;

                        if (path.charAt(0) == "/") path = path.substr(1);

                        $.get('/admin/template/file/' + options.route_id + '/' + path, function(data, status) {
                            textarea.val(data);
                            editor.getSession().setValue(data);
                            $("#select").html(data);
                        });
                    }
                    else {
                        if (folder == '/') {
                            folder = '';
                        }

                        myDropzone.options.url = '/admin/template/upload-file/' + options.route_id + folder;

                        $('.dropzone').removeClass('hidden');
                        $('.remove-file').addClass('hidden');
                        $('.save-file').addClass('hidden');
                        $('button.new-file').data('folder', folder);
                    }
                    $('.fmBreadCrumbs li').first().html('/var/www/html');
                }
            });
        });

        $(document).find("#input-name").off('keyup').on('keyup', function() {
            whichForm = 'save-details';
        });

        $(document).find("input[name='path']").off('change').on('change', function() {
            var input = $(this);

            $("#example1").fileBrowser("chgOption", {
                path: input.val()
            });
            $("#example1").fileBrowser("redraw");
        });

        $(document).find("button.remove-file").off('click').on('click', function(e) {
            e.preventDefault();
            if (!$(this).data('file')) {
                $(this).data('file', '');
            }
            $.get('/admin/template/file/' + options.route_id + $(this).data('file') + '?del=1', function(data, status) {
                window.location = '/admin/template/edit/' + options.route_id;
            });
        });

        $(document).find("button.save-file").off('click').on('click', function(e) {
            e.preventDefault();

            var btn = $(this);

            if (!btn.data('file')) {
                btn.data('file', '');
            }

            var file = btn.data('file');

            if (file.charAt(0) == "/") {
                file = file.substr(1);
            }

            $.post('/admin/template/file/' + options.route_id + '/' + file + '?save=1', {
                data: editor.getSession().getValue()
            }, function(data, status) {
                $('#template-preview').attr("src", $('#template-preview').attr("src"));
                $('#file-saved').hide().removeClass('hidden').fadeIn(300, function() {
                    var elm = $(this);
                    setTimeout(function() {
                        elm.fadeOut(1000, function() {
                            elm.addClass('hidden');
                        });
                    }, 1700);
                });
            });
        });

        $(document).find("button.new-file").off('click').on('click', function(e) {
            e.preventDefault();
            if (!$(this).data('folder')) {
                $(this).data('folder', '');
            }
            var new_file = $(this).data('folder') + '/' + $('#new-file-name').val();

            $.get('/admin/template/file/' + options.route_id + new_file, function(data, status) {
                window.location = '/admin/template/edit/' + options.route_id;
            });
        });

        $(document).off('keydown').on('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        console.log(whichForm);
                        $('.' + whichForm).trigger('click');
                        break;
                }
            }
        });

        $(document).find(".fetch-snippet").off('click').on('click', function(e) {
            var id = $(this).data('id');
            var type = $(this).data('type');
            $.ajax({
                type: "GET",
                url: '/admin/snippet/get/' + id,
                dataType: "text",
                success: function(data) {
                    if (type == 'template') {
                        editor.getSession().insert(editor.getCursorPosition(), data);
                    }
                }
            });
        });
    };

    return {
        init: init,
        index: index,
        add: add,
        edit: edit
    };
})();
