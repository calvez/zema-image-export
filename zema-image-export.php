<?php

/**
 * Plugin Name:     Zema Image Export
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     zema-image-export
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Zema_Image_Export
 */

// Your code starts here.

/**
 * Implements example command.
 */
class Zema_export
{

    function export()
    {
        $args = array(
            'numberposts' => 10,
            'post_type'   => 'product'
        );

        $products = get_posts($args);
        foreach ($products as $key => $product) {
            $url = get_the_post_thumbnail_url($product->ID, 'medium');
            $uploads   = wp_upload_dir();
            $file_path = str_replace($uploads['baseurl'], $uploads['basedir'], $url);
            $ext = pathinfo($file_path, PATHINFO_EXTENSION);
            WP_CLI::success($ext);
            WP_CLI::success($file_path);

            $target = $uploads['basedir'] . '/exported/' . $product->ID . '.' . $ext;
            shell_exec("cp $file_path  $target ");
            WP_CLI::success($product->post_title . ' Image exported');
        }
    }
}
if (class_exists('WP_CLI')) {
    WP_CLI::add_command('zema', 'Zema_export');
}
