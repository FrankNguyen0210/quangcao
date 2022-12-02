<?php
namespace DivaComment\Controller;

class DivaComment {
    function __construct() {
        add_action ('wp_enqueue_scripts',array($this, 'diva_comment_enqueue_scripts'));
        add_shortcode( 'test_shortcode', array($this,'render_comment_form') );
        add_action( 'wp_ajax_nopriv_diva_comment_submit', array($this, 'diva_comment_submit_func' ), 10,2);
        add_action( 'wp_ajax_diva_comment_submit', array($this, 'diva_comment_submit_func' ), 10,2);
    }
    public function diva_comment_enqueue_scripts() {
        $plugin_url = plugin_dir_url( __FILE__ );
        wp_enqueue_style( 'comment_style',  $plugin_url . "../../assets/css/main.css");
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
        wp_enqueue_script('diva_comment_main',  $plugin_url . "../../assets/js/main.js", array(), null, true);
        
    }
    public function render_comment_form() {
        require plugin_dir_path(__DIR__)."View/comment-form.php";
    }
    public function diva_comment_submit_func() {
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $content = isset($_POST['content']) ? $_POST['content'] : "";
        $postID = isset($_POST['postID'])? $_POST['postID']: "";
        $field_name = 'comments';
        $row = array (
            "user_comment_name" => $name,
            "comment_content" => $content,
            "answer" => "",
            "confirm" => 0,
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