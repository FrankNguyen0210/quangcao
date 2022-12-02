<?php
/**
 * @package Diva Comment
 */
/*
Plugin Name: Diva Comment
Description: Comment trên các bài viết
Version: 1.0
Author: Cong Nguyen
*/

require __DIR__ . '/vendor/autoload.php';
// error_log(__DIR__);
use DivaComment\Controller\DivaComment;

new DivaComment();
?>