
jQuery(document).ready(function($){
    var maxLength = 100;
    $(".show-read-more").each(function(){
        var myStr = $(this).text();
        if($.trim(myStr).length > maxLength){
            var newStr = myStr.substring(0, maxLength);
            var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
            $(this).empty().html(newStr);
            $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
            $(this).append('<span class="more-text">' + removedStr + '</span>');
        }
    });
    $(".read-more").click(function(){
        $(this).siblings(".more-text").contents().unwrap();
        $(this).remove();
    });
});

jQuery(document).ready(function ($) {
    $('.ai-tools-load-more').on('click', function () {
        var button = $(this);
        var page = button.data('page');
        var style = button.data('style');
        var showcat = button.data('showcat');
        var pricing = button.data('pricing');

        // AJAX call to fetch more AI tools
        $.ajax({
            url: ai_tools_ajax_object.ajax_url,
            type: 'post',
            data: {
                action: 'ai_tools_load_more',
                style: style,
                page: page,
                showcat: showcat,
                pricing: pricing
            },
            beforeSend: function () {
                button.text('Loading...');
            },
            success: function (response) {
                var listItems = $(response).find("*[data='tool']");
                if (listItems.length === 0) {
                    $('.ai-tools-load-more-btn').append('<p>No more tools.</p>');
                    button.remove()
                    return;
                } 

                $('#ai-tools').append(listItems);
                page++;
                button.data('page', page);
                button.text('Load More');
                $('.ai-tools-load-more-btn').append(button);

            },
            error: function () {
                button.text('Load More'); // Restore button text on error
            }
        });
    });
});

