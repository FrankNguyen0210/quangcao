<?php
namespace DivaComment\Controller;

class DivaComment {
    function __construct() {
        add_action( 'admin_menu', array($this,'add_admin_menu_qa') );
        add_action ('wp_enqueue_scripts',array($this, 'diva_comment_enqueue_scripts'));
        add_shortcode( 'test_shortcode', array($this,'render_comment_form') );
        add_action( 'wp_ajax_nopriv_diva_comment_submit', array($this, 'diva_comment_submit_func' ), 10,2);
        add_action( 'wp_ajax_diva_comment_submit', array($this, 'diva_comment_submit_func' ), 10,2);
        add_filter('posts_where', array($this,'my_posts_where'));
    }
    public function diva_comment_enqueue_scripts() {
        $plugin_url = plugin_dir_url( __FILE__ );
        wp_enqueue_style( 'comment_style',  $plugin_url . "../../assets/css/main.css");
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
        wp_enqueue_script('diva_comment_main',  $plugin_url . "../../assets/js/main.js", array(), null, true);
        
    }
    function my_posts_where( $where ) {
        $where = str_replace("meta_key = 'comments_$", "meta_key LIKE 'comments_$", $where);
        return $where;
    }
    function show_plugin_options()
    {
        require plugin_dir_path(__DIR__)."View/qa-list.php";
    }
    public function add_admin_menu_qa() {
        add_menu_page (
            'Hỏi đáp', 
            'Hỏi đáp', 
            'manage_options', 
            'qa-plugins', 
            array($this,'show_plugin_options'),
            '',
    );
    }
    public function render_comment_form() {
        require plugin_dir_path(__DIR__)."View/comment-form.php";
    }
    public function diva_comment_submit_func() {
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $content = isset($_POST['content']) ? $_POST['content'] : "";
        $postID = isset($_POST['postID'])? $_POST['postID']: "";
        $date_now = date('d/m/Y');
        $field_name = 'comments';
        $row = array (
            "user_comment_name" => $name,
            "comment_content" => $content,
            "answer" => "",
            "confirm" => 0,
            "date_ask" => $date_now
        );
        add_row($field_name,$row, $postID);
        $result = array (
            "result" => 'success',
        );
        wp_send_json_success($result);
        die();
    }
}
?>