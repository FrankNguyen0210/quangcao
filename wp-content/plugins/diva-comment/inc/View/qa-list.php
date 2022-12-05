<?php
    echo '<h1 class="wp-heading-inline"> Hỏi đáp </h1>';
    $paged = isset($_GET['paged']) ? $_GET['paged'] : 1; 
   
    $all_posts = new WP_Query(
        array (
            'post_type' => 'post',
            'posts_per_page' => 10,
            'paged' => $paged,
            'meta_query' => array (
                'relation' => 'AND',
                array (
                    'key' => 'comments_$_confirm',
                    'value' => '0',
                    'compare' => '='
                )
            ),
        )
    );
    echo '<pre>'; print_r ($all_posts); echo '</pre>';
    $total_page = $all_posts->max_num_pages;
    $big = 999999999;
?>
<form action="" id="diva-change-publish-date">
    <table class="wp-list-table widefat fixed striped table-view-list">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><input type="checkbox" id="select-all" name="post[]"></td>
                <td scope="col" id="title" class="manage-column column-title column-primary"><span>Title</span></td>
                <td scope="col" id="qa-num" class="manage-column column-qa-num"><span>Số câu hỏi chưa được duyệt</span></td>
            </tr>
        </thead>
        <tbody id="the-list">
            <?php
                if ($all_posts->have_posts()):
                    while ($all_posts->have_posts()):
                        $all_posts->the_post();
                        $comment = get_field('comments');
                        $count  = 0;
                        while (have_rows('comments')) : the_row();
                            $confirm = get_sub_field('confirm');
                            if (!$confirm) {
                                $count++;
                            }
                        endwhile;
                       
            ?>
            <tr id="post-<?php echo get_the_ID()?>">
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="cb-select-<?php echo get_the_ID();?>"><?php the_title();?></label>
                    <input type="checkbox" name="post[]" value="<?php echo get_the_ID();?>" class="post-check">
                </th>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                    <a href="<?php echo site_url();?>/wp-admin/post.php?post=<?php echo get_the_ID();?>&action=edit"><strong><?php the_title();?></strong></a>
                </td>
                <td class="date column-qa-num" data-colname="QA Num">
                    <?php 
                        echo $count;
                    ?>
                </td>
            </tr>
            <?php
                       
                    endwhile;
                endif;
                wp_reset_query();
            ?>
        </tbody>   
    </table>
</form>
<div class="search-pagination py-4 text-center">
    <?php
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),   
        'format' => '?paged=%#%',  
        'total' =>$total_page,
        'current' => max( 1,  $paged ),
        'prev_next' => true
    ) );
    
    ?>  
</div>