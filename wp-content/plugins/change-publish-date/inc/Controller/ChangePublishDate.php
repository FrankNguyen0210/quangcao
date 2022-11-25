<?php
namespace ChangePublishDate\Controller;

class ChangePublishDate{

    function __construct() {
        add_action ('admin_enqueue_scripts',array($this, 'diva_enqueue_scripts'));
        add_action( 'admin_menu', array($this,'add_admin_menu') );
        add_action ('wp_ajax_diva_change_post_publish_date',array($this,'diva_change_post_publish_date'));
        add_action('wp_ajax_nopriv_diva_change_post_publish_date', array($this,'diva_change_post_publish_date'));
        // add_action( 'admin_menu', array($this,'add_admin_submenu') );
    }

    public function diva_enqueue_scripts() {
        $plugin_url = plugin_dir_url( __FILE__ );
        
        wp_enqueue_style( 'style',  $plugin_url . "../../assets/css/main.css");
        wp_enqueue_script('diva_main',  $plugin_url . "../../assets/js/main.js", array(), null, true);
    }
    function add_admin_menu()
    {
        add_menu_page (
                'Change Publish Date', 
                'Change Publish Date', 
                'manage_options', 
                'change-publish-date', 
                array($this,'show_plugin_options'),
                '',
        );
    }
    
    function show_plugin_options()
    {
        require plugin_dir_path(__DIR__)."View/change-publish-date.php";
    }
    public function diva_change_post_publish_date() {
        $posts = isset($_POST['post']) ? $_POST['post'] : '';
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        foreach ($posts as $id) {
            wp_update_post(
                array(
                    'ID' => $id,
                    'post_date' => $date
                )
            );
        }
        $result = array (
            'result' => 'success',
        );
        wp_send_json_success($result);
        die();
    }
}