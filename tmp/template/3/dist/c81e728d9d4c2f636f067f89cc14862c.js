
$(function(){
    $('.github-login').off('click').on('click', function(e){
        $(this).addClass('disabled').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sign In With GitHub');
    });
});