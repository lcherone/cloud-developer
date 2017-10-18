/**
 * Module - page
 * 
 * @usage:  load.script('/js/module/page.js?developer', function(){});
 */
/*global $, load, ace*/
var page = (function() {

    var init = function(options) {

    };

    var index = function(options) {
        $(document).find('.toggle-hidden').off('click').on('click', function() {
            var toggle_hidden = $(this);
            var toggle_title = $('.toggle-title');
            var hidden_pages = $('.hidden-pages');
            var active_pages = $('.active-pages');

            toggle_hidden.html('<i class="fa fa-eye"></i> View Hidden');

            if (hidden_pages.hasClass('hidden')) {
                toggle_title.html('Completed Pages');
                toggle_hidden.html('<i class="fa fa-eye-slash"></i> Show New & Uncompleted');
                active_pages.addClass('hidden');
                hidden_pages.removeClass('hidden');
            }
            else {
                toggle_title.html('New & Uncompleted Pages');
                toggle_hidden.html('<i class="fa fa-eye"></i> Show Completed Pages');
                active_pages.removeClass('hidden');
                hidden_pages.addClass('hidden');
            }
        });

        $(document).find('.hide-page').off('click').on('click', function(e) {
            e.preventDefault();

            var elm = $(this);
            var url = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    var row = elm.closest('tr');
                    var cloned = row.clone(true, true);
                    $('#hidden-pages-body').prepend(cloned);

                    cloned.find('.hide-page').replaceWith('<a title="Mark Uncompleted" href="/admin/page/unhide/' + row.data('id') + '" class="btn btn-xs btn-default unhide-page"><i class="fa fa-pencil-square-o"></i></a>');
                    row.hide();
                }
            });
        });

        $(document).find('.unhide-page').off('click').on('click', function(e) {
            e.preventDefault();

            var elm = $(this);
            var url = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    var row = elm.closest('tr');
                    var cloned = row.clone(true, true);
                    $('#active-pages-body').prepend(cloned);

                    cloned.find('.unhide-page').replaceWith('<a title="Mark Completed" href="/admin/page/hide/' + row.data('id') + '" class="btn btn-xs btn-default hide-page"><i class="fa fa-check-square-o"></i></a>');
                    row.hide();
                }
            });
        });

        $(document).find('.remove-page').off('click').on('click', function(e) {
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
                        editorSession.insert(editorCSS.getCursorPosition(), data);
                    }
                }
            });
        });

        var textareaCSS = $('textarea[name="css"]').hide(),
            editorCSS = ace.edit("css"),
            editorSessionCSS = editorCSS.getSession();

        editorCSS.setTheme("ace/theme/eclipse");
        editorCSS.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionCSS.setUseWorker(false);
        editorSessionCSS.setMode("ace/mode/php");
        editorSessionCSS.setValue(textareaCSS.val());
        editorSessionCSS.on('change', function() {
            textareaCSS.val(editorSessionCSS.getValue());
        });

        var textareaJS = $('textarea[name="javascript"]').hide(),
            editorJS = ace.edit("javascript"),
            editorSessionJS = editorJS.getSession();

        editorJS.setTheme("ace/theme/eclipse");
        editorJS.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionJS.setUseWorker(false);
        editorSessionJS.setMode("ace/mode/php");
        editorSessionJS.setValue(textareaJS.val());
        editorSessionJS.on('change', function() {
            textareaJS.val(editorSessionJS.getValue());
        });

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

        var textarea = $('textarea[name="body"]').hide(),
            editor = ace.edit("body"),
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

    var edit = function() {
        //
        var textareaCSS = $('textarea[name="css"]').hide(),
            editorCSS = ace.edit("css"),
            editorSessionCSS = editorCSS.getSession();

        editorCSS.setTheme("ace/theme/eclipse");
        editorCSS.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionCSS.setUseWorker(false);
        editorSessionCSS.setMode("ace/mode/php");
        editorSessionCSS.setValue(textareaCSS.val());
        editorSessionCSS.on('change', function() {
            textareaCSS.val(editorSessionCSS.getValue());
        });

        //
        if ($('textarea[name="modulebeforeload"]').length != 0) {
            var textareaMBL = $('textarea[name="modulebeforeload"]').hide(),
                editorMBL = ace.edit("modulebeforeload"),
                editorSessionMBL = editorMBL.getSession();

            editorMBL.setTheme("ace/theme/eclipse");
            editorMBL.setReadOnly(true);
            editorMBL.setOptions({
                minLines: 20,
                maxLines: Infinity
            });

            editorSessionMBL.setUseWorker(false);
            editorSessionMBL.setMode("ace/mode/php");
            editorSessionMBL.setValue(textareaMBL.val());
            editorSessionMBL.on('change', function() {
                textareaMBL.val(editorSessionMBL.getValue());
            });
        }

        //
        $(document).find('.show-code').off('click').on('click', function() {
            var btn = $(this);
            var panel = $('.modulebeforeload-code');

            if (panel.hasClass('hidden')) {
                btn.html('<i class="fa fa-eye-slash"></i> Hide Code');
                panel.removeClass('hidden');
            }
            else {
                btn.html('<i class="fa fa-eye"></i> Show Code');
                panel.addClass('hidden');
            }
        });

        //
        $(document).find('.toggle-objects-table').off('click').on('click', function() {
            var btn = $(this);
            var panel = $('.objects-table');

            if (panel.hasClass('hidden')) {
                btn.html('<i class="fa fa-eye-slash"></i> Hide Objects');
                panel.removeClass('hidden');
            }
            else {
                btn.html('<i class="fa fa-eye"></i> Show Objects');
                panel.addClass('hidden');
            }
        });

        //
        $(document).find('.fetch-snippet').off('click').on('click', function() {
            var id = $(this).data('id'),
                type = $(this).data('type');

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
                        editorSessionCSS.insert(editor.getCursorPosition(), data);
                    }
                }
            });
        });

        //
        var textareaJS = $('textarea[name="javascript"]').hide(),
            editorJS = ace.edit("javascript"),
            editorSessionJS = editorJS.getSession();

        editorJS.setTheme("ace/theme/eclipse");
        editorJS.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionJS.setUseWorker(false);
        editorSessionJS.setMode("ace/mode/php");
        editorSessionJS.setValue(textareaJS.val());
        editorSessionJS.on('change', function() {
            textareaJS.val(editorSessionJS.getValue());
        });

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

        //
        var textarea = $('textarea[name="body"]').hide(),
            editor = ace.edit("body"),
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
            window.localStorage.setItem('preview-body', editorSession.getValue());
            textarea.val(editorSession.getValue());
        });
    };

    return {
        init: init,
        index: index,
        add: add,
        edit: edit
    };
})();
