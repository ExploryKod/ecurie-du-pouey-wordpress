<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class Horses extends Widget_Base {

    public function get_name() {
        return 'chevaux';
    }

    public function get_title() {
        return 'Chevaux';
    }

    public function get_icon() {
        return 'eicon-featured-image';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_typography',
            [
                'label' => __( 'Typography', 'chevaux' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __( 'Typography', 'chevaux' ),
                'selector' => '{{WRAPPER}} .font-family-card',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('section_content', [
            'label' => 'Paramètres',
        ]);

        $this->add_control(
            'number_of_horses',
            [
                'label' => 'Nombre de chevaux maximum',
                'type' => Controls_Manager::NUMBER,
                'default' => -1,
            ]
        );

        $this->end_controls_section();
    }

    public function get_script_depends() {
        return ['hello-filter'];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $number_of_horses = $settings['number_of_horses'];

        $args = [
            'post_type' => 'pouey_horse',
            'posts_per_page' => $number_of_horses,
            'post_status' => 'publish',
        ];

        $horses = new \WP_Query($args);

        echo "<div class='horses-list'>";

        if ($horses->have_posts()) {
            while ($horses->have_posts()) {
                $horses->the_post();

                $horse_name = get_field('pouey-horse');
                $horse_image = get_field('image_du_cheval');
                $button_text = get_field('texte_du_bouton');
                $horse_link = get_permalink();
                $star_number = get_field('nombre_etoiles');

                // Gérer le champ image qui peut être un tableau ou une URL
                if (is_array($horse_image) && isset($horse_image['url'])) {
                    $horse_image = $horse_image['url'];
                } elseif (is_object($horse_image) && isset($horse_image->url)) {
                    $horse_image = $horse_image->url;
                }
                $horse_image = $horse_image ?: 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1';
                // S'assurer que c'est une chaîne
                $horse_image = is_scalar($horse_image) ? (string) $horse_image : 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1';
                
                // Convertir en string si nécessaire
                $horse_name = is_array($horse_name) ? (isset($horse_name['label']) ? $horse_name['label'] : '') : $horse_name;
                $horse_name = $horse_name ?: get_the_title();
                $horse_name = is_scalar($horse_name) ? (string) $horse_name : '';
                
                $button_text = is_array($button_text) ? (isset($button_text['label']) ? $button_text['label'] : '') : $button_text;
                $button_text = $button_text ?: 'Découvrir';
                $button_text = is_scalar($button_text) ? (string) $button_text : 'Découvrir';

                $horse_race = get_field('race');
                $horse_age = get_field('age_category');
                $horse_sex = get_field('sexe');
                $horse_status = get_field('statut_du_cheval');
                $horse_hair = get_field('couleur_de_la_robe');
                $horse_price = get_field('prix');
                $sportRace = get_field('sport_race');

                // Convertir les valeurs qui peuvent être des tableaux en chaînes
                $horse_race = is_array($horse_race) ? (isset($horse_race['label']) ? $horse_race['label'] : (isset($horse_race['value']) ? $horse_race['value'] : '')) : $horse_race;
                $horse_age = is_array($horse_age) ? (isset($horse_age['label']) ? $horse_age['label'] : (isset($horse_age['value']) ? $horse_age['value'] : '')) : $horse_age;
                $horse_sex = is_array($horse_sex) ? (isset($horse_sex['label']) ? $horse_sex['label'] : (isset($horse_sex['value']) ? $horse_sex['value'] : '')) : $horse_sex;
                $horse_hair = is_array($horse_hair) ? (isset($horse_hair['label']) ? $horse_hair['label'] : (isset($horse_hair['value']) ? $horse_hair['value'] : '')) : $horse_hair;
                $horse_price = is_array($horse_price) ? (isset($horse_price['label']) ? $horse_price['label'] : (isset($horse_price['value']) ? $horse_price['value'] : '')) : $horse_price;
                
                // Convertir en string pour éviter les erreurs
                $horse_race = is_scalar($horse_race) ? (string) $horse_race : '';
                $horse_age = is_scalar($horse_age) ? (string) $horse_age : '';
                $horse_sex = is_scalar($horse_sex) ? (string) $horse_sex : '';
                $horse_hair = is_scalar($horse_hair) ? (string) $horse_hair : '';
                $horse_price = is_scalar($horse_price) ? (string) $horse_price : '';
                $star_number = is_scalar($star_number) ? (int) $star_number : 0;

                echo "<div class='font-family-card card-wrapper " .
                    ($horse_status ? "selling " : "no-sell ") .
                    (!empty($sportRace) && isset($sportRace[0]) ? esc_attr($sportRace[0]) . " " : "") .
                    (!empty($sportRace) && isset($sportRace[1]) ? esc_attr($sportRace[1]) . " " : "") .
                    "' data-race='" . esc_attr($horse_race) . "' " .
                    "data-age='" . esc_attr($horse_age) . "' " .
                    "data-sex='" . esc_attr($horse_sex) . "' " .
                    "data-color='" . esc_attr($horse_hair) . "' " .
                    "data-price='" . esc_attr($horse_price) . "'>";

                echo "  <div class='card-image'>";
                echo "    <img src='" . esc_url($horse_image) . "' alt='" . esc_attr($horse_name) . "' />";
                echo "  </div>";
                echo "  <div class='card-content'>";
                echo "    <div class='horse-caption'>";
                echo "      <div class='title-wrapper'>";
                echo "        <h2 class='title'>" . esc_html($horse_name) . "</h2>";
                echo "        <div class='stars'>";
                for ($i = 0; $i < $star_number; $i++) {
                    echo "<span><i class='fa-solid fa-star'></i></span>";
                }
                echo "        </div>";
                echo "      </div>";
                echo "    </div>";
                echo "    <hr class='separator'>";
                echo "    <div class='horse-criterias'>";
                echo "      <ul class='criterias-list'>";
                echo "        <li class='list-item'>Race: <span class='list-value'>" . esc_html($horse_race) . "</span></li>";
                echo "        <li class='list-item'>Sexe: <span class='list-value'>" . esc_html($horse_sex) . "</span></li>";
                echo "      </ul>";
                echo "    </div>";
                echo "    <div class='card-button'>";
                echo "      <a href='" . esc_url($horse_link) . "'>" . esc_html($button_text) . "</a>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
            }
            wp_reset_postdata();
        }

        echo "</div>";
    }

    protected function _content_template() {
        ?>
        <# var numberOfHorses = settings.number_of_horses; #>
        <div class="horses-list">
            <#
            for (var i = 0; i < numberOfHorses; i++) {
            var horseImage = 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'; // Sample placeholder
            var horseName = 'Horse Name ' + (i + 1);
            var race = 'Sample Race';
            var sexe = 'Sample Sex';
            var stars = 5;
            #>
            <div class="card-wrapper" data-race="{{ race }}">
                <div class="card-image">
                    <img src="{{ horseImage }}" alt="{{ horseName }}" />
                </div>
                <div class="card-content">
                    <div class="horse-caption">
                        <div class="title-wrapper">
                            <h2 class="title">{{ horseName }}</h2>
                            <div class="stars">
                                <# for (var s = 0; s < stars; s++) { #>
                                <span><i class="fa-solid fa-star"></i></span>
                                <# } #>
                            </div>
                        </div>
                        <div class="horse-favoris">
                            <span><i class="fa-solid fa-heart"></i></span>
                        </div>
                    </div>
                    <hr class="separator">
                    <div class="horse-criterias">
                        <ul class="criterias-list">
                            <li class="list-item">Race: <span class="list-value">{{ race }}</span></li>
                            <li class="list-item">Sexe: <span class="list-value">{{ sexe }}</span></li>
                        </ul>
                    </div>
                    <div class="card-button">
                        <a href="#">Découvrir</a>
                    </div>
                </div>
            </div>
            <# } #>
        </div>
        <?php
    }
}
