<?php
/**
 * @package Quangcao
 */
/*
Plugin Name: Diva Group Quang Cao
Description: Tạo quảng cáo cho bài viết
Version: 1.0
Author: Cong Nguyen
*/

add_action ('wp_enqueue_scripts', 'diva_enqueue_scripts');

function diva_enqueue_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );
    if (is_single() && !is_admin()) {
        wp_enqueue_style( 'style',  $plugin_url . "/assets/css/main.css");
    }
}

add_action ('init', 'diva_register_post_type');

function diva_register_post_type() {
    register_post_type( 'quangcao',
    // CPT Options
        array(
            'labels'         => array(
                'name'              => __( 'Quảng Cáo' ),
                'singular_name'     => __( 'Quảng Cáo' )
            ),
            'public'         => true,
            'has_archive'    => true,
            'rewrite'        => array('slug' => 'quangcao'),
            'show_in_rest'   => true,
            'supports'       => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  
        )
    );
}
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
  
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
  
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
      
    return implode( '', $paragraphs );
}
function diva_render_ads_content ($ads_id) {
    $ads_type = get_field('ads_type', $ads_id);
    $link_ads = get_field('$link_ads', $ads_id);
    $html = '';
    if ($ads_type == 'Content') {
        $title = get_the_title($ads_id);
        $post_thumnail_url = get_the_post_thumbnail_url($ads_id);
        $post_excerpts = get_the_excerpt($ads_id);
        $link_ads = get_field('link_ads', $ads_id);
        $html .= '<div class="ads_wrapper">';
        $html .= '<div class="ads_thumb"><img src="'.$post_thumnail_url.'"/></div>';
        $html .= '<div class="ads_content"><div class="ads_title">'.$title.'</div><div>'.$post_excerpts.'</div><a href="'.$link_ads.'">Click Xem ></a></div>';
        $html .= '</div>';
    }
    else {
        $ads_image = get_field('ads_image', $ads_id);
        $html .= '<div class="ads_wrapper"><img src="'.$ads_image.'" class="ads_banner"/></div>';
    }
    return $html;
}
function diva_add_ads ($content) { 
    global $post;
    $quangcao_args = array (
        'post_type' => 'quangcao',
        'orderby'        => 'rand',
        'posts_per_page' => 3, 
        'meta_query' => array(
            'relation' => 'OR', 
            array(
                'key' => 'posts_display',
                'value'   => serialize(strval($post->ID)), // Saved as string
                'compare' => 'LIKE'
            ),
        ),
    );
    $quangcaos = get_posts($quangcao_args);
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    $count_paragraphs = count($paragraphs);
    error_log($count_paragraphs);
    if ($quangcaos) {
        $quangcao1 = diva_render_ads_content($quangcaos[0]->ID);
       
        if (get_field('ads_display_type', 'option') == 'Default') {
            $content = prefix_insert_after_paragraph($quangcao1, rand(1,$count_paragraphs/3), $content);
            if (isset($quangcaos[1])) {
                $quangcao2 = diva_render_ads_content($quangcaos[1]->ID);
                $content = prefix_insert_after_paragraph($quangcao2, rand($count_paragraphs/3 + 1,$count_paragraphs/2) , $content);
            }
            if (isset($quangcaos[2])) {
                $quangcao3 = diva_render_ads_content($quangcaos[2]->ID);
                $content = prefix_insert_after_paragraph($quangcao3, rand($count_paragraphs/2 + 1,($count_paragraphs -1)) , $content);
            }   
        } else if(get_field('ads_display_type', 'option') == 'Order') {
            $ads1_position = get_field('ads_1_position', 'option');
            $content = prefix_insert_after_paragraph($quangcao1, $ads1_position, $content);
            if (isset($quangcaos[1])) {
                $quangcao2 = diva_render_ads_content($quangcaos[1]->ID);
                $ads2_position = get_field('ads_2_position', 'option');
                $content = prefix_insert_after_paragraph($quangcao2, $ads2_position , $content);
            }
            if (isset($quangcaos[2])) {
                $quangcao3 = diva_render_ads_content($quangcaos[2]->ID);
                $ads3_position = get_field('ads_3_position', 'option');
                $content = prefix_insert_after_paragraph($quangcao3, $ads3_position , $content);
            }   
        }
        
       
        
    }
    wp_reset_query();
    return $content;
}
add_filter ('the_content', 'diva_add_ads');

add_action ('init', 'diva_group_add_option_page');

function diva_group_add_option_page() {
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
            'page_title'    => 'Cấu hình website',
            'menu_title'    => 'Cấu hình website',
            'menu_slug'     => 'diva-theme-settings',
            'capability'    => 'edit_posts',
            'redirect'  => false
        ));
    }
}

?>