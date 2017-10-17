/**
 * Module - settings
 * 
 * @usage:  load.script('/js/module/settings.js?developer', function(){});
 */
/*global $, load, ace*/
var settings = (function() {

    var init = function(options) {

    };

    var index = function(options) {
        $(document).find('.remove-backup').off('click').on('click', function(e) {
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

        var textarea = $('textarea[name="composer"]').hide(),
            editor = ace.edit("composer"),
            editorSession = editor.getSession();

        editor.setTheme("ace/theme/eclipse");
        editor.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSession.setUseWorker(false);
        editorSession.setMode("ace/mode/json");
        editorSession.setValue(textarea.val());
        editorSession.on('change', function() {
            textarea.val(editorSession.getValue());
        });
    };

    return {
        init: init,
        index: index
    };
})();
