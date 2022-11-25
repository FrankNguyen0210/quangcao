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

require __DIR__ . '/vendor/autoload.php';
define ("PLUGIN_DIR",plugin_dir_path( __DIR__ ));
use Ads\Controller\Ads;

new Ads();

?>