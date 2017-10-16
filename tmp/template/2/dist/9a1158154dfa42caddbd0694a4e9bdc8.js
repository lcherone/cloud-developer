$(function(){
    $('#ai-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
        method: 'POST',
            url: '/ai/ask',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.csrf) {
                    form.find('[name="csrf"]').val(response.csrf);
                }
                form.find('#input-query').prop('placeholder', response.value+'...').val('');
                
                $('#ai-response').html(response.result);
            },
            error: function(response) {
                $('#ai-response').html(response.toString());
            }
        });
    });
});