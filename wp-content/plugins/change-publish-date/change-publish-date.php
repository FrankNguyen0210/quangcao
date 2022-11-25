<?php
/**
 * @package Change Publish Date
 */
/*
Plugin Name: Change Publish Date
Description: Đổi ngày publish cho các bài viết
Version: 1.0
Author: Cong Nguyen
*/

require __DIR__ . '/vendor/autoload.php';
// error_log(__DIR__);
use ChangePublishDate\Controller\ChangePublishDate;

new ChangePublishDate();
?>