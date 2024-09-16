<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ACF_Repeater_Widget_Style_Bulleted_List {

    public static function register_bulleted_list_styles( $widget ) {
        // Починаємо секцію для стилів маркованого списку
        $widget->start_controls_section(
            'bulleted_list_style_section',
            [
                'label' => __( 'Стилі маркованого списку', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_template' => 'bulleted_list',
                ],
            ]
        );

        // Тип маркування для маркованого списку
        $widget->add_control(
            'list_style_type',
            [
                'label' => __( 'Тип маркування списку', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'disc' => __( 'Круг', 'plugin-name' ),
                    'circle' => __( 'Порожнє коло', 'plugin-name' ),
                    'square' => __( 'Квадрат', 'plugin-name' ),
                    'icon' => __( 'Власний маркер', 'plugin-name' ),
                ],
                'default' => 'disc',
            ]
        );

        // Вибір іконки для власного маркера
        $widget->add_control(
            'custom_marker_icon',
            [
                'label' => __( 'Виберіть іконку для маркера', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'list_style_type' => 'icon',
                ],
            ]
        );

        // Закінчуємо секцію для стилів маркованого списку
        $widget->end_controls_section();
    }
}
