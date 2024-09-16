<?php
/**
 * Plugin Name: ACF Repeater Widget
 * Description: Плагін для віджета з ACF Repeater для Elementor.
 * Version: 1.0.0
 * Author: Ваше ім'я
 * Text Domain: acf-repeater-widget
 */

// Переконайтеся, що код виконується тільки через WordPress
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Вихід, якщо доступ напряму
}

// Перевірка наявності активного плагіна Elementor
function acf_repeater_widget_is_elementor_active() {
    return did_action( 'elementor/loaded' );
}

// Перевірка наявності активного плагіна ACF PRO
function acf_repeater_widget_is_acf_active() {
    return function_exists( 'acf' );
}

// Якщо Elementor і ACF не активні, припиняємо роботу плагіна
function acf_repeater_widget_check_dependencies() {
    if ( ! acf_repeater_widget_is_elementor_active() ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p>' . __( 'Для роботи ACF Repeater Widget необхідний активний плагін Elementor.', 'acf-repeater-widget' ) . '</p></div>';
        });
        return;
    }

    if ( ! acf_repeater_widget_is_acf_active() ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p>' . __( 'Для роботи ACF Repeater Widget необхідний активний плагін ACF PRO.', 'acf-repeater-widget' ) . '</p></div>';
        });
        return;
    }
}
add_action( 'plugins_loaded', 'acf_repeater_widget_check_dependencies' );

// Реєструємо і підключаємо CSS для віджета на фронтенді
function acf_repeater_widget_enqueue_styles() {
    // Перевіряємо, чи активний Elementor і чи є сторінки з його елементами
    if ( ! acf_repeater_widget_is_elementor_active() ) {
        return;
    }

    // Підключаємо CSS файл
    wp_enqueue_style(
        'acf-repeater-widget-css',
        plugin_dir_url( __FILE__ ) . 'assets/css/acf-repeater-widget.css',
        [],
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'acf_repeater_widget_enqueue_styles' );

// Реєструємо віджет для Elementor
function acf_repeater_widget_register_widget( $widgets_manager ) {
    if ( ! acf_repeater_widget_is_elementor_active() || ! acf_repeater_widget_is_acf_active() ) {
        return;
    }

    // Підключаємо необхідні файли віджета
    require_once( plugin_dir_path( __FILE__ ) . 'widget/acf-repeater-widget-elementor.php' );

    // Реєструємо сам віджет
    $widgets_manager->register( new \ACF_Repeater_Widget_Elementor() );
}
add_action( 'elementor/widgets/register', 'acf_repeater_widget_register_widget' );

// Функція ініціалізації, що підключає віджет
function acf_repeater_widget_init() {
    // Перевіряємо, чи активний Elementor, перш ніж реєструвати віджет
    if ( acf_repeater_widget_is_elementor_active() ) {
        add_action( 'elementor/widgets/widgets_registered', 'acf_repeater_widget_register_widget' );
    }
}
add_action( 'init', 'acf_repeater_widget_init' );

// Активуємо переклад
function acf_repeater_widget_load_textdomain() {
    load_plugin_textdomain( 'acf-repeater-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'acf_repeater_widget_load_textdomain' );
