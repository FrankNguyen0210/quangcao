<?php
    global $post;
    $postID = $post->ID;
?>
<?php
    $comment = get_field('comments');
    if (have_rows('comments')) :
        while (have_rows('comments')) : the_row();
            $name = get_sub_field('user_comment_name');
            $content = get_sub_field('comment_content');
            $answer = get_sub_field('answer');
            $confirm = get_sub_field('confirm');
            if ($confirm) :
?>
    
<?php
            endif;
        endwhile;
    endif;
?>
<form action="" id="diva_comment_form" method="POST">
    <label for="comment_name">Tên: </label>
    <input type="text" name="comment_name" id="comment_name" required>
    <label for="comment_content">Nội dung Câu hỏi: </label>
    <textarea name="comment_content" id="comment_content" cols="100" rows="10" required></textarea>
    <button id="comment_submit_btn" data-url="<?php echo site_url(); ?>">Gửi</button>
    <input type="hidden" post-id="<?php echo $postID?>" id="post-id">
</form>