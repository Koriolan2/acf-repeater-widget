<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ACF_Repeater_Widget_Style_Numbered_List {

    public static function register_numbered_list_styles( $widget ) {
        // Секція для загальних стилів нумерованого списку
        $widget->start_controls_section(
            'numbered_list_style_section',
            [
                'label' => __( 'Стилі нумерованого списку', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_template' => 'numbered_list',
                ],
            ]
        );

        // Тип нумерації (decimal, upper-alpha тощо)
        $widget->add_control(
            'list_number_type',
            [
                'label' => __( 'Тип нумерації', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'decimal' => __( 'Числа', 'plugin-name' ),
                    'upper-alpha' => __( 'Великі літери', 'plugin-name' ),
                    'lower-alpha' => __( 'Малі літери', 'plugin-name' ),
                    'upper-roman' => __( 'Римські цифри (великі)', 'plugin-name' ),
                    'lower-roman' => __( 'Римські цифри (малі)', 'plugin-name' ),
                ],
                'default' => 'decimal',
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget ol' => 'list-style-type: {{VALUE}};', // Стиль нумерації
                ],
            ]
        );

        // Колір нумерації
        $widget->add_control(
            'number_color',
            [
                'label' => __( 'Колір нумерації', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget ol li .number-shape' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .acf-repeater-widget ol li' => 'color: {{VALUE}};', // Для стандартної нумерації
                ],
            ]
        );

        // Типографіка для нумерації
        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'label' => __( 'Типографіка нумерації', 'plugin-name' ),
                'selector' => '{{WRAPPER}} .acf-repeater-widget ol li .number-shape, {{WRAPPER}} .acf-repeater-widget ol li',
            ]
        );

        // Відступи між елементами списку (зовнішні відступи)
        $widget->add_responsive_control(
            'list_item_margin',
            [
                'label' => __( 'Зовнішні відступи елемента списку', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget ol li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Відступ між нумерацією і текстом
        $widget->add_responsive_control(
            'number_text_spacing',
            [
                'label' => __( 'Відступ між нумерацією і текстом', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget ol li .number-shape' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Закінчуємо секцію для загальних стилів нумерації
        $widget->end_controls_section();

        // Секція для вибору форми нумерації (круг, квадрат тощо)
        $widget->start_controls_section(
            'number_shape_section',
            [
                'label' => __( 'Форма нумерації', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Вибір форми (none, circle, square, rounded)
        $widget->add_control(
            'number_shape',
            [
                'label' => __( 'Форма для нумерації', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __( 'Без форми', 'plugin-name' ),
                    'circle' => __( 'Круг', 'plugin-name' ),
                    'square' => __( 'Квадрат', 'plugin-name' ),
                    'rounded' => __( 'Коло', 'plugin-name' ),
                ],
                'default' => 'none',
            ]
        );

        // Закінчуємо секцію для вибору форми нумерації
        $widget->end_controls_section();

        // Умовне відображення секції для налаштування форми (показується тільки якщо вибрана форма)
        $widget->start_controls_section(
            'number_shape_style_section',
            [
                'label' => __( 'Налаштування форми', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'number_shape!' => 'none', // Показується тільки якщо вибрана форма
                ],
            ]
        );

        // Колір фону для фігури
        $widget->add_control(
            'number_shape_background_color',
            [
                'label' => __( 'Колір фону фігури', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget ol li .number-shape' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Внутрішні відступи (padding)
        $widget->add_responsive_control(
            'number_shape_padding',
            [
                'label' => __( 'Внутрішні відступи', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .acf-repeater-widget ol li .number-shape' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Товщина та стиль кордонів (border)
        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'number_shape_border',
                'label' => __( 'Кордон фігури', 'plugin-name' ),
                'selector' => '{{WRAPPER}} .acf-repeater-widget ol li .number-shape',
            ]
        );

        // Закінчуємо секцію для налаштування форми
        $widget->end_controls_section();
    }
}
