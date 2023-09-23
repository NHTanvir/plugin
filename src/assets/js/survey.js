jQuery(function($){
    $(document).on('click', '.tan-survey .notice-dismiss, .tan-survey .tan-survey-btn', function(e){
        $(this).prop('disabled', true);
        var $slug = $(this).closest('.tan-survey').data('slug')
        $.ajax({
            url: ajaxurl,
            data: { 'action' : $slug + '_survey', 'participate' : $(this).data('participate') },
            type: 'POST',
            success: function(ret) {
                $('#'+$slug+'-survey-notice').slideToggle(500)
            }
        })
    })
})