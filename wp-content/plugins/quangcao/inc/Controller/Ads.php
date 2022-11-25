<?php
namespace Ads\Controller;

class Ads{
    function __construct() {
        add_action ('wp_enqueue_scripts',array($this, 'diva_enqueue_scripts'));
        add_action ('init', array($this,'diva_register_post_type'));
        add_filter ('the_content', array($this, 'diva_add_ads'));
        add_action ('init', array($this, 'diva_group_add_option_page'));
        add_action( 'wp_ajax_nopriv_diva_ads_count_click', array($this, 'diva_ads_count_click' ), 10,2);
        add_action( 'wp_ajax_diva_ads_count_click', array($this, 'diva_ads_count_click' ), 10,2);

        add_filter('manage_quangcao_posts_columns',array($this, 'diva_columns_head'));
        add_action('manage_quangcao_posts_custom_column',array($this, 'diva_columns_content'), 10, 2);
    }
    public function diva_enqueue_scripts() {
        $plugin_url = plugin_dir_url( __FILE__ );
        if (is_single() && !is_admin()) {
            wp_enqueue_style( 'style',  $plugin_url . "../../assets/css/main.css");
            wp_deregister_script('jquery');
            wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
            wp_enqueue_script('ads_main',  $plugin_url . "../../assets/js/main.js", array(), null, true);
        }
    }
    public function diva_register_post_type() {
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
    public function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
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
    public function diva_render_ads_content ($ads_id) {
        $ads_type = get_field('ads_type', $ads_id);
        $link_ads = get_field('link_ads', $ads_id);
        $html = '';
        if ($ads_type == 'Content') {
            $title = get_the_title($ads_id);
            $post_thumnail_url = get_the_post_thumbnail_url($ads_id);
            $post_excerpts = get_the_excerpt($ads_id);
            $link_ads = get_field('link_ads', $ads_id);
            $html .= '<div class="ads_wrapper" post-id="'.$ads_id.'">';
            $html .= '<div class="ads_thumb"><img src="'.$post_thumnail_url.'"/></div>';
            $html .= '<div class="ads_content">';
            $html .= '<div class="ads_title">'.$title.'</div>';
            $html .= '<div>'.$post_excerpts.'</div>';
            $html .= '<a href="'.$link_ads.'" class="readmore_link">Click Xem</a>';
            $html .= '<span class="btn-close">X</span>';
            $html .= '</div></div>';
        }
        else {
            $ads_image = get_field('ads_image', $ads_id);
            $ads_image_mobile = get_field('ads_image_mobile', $ads_id);
            $html .= '<div class="ads_wrapper" post-id="'.$ads_id.'"><img src="'.$ads_image.'" class="ads_banner" /><img src="'.$ads_image_mobile.'" class="ads_banner_mobile"/><a href="'.$link_ads.'" class="readmore_link">Click Xem</a><span class="btn-close">X</span></div>';
        }
        return $html;
    }
    public function diva_add_ads ($content) { 
        global $post;
        $post_title = get_the_title($post->ID);
        $quangcao_args = array (
            'post_type' => 'quangcao',
            'orderby'        => 'rand',
            'posts_per_page' => -1, 
            'status'         => 'publish',
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
        if ($quangcaos) {
            $quangcao1 = $this->diva_render_ads_content($quangcaos[0]->ID);
            
            if (get_field('ads_display_type', 'option') == 'Default') {
                $content = $this->prefix_insert_after_paragraph($quangcao1, rand(1,$count_paragraphs/3), $content);
                if (isset($quangcaos[1])) {
                    $quangcao2 = $this->diva_render_ads_content($quangcaos[1]->ID);
                    $content = $this->prefix_insert_after_paragraph($quangcao2, rand($count_paragraphs/3 + 1,$count_paragraphs/2) , $content);
                }
                if (isset($quangcaos[2])) {
                    $quangcao3 = $this->diva_render_ads_content($quangcaos[2]->ID);
                    $content = $this->prefix_insert_after_paragraph($quangcao3, rand($count_paragraphs/2 + 1,($count_paragraphs -1)) , $content);
                }   
            }
            if(get_field('ads_display_type', 'option') == 'Order') {
                $ads1_position = get_field('ads_1_position', 'option');
                $content = $this->prefix_insert_after_paragraph($quangcao1, $ads1_position, $content);
                if (isset($quangcaos[1])) {
                    $quangcao2 = $this->diva_render_ads_content($quangcaos[1]->ID);
                    $ads2_position = get_field('ads_2_position', 'option');
                    $content = $this->prefix_insert_after_paragraph($quangcao2, $ads2_position , $content);
                }
                if (isset($quangcaos[2])) {
                    $quangcao3 = $this->diva_render_ads_content($quangcaos[2]->ID);
                    $ads3_position = get_field('ads_3_position', 'option');
                    $content = $this->prefix_insert_after_paragraph($quangcao3, $ads3_position , $content);
                }   
            }
            if (get_field('ads_display_type', 'option') == 'By Keyword') {
                $has_keyword = false;
                $list_ads = array();
                foreach($quangcaos as $quangcao) {
                    $quangcao_id = $quangcao->ID;
                    $ads_keyword = get_field('list_keyword', $quangcao_id);
                    if($ads_keyword) {
                        $list_keyword = explode(',', $ads_keyword);
                        foreach ($list_keyword as $keyword) {
                            $strpos = strpos(strtolower($post_title), strtolower($keyword));
                            if ($strpos != '') {
                                $has_keyword = true;
                            }
                        }
                        if ($has_keyword == true) {
                            $list_ads[] = $quangcao_id;
                        }
                    }
                }
                if (count($list_ads) > 0) {
                    $quangcao1 = $this->diva_render_ads_content($list_ads[0]);
                    $content = $this->prefix_insert_after_paragraph($quangcao1, rand(1,$count_paragraphs/3), $content);
                    if (isset($list_ads[1])) {
                        $quangcao2 = $this->diva_render_ads_content($list_ads[1]);
                        $content = $this->prefix_insert_after_paragraph($quangcao2, rand($count_paragraphs/3 + 1, $count_paragraphs/2) , $content);
                    }
                    if (isset($list_ads[2])) {
                        $quangcao3 = $this->diva_render_ads_content($list_ads[2]);
                        $content = $this->prefix_insert_after_paragraph($quangcao3, rand($count_paragraphs/2 + 1,($count_paragraphs -1)) , $content);
                    }   
                }
            }
        }   
        wp_reset_query();
        return $content;
    }
    public function diva_group_add_option_page() {
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
    function postview_set($postID) {
        $count_key = 'postview_number';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '1');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
    public function diva_ads_count_click() {
        $ads_id = isset($_POST['ads_id']) ? $_POST['ads_id'] : null;
        if ($ads_id != null) {
            $result = 'Success';
            $this->postview_set($ads_id);
        }
        else {
            $result = 'Failed';
        }
        wp_send_json_success($result);
        die();
    }
    public function diva_columns_head($default) {
        $default['view'] = 'View';
        return $default;
    }
    public function diva_columns_content($column_name, $postID) {
        if ($column_name == 'view') {
            if (metadata_exists('post', $postID, 'postview_number')) {
                  $view = get_post_meta($postID, 'postview_number')[0];
                  echo $view;  
            }
           
        }
    }
}

?>