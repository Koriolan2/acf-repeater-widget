<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ACF_Repeater_Widget_Style_Table {

    public static function register_table_styles( $widget ) {
        // Починаємо секцію для стилів таблиці
        $widget->start_controls_section(
            'table_style_section',
            [
                'label' => __( 'Стилі таблиці', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_template' => 'table',
                ],
            ]
        );

        // Вибір стилю кордонів для таблиці
        $widget->add_control(
            'table_border_style',
            [
                'label' => __( 'Тип кордонів таблиці', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'solid' => __( 'Суцільна', 'plugin-name' ),
                    'dashed' => __( 'Пунктирна', 'plugin-name' ),
                    'dotted' => __( 'Точкова', 'plugin-name' ),
                ],
                'default' => 'solid',
            ]
        );

        // Закінчуємо секцію для стилів таблиці
        $widget->end_controls_section();
    }
}
