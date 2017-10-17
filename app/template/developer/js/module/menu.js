/**
 * Module - nodes
 * 
 * @usage:  load.script('/js/module/menu.js?developer', function(){});
 */
/*global $, load, ace*/
var menu = (function() {

    var init = function(options) {
        
    };
    
    var _FontAwesomeList = function() {
        load.script('/js/lib/js-yaml.min.js?developer', function(){
            $.get('https://rawgit.com/FortAwesome/Font-Awesome/master/src/icons.yml', function(data){    
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
        $(document).find('.remove-menu').off('click').on('click', function(e){
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
    
    var add = function(){
        _FontAwesomeList();
    };

    var edit = function(){
        _FontAwesomeList();
    };

    return {
        init: init,
        index: index,
        add: add,
        edit: edit
    };
})();
