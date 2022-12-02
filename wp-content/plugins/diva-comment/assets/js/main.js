jQuery(document).ready(function () {
    jQuery('#diva_comment_form').on('submit', function(e) {
        e.preventDefault();
        let name = jQuery(this).find('#comment_name').val();
        let content = jQuery(this).find('#comment_content').val();
        let postID = jQuery(this).find('#post-id').attr('post-id');
        let site_url = jQuery(this).find('#comment_submit_btn').attr("data-url");
        let admin_ajax_url = site_url + "/wp-admin/admin-ajax.php";
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: admin_ajax_url,
            data: {
                name : name,
                content : content,
                postID : postID,
                action: "diva_comment_submit",
            },
            success: function (response) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
        return false;
    })
});