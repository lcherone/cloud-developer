/**
 * Module - search
 * 
 * @usage:  load.script('/js/module/search.js?developer', function(){});
 */
/*global $, load, ace*/
var search = (function() {

    var init = function(options) {

    };

    var index = function(options) {
        $(document).find('.show-code').off('click').on('click', function() {
            var btn = $(this);
            var id = btn.data('id');
            var panel = $('#code-' + id);

            if (panel.hasClass('hidden')) {
                btn.html('<i class="fa fa-eye-slash"></i> Hide Code');
                panel.removeClass('hidden');
            }
            else {
                btn.html('<i class="fa fa-eye"></i> Show Code');
                panel.addClass('hidden');
            }
        });

        $('textarea.editor').each(function() {
            //
            var textarea = $(this),
                editor = ace.edit("editor-" + textarea.data('id')),
                editorSession = editor.getSession();

            editor.setTheme("ace/theme/eclipse");
            editor.setOptions({
                minLines: 1,
                maxLines: Infinity
            });
            editorSession.setUseWorker(false);
            editorSession.setMode("ace/mode/php");

            editor.findAll(new RegExp(textarea.data('term').replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")), {
                caseSensitive: false,
                regExp: true
            });
        });
    };

    return {
        init: init,
        index: index
    };
})();
