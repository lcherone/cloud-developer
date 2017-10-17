/**
 * Module - nodes
 * 
 * @usage:  load.script('/js/module/module.js?developer', function(){});
 */
/*global $, load, ace*/
var module = (function() {

    var init = function(options) {

    };

    var _FontAwesomeList = function() {
        load.script('/js/lib/js-yaml.min.js?developer', function() {
            $.get('https://rawgit.com/FortAwesome/Font-Awesome/master/src/icons.yml', function(data) {
                var parsedYaml = jsyaml.load(data);
                var select = $('datalist#input-icon');
                var selected = select.data('value');

                $.each(parsedYaml.icons, function(index, icon) {
                    select.append('<option value="fa fa-' + icon.id + '"' + (selected === 'fa fa-' + icon.id ? ' selected' : '') + '></option>');
                });
            });
        });
    };

    var index = function(options) {
        $(document).find('.remove-module').off('click').on('click', function(e) {
            e.preventDefault();

            var elm = $(this);
            var url = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    elm.closest('tr').remove();
                }
            });
        });
    };

    var add = function() {
        //
        var textareaA = $('textarea[name="beforeload"]').hide(),
            editorA = ace.edit("beforeload"),
            editorSessionA = editorA.getSession();

        editorA.setTheme("ace/theme/eclipse");
        editorA.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionA.setUseWorker(false);
        editorSessionA.setMode("ace/mode/php");
        editorSessionA.setValue(textareaA.val());
        editorSessionA.on('change', function() {
            textareaA.val(editorSessionA.getValue());
        });

        $(document).find('.fetch-snippet').off('click').on('click', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            $.ajax({
                type: "GET",
                url: '/admin/snippet/get/' + id,
                dataType: "text",
                success: function(data) {
                    if (type == 'beforeload') {
                        editorSessionA.insert(editorA.getCursorPosition(), data);
                    }

                    if (type == 'body') {
                        editorSession.insert(editor.getCursorPosition(), data);
                    }

                    if (type == 'javascript') {
                        editorSessionJS.insert(editorJS.getCursorPosition(), data);
                    }

                    if (type == 'css') {
                        editorSession.insert(editor.getCursorPosition(), data);
                    }
                }
            });
        });
    };

    var edit = function() {
        //
        var textareaA = $('textarea[name="beforeload"]').hide(),
            editorA = ace.edit("beforeload"),
            editorSessionA = editorA.getSession();

        editorA.setTheme("ace/theme/eclipse");
        editorA.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionA.setUseWorker(false);
        editorSessionA.setMode("ace/mode/php");
        editorSessionA.setValue(textareaA.val());
        editorSessionA.on('change', function() {
            textareaA.val(editorSessionA.getValue());
        });

        $(document).find('.fetch-snippet').off('click').on('click', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            $.ajax({
                type: "GET",
                url: '/admin/snippet/get/' + id,
                dataType: "text",
                success: function(data) {
                    if (type == 'beforeload') {
                        editorSessionA.insert(editorA.getCursorPosition(), data);
                    }

                    if (type == 'body') {
                        editorSession.insert(editor.getCursorPosition(), data);
                    }

                    if (type == 'javascript') {
                        editorSessionJS.insert(editorJS.getCursorPosition(), data);
                    }

                    if (type == 'css') {
                        editorSession.insert(editor.getCursorPosition(), data);
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
