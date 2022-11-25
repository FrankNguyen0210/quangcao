$(function(){
    $(document).ready(function(){
        $('.btn-close').on('click', function () {
            $(this).parents('.ads_wrapper').hide();
        });
        $('.readmore_link').on('click', function() {
            var ads_id = $(this).parents('.ads_wrapper').attr('post-id');
            var link = $(this).attr('href');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "../wp-admin/admin-ajax.php",
                data: {
                    ads_id : ads_id,
                    action: "diva_ads_count_click",
                },
                success: function (response) {
                    window.location.href = link;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
            return false;
        });
    });
});