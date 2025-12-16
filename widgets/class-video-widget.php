<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CEVW_Video_Widget extends Widget_Base {

    public function get_name() {
        return 'cevw_video';
    }

    public function get_title() {
        return 'Custom Video (MP4)';
    }

    public function get_icon() {
        return 'eicon-play';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_script_depends() {
        return [ 'cevw-video-widget' ];
    }

    public function get_style_depends() {
        return [ 'cevw-video-widget' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'visuals',
                [ 'label' => 'Внешний вид' ]
        );

        $this->add_control(
            'aspect_ratio',
            [
                'label' => 'Соотношение сторон',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '16/9' => '16:9',
                    '4/3'  => '4:3',
                    '1/1'  => '1:1',
                    '21/9' => '21:9',
                ],
                'default' => '16/9',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => 'Радиус границ',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .cevw-video-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .cevw-video-widget video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'content',
            [ 'label' => 'Видео' ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => 'MP4 файл',
                'type' => Controls_Manager::MEDIA,
                'media_types' => [ 'video' ],
            ]
        );

        $this->add_control(
            'poster',
            [
                'label' => 'Poster',
                'type' => Controls_Manager::MEDIA,
                'media_types' => [ 'image' ],
            ]
        );

        $this->add_control(
            'play_icon_svg',
            [
                'label' => 'SVG иконка Play',
                'description' => 'Загрузите SVG файл с иконкой play. Если не загруженно, будет использована стандартная иконка.',
                'type' => Controls_Manager::MEDIA,
                'media_types' => [ 'svg' ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $s = $this->get_settings_for_display();
        if ( empty( $s['video_url']['url'] ) ) return;

        $play_icon_content = '▶'; // стандартная иконка по умолчанию

        // Если загружена SVG иконка, используем её
        if ( ! empty( $s['play_icon_svg']['url'] ) ) {
            $svg_url = esc_url( $s['play_icon_svg']['url'] );
            $play_icon_content = '<img src="' . $svg_url . '" alt="Play" class="cevw-svg-icon">';
        }
        ?>

        <div class="cevw-video-widget">
            <video preload="metadata"
                   poster="<?php echo esc_url( $s['poster']['url'] ?? '' ); ?>"
                   style="
                        aspect-ratio: <?php echo esc_attr( $s['aspect_ratio'] ); ?>;
                        object-fit: cover;
                        ">
                <source src="<?php echo esc_url( $s['video_url']['url'] ); ?>"
                        type="video/mp4">
            </video>

            <button class="cevw-play-button" aria-label="Play video">
                <span class="cevw-play-icon"><?php echo $play_icon_content; ?></span>
            </button>
        </div>

        <?php
    }
}
