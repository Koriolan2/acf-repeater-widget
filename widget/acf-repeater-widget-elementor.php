<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Підключаємо файл стилів
require_once( plugin_dir_path( __FILE__ ) . '/acf-repeater-widget-styles.php' );

class ACF_Repeater_Widget_Elementor extends \Elementor\Widget_Base {

    public function get_name() {
        return 'acf_repeater_widget';
    }

    public function get_title() {
        return __( 'ACF Repeater Widget', 'plugin-name' );
    }

    public function get_categories() {
        return [ 'general' ];
    }

    // Реєстрація контенту
    protected function _register_controls() {
        // Контент
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Налаштування контенту', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Отримуємо всі доступні поля ACF типу Repeater
        $repeater_fields = $this->get_acf_repeater_fields();

        $this->add_control(
            'field_name',
            [
                'label' => __( 'Виберіть поле Repeater ACF', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $repeater_fields,
                'default' => '',
                'description' => __( 'Виберіть поле Repeater, яке хочете відобразити.', 'plugin-name' ),
            ]
        );

        // Вибір шаблону відображення
        $this->add_control(
            'display_template',
            [
                'label' => __( 'Шаблон відображення', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'numbered_list' => __( 'Нумерований список', 'plugin-name' ),
                    'bulleted_list' => __( 'Маркований список', 'plugin-name' ),
                    'table' => __( 'Таблиця', 'plugin-name' ),
                ],
                'default' => 'numbered_list',
            ]
        );

        $this->end_controls_section();

        // Виклик стилів через новий клас
        ACF_Repeater_Widget_Styles::register_styles_controls( $this );
    }

    // Отримання списку полів Repeater ACF
    private function get_acf_repeater_fields() {
        $fields = [];

        if ( function_exists( 'acf_get_field_groups' ) ) {
            $field_groups = acf_get_field_groups();

            foreach ( $field_groups as $group ) {
                $fields_in_group = acf_get_fields( $group['key'] );

                if ( $fields_in_group ) {
                    foreach ( $fields_in_group as $field ) {
                        if ( $field['type'] === 'repeater' ) {
                            $fields[ $field['name'] ] = $field['label'];
                        }
                    }
                }
            }
        }

        return $fields;
    }

    // Виведення контенту на Frontend
    protected function render() {
        $settings = $this->get_settings_for_display();
        $repeater_field_name = $settings['field_name'];
        $display_template = $settings['display_template'];
        $number_type = $settings['list_number_type']; // Отримуємо тип нумерації
        $shape = $settings['number_shape']; // Отримуємо вибір форми нумерації
    
        if ( function_exists( 'get_field' ) && !empty($repeater_field_name) ) {
            // Отримуємо значення Repeater поля
            $repeater_field = get_field( $repeater_field_name );
    
            if ( $repeater_field ) {
                echo '<div class="acf-repeater-widget">';
    
                if ( $display_template === 'numbered_list' ) {
                    echo '<ol style="list-style-type: ' . esc_attr( $number_type ) . ';">';
    
                    foreach ( $repeater_field as $index => $row ) {
                        // Додаємо клас залежно від вибору форми
                        $shape_class = $shape !== 'none' ? 'number-' . $shape : '';
    
                        echo '<li class="' . esc_attr( $shape_class ) . '">';
    
                        // Виводимо основний контент
                        echo '<span class="list-item-text">';
                        foreach ( $row as $value ) {
                            echo esc_html( $value );
                        }
                        echo '</span>';
                        echo '</li>';
                    }
    
                    echo '</ol>';
                }
    
                echo '</div>';
            } else {
                echo '<p>' . __( 'Немає даних для виведення', 'plugin-name' ) . '</p>';
            }
        } else {
            echo '<p>' . __( 'Поле Repeater не знайдено або не налаштоване.', 'plugin-name' ) . '</p>';
        }
    }
    
    
    /**
     * Генеруємо правильний номер на основі типу нумерації.
     */
    private function get_number_based_on_type( $index, $type ) {
        $index++; // Нумерація з 1
    
        switch ( $type ) {
            case 'upper-alpha':
                return chr( 64 + $index ); // A, B, C...
            case 'lower-alpha':
                return chr( 96 + $index ); // a, b, c...
            case 'upper-roman':
                return $this->to_roman( $index ); // Римські цифри (великі)
            case 'lower-roman':
                return strtolower( $this->to_roman( $index ) ); // Римські цифри (малі)
            default:
                return $index; // За замовчуванням числова нумерація
        }
    }
    
    /**
     * Конвертуємо число у римські цифри.
     */
    private function to_roman( $number ) {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];
    
        $returnValue = '';
        while ( $number > 0 ) {
            foreach ( $map as $roman => $int ) {
                if ( $number >= $int ) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
    
        return $returnValue;
    }
    
    
}
