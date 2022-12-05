<?php
    global $post;
    $postID = $post->ID;
?>
<h3 style="color: #1c68a8;">Hỏi đáp</h3>
<form action="" id="diva_comment_form" method="POST">
    <label for="comment_name">Tên: </label>
    <input type="text" name="comment_name" id="comment_name" required>
    <label for="comment_content">Nội dung câu hỏi: </label>
    <textarea name="comment_content" id="comment_content" cols="100" rows="5" required placeholder="Mời bạn để lại câu hỏi"></textarea>
    <button id="comment_submit_btn" data-url="<?php echo site_url(); ?>">Gửi</button>
    <input type="hidden" post-id="<?php echo $postID?>" id="post-id">
</form>
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
        <div class="tc-comment-wrapper">
            <div class="tc-comment-info">
                <span class="user_comment_name"><?php echo get_sub_field('user_comment_name')?></span>
                <span> - <?php echo get_sub_field('date_ask');?></span>
            </div>
            <div class="tc-comment-content">
                <?php echo get_sub_field('comment_content');?>
            </div>
            <div class="tc-comment-answer">
                <div class="tc-comment-answer-infor">
                    <span class="admin-name fw-bold"><?php echo get_sub_field('admin_name');?></span>
                    <span> - <?php echo get_sub_field('date_answer');?></span>
                </div>
                <?php echo get_sub_field('answer');?>
            </div>
        </div>
<?php
            endif;
        endwhile;
    endif;
?>
