/**
 * Module - nodes
 * 
 * @usage:  load.script('/js/module/nodes.js', function(){});
 */
/*global $, load, ace*/
var nodes = (function() {

    var init = function(options) {

        var textarea = $('textarea[name="source"]').hide();
        var editor = ace.edit("source");
        editor.getSession().setUseWorker(false);
        editor.setTheme("ace/theme/eclipse");
        editor.getSession().setMode("ace/mode/php");

        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function() {
            textarea.val(editor.getSession().getValue());
        });

        $("#fileList").fileBrowser({
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
                    $('.remove-file').removeClass('hidden').data('file', folder + '/' + file);
                    $('.save-file').removeClass('hidden').data('file', folder + '/' + file);
                    $('.new-file').data('file', folder + '/' + file);

                    if (!folder) {
                        folder = '';
                    }
                    else {}

                    loadFile(folder + '/' + file);
                }
                else {
                    $('.remove-file').addClass('hidden');
                    $('.save-file').addClass('hidden');
                    $('button.new-file').data('folder', folder);
                }
                $('.sfbBreadCrumbs li').first().html('/var/www/html');
            }
        });

        function loadFile(path) {
            $.get('http://phive.free.lxd.systems/nodes/file/' + options.route_id + path,
                function(data, status) {
                    textarea.val(data);
                    editor.getSession().setValue(data);
                    $("#select").html(data);
                });
        }

        $("input[name='path']").on("change", function() {
            var input = $(this);

            $("#example1").fileBrowser("chgOption", {
                path: input.val()
            });
            $("#example1").fileBrowser("redraw");
        });

        $('button.remove-file').on('click', function(e) {
            e.preventDefault();
            if (!$(this).data('file')) {
                $(this).data('file', '');
            }
            $.get('http://phive.free.lxd.systems/nodes/file/' + options.route_id + $(this).data('file') + '?del=1',
                function(data, status) {
                    window.location = '/nodes/view/' + options.route_id;
                });
        });

        $('button.save-file').on('click', function(e) {
            e.preventDefault();
            if (!$(this).data('file')) {
                $(this).data('file', '');
            }
            $.post('http://phive.free.lxd.systems/nodes/file/' + options.route_id + $(this).data('file') + '?save=1', {
                    data: editor.getSession().getValue()
                },
                function(data, status) {
                    //window.location = '';
                });
        });

        $('button.new-file').on('click', function(e) {
            e.preventDefault();
            if (!$(this).data('folder')) {
                $(this).data('folder', '');
            }
            var new_file = $(this).data('folder') + '/' + $('#new-file-name').val();

            $.get('http://phive.free.lxd.systems/nodes/file/' + options.route_id + new_file,
                function(data, status) {
                    window.location = '/nodes/view/' + options.route_id;
                });
        });

        $('.sfbBreadCrumbs').first('li').html('/var/www/html');
    };

    return {
        init: init
    };
})();
