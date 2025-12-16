<?php
/**
 * Plugin Name: Custom Elementor Video Widget
 * Description: MP4 видео с кнопкой Play / Pause
 * Version: 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', function () {

    if ( ! did_action( 'elementor/loaded' ) ) return;

    add_action( 'elementor/widgets/register', function( $widgets_manager ) {
        require_once __DIR__ . '/widgets/class-video-widget.php';
        $widgets_manager->register( new \CEVW_Video_Widget() );
    });

    add_action( 'elementor/frontend/after_register_scripts', function() {

        wp_register_script(
            'cevw-video-widget',
            plugin_dir_url( __FILE__ ) . 'assets/video-widget.js',
            [ 'elementor-frontend' ],
            '0.1.0',
            true
        );

        wp_register_style(
            'cevw-video-widget',
            plugin_dir_url( __FILE__ ) . 'assets/video-widget.css',
            [],
            '0.1.0'
        );
    });
});
