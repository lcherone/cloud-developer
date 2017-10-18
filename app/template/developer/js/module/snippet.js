/**
 * Module - snippet
 * 
 * @usage:  load.script('/js/module/snippet.js?developer', function(){});
 */
/*global $, load, ace*/
var snippet = (function() {

    var init = function(options) {

    };

    var index = function(options) {
        $(document).find('.remove-snippet').off('click').on('click', function(e) {
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

    var edit = function() {
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

    return {
        init: init,
        index: index,
        add: add,
        edit: edit
    };
})();
