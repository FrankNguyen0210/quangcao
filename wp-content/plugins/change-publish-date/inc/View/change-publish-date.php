<?php
    echo '<h1 class="wp-heading-inline"> Change publish date </h1>';
    $paged = isset($_GET['paged']) ? $_GET['paged'] : 1; 
    $all_posts = new WP_Query(
        array (
            'post_type' => 'post',
            'posts_per_page' => 10,
            'paged' => $paged
        )
    );
    $total_page = $all_posts->max_num_pages;
    $big = 999999999;
?>
<form action="" id="diva-change-publish-date">
    <table class="wp-list-table widefat fixed striped table-view-list">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><input type="checkbox" id="select-all" name="post[]"></td>
                <td scope="col" id="title" class="manage-column column-title column-primary"><span>Title</span></td>
                <td scope="col" id="date" class="manage-column column-date"><span>Date</span></td>
            </tr>
        </thead>
        <tbody id="the-list">
            <?php
                if ($all_posts->have_posts()):
                    while ($all_posts->have_posts()):
                        $all_posts->the_post();
            ?>
            <tr id="post-<?php echo get_the_ID()?>">
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="cb-select-<?php echo get_the_ID();?>"><?php the_title();?></label>
                    <input type="checkbox" name="post[]" value="<?php echo get_the_ID();?>" class="post-check">
                </th>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                    <strong><?php the_title();?></strong>
                </td>
                <td class="date column-date" data-colname="Date">
                    <?php 
                        echo "<div>".get_post_status_object(get_post_status(get_the_ID()))->label."</div>";
                        echo get_the_date("j F , Y",get_the_ID()). " at ". get_post_time("H:i",get_the_ID());
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
    <div class="publish-date" style="padding: 20px 0px;">
        <label for="publish-date">Publish Date:</label>
        <input type="datetime-local" id="publish-date" name="publish-date" min="-0" max="<?php echo date("c");?>" required> 
        <input type="submit" value="Change" class="button">
    </div>
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