/**
 * Module - tasks
 * 
 * @usage:  load.script('/dist/module.tasks.min.js', function(){});
 */
var tasks = (function() {

    var view = function() {
        
        var textarea = $('textarea[name="source"]').hide();
        var editor = ace.edit("source");
        
        editor.getSession().setUseWorker(false);
        editor.setTheme("ace/theme/eclipse");
        editor.getSession().setMode("ace/mode/php");

        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function() {
            textarea.val(editor.getSession().getValue());
        });

        editor.setReadOnly(true);
        editor.setOptions({
            minLines: 10,
            maxLines: Infinity
        });
        editor.renderer.setShowGutter(false);
        editor.setShowPrintMargin(false);
        editor.setHighlightActiveLine(false);

        $.fn.editable.defaults.mode = 'inline';

        $('.editable-input').editable({
            showbuttons: false,
            ajaxOptions: {
                dataType: 'json'
            },
            success: function(response, newValue) {
                if (!response) {
                    return "Unknown error!";
                }

                if (response.success === false) {
                    return response.msg;
                }
            }
        });

        $('.repeats-select').editable({
            // prepend: "not selected",
            source: [{
                value: '0',
                text: 'No'
            }, {
                value: '1',
                text: 'Yes'
            }],
            ajaxOptions: {
                dataType: 'json'
            },
            success: function(response, newValue) {
                if (!response) {
                    return "Unknown error!";
                }

                if (response.success === false) {
                    return response.msg;
                }
            }
        });

        $("tr[class^='result-']").hide();
        $('.toggle-result').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $('.result-' + id).toggle();
        });
    };

    return {
        view: view
    };
})();
