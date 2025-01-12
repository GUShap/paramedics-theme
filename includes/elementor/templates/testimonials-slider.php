<?php if (!defined('ABSPATH'))
    exit;

/**
 * 
 * Elementor Testimonials Slider Widget.
 * 
 * @var array $slides 
 * @var number $thumbs_per_view
 */
?>

<div class="testimonials-slider-wrapper">
    <div class="testimonials-main-slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide):
                $video_url = $slide['video']['url'];
                $video_title = $slide['video']['title'];
                ?>
                <div class="swiper-slide">
                    <div class="video-wrapper">
                        <video>
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        </video>
                        <a href="<?php echo $slide['link'] ?>" class="play-button"></a>

                    </div>
                    <div class="text-wrapper">
                        <h3><?php echo esc_html($slide['title']); ?></h3>
                        <p class="excerpt"><?php echo esc_html($slide['excerpt']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button swiper-button-next"></div>
        <div class="swiper-button swiper-button-prev"></div>
    </div>
    <div thumbsSlider="" class="testimonials-thumbs-slider swiper" data-view="<?php echo $thumbs_per_view ?>">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide): ?>
                <div class="swiper-slide">
                    <div class="text-wrapper">
                        <h3><?php echo esc_html($slide['title']); ?></h3>
                        <p class="course-number"><span>קפ״צ</span>
                            <span><?php echo esc_html($slide['course_number']); ?></span></p>
                        <p class="excerpt"><?php echo esc_html($slide['excerpt']); ?></p>
                    </div>
                    <div class="image-wrapper">
                        <img src="<?php echo esc_url($slide['main_image']); ?>"
                            alt="<?php echo esc_attr($slide['title']); ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>