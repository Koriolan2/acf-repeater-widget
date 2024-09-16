<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Підключаємо стилі для кожного шаблону
require_once( plugin_dir_path( __FILE__ ) . '/acf-repeater-widget-style-bulleted-list.php' );
require_once( plugin_dir_path( __FILE__ ) . '/acf-repeater-widget-style-numbered-list.php' );
require_once( plugin_dir_path( __FILE__ ) . '/acf-repeater-widget-style-table.php' );

class ACF_Repeater_Widget_Styles {

    // Метод для реєстрації всіх стилів
    public static function register_styles_controls( $widget ) {
        // Глобальна секція стилів
        $widget->start_controls_section(
            'global_styles_section',
            [
                'label' => __( 'Основні стилі', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Вирівнювання
        $widget->add_responsive_control(
            'alignment',
            [
                'label' => __( 'Вирівнювання', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Ліворуч', 'plugin-name' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Центр', 'plugin-name' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Праворуч', 'plugin-name' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Колір тексту
        $widget->add_control(
            'font_color',
            [
                'label' => __( 'Колір тексту', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .acf-repeater-widget ol' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .acf-repeater-widget ul' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .acf-repeater-widget table' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Типографіка
        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Типографіка', 'plugin-name' ),
                'selector' => '{{WRAPPER}} .acf-repeater-widget',
            ]
        );

        // Закінчуємо глобальну секцію стилів
        $widget->end_controls_section();

        // Стилі для маркованого списку
        ACF_Repeater_Widget_Style_Bulleted_List::register_bulleted_list_styles( $widget );

        // Стилі для нумерованого списку
        ACF_Repeater_Widget_Style_Numbered_List::register_numbered_list_styles( $widget );

        // Стилі для таблиці
        ACF_Repeater_Widget_Style_Table::register_table_styles( $widget );
    }
}
