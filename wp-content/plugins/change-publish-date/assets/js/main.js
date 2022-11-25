jQuery(document).ready(function () {
   jQuery ('#diva-change-publish-date').on('submit', function(e) {
     e.preventDefault();
        var post = [];
        jQuery('.post-check:checked').each(function(i) {
          post[i] = jQuery(this).val();
        });
        var date = jQuery('#publish-date').val();
        var today = new Date();
        if (new Date(date).getTime() > today.getTime()) {
          alert('Ngày được chọn phải nhỏ hoặc bằng ngày hiện tại');
          return false;
        }
        if (post.length == 0) {
          alert('Vui lòng chọn bài viết cần thay đổi');
          return false;
        }
        jQuery.ajax({
          type: 'POST',
          url : '../wp-admin/admin-ajax.php',
          data : {
               post: post,
               date: date,
               action: 'diva_change_post_publish_date'
          },
          success: function(response) {
               location.reload();
          },
          error: function(err) {
               myJSON = JSON.stringify(err);
               console.log("There was an error: " + myJSON);
          }
        })
   });
    
});