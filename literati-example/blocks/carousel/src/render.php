<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$args = [
    'post_type' => 'literati_promotion',
    'posts_per_page' => 10,
];
$promotions = get_posts($args);
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
    <?php if (count($promotions)) { ?>
        <div class="splide" data-interval="<?php echo $attributes['transitionTimer']?>">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach( $promotions as $promotion) { ?>
                    <!-- add slide -->
                        <li class="splide__slide">
                            <article class="card">
                                <header>
                                    <h2><?php echo get_post_meta($promotion->ID, '_literati_promotion_header', true) ?></h2>
                                </header>
                                <img src="<?php echo get_the_post_thumbnail_url($promotion) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($promotion->ID), '_wp_attachment_image_alt', true); ?>">
                                <div class="content">
                                    <p><?php echo get_post_meta($promotion->ID, '_literati_promotion_text', true) ?></p>
                                </div>
                                <a class="carousel-button" href="<?php echo get_permalink($promotion->ID) ?>"><?php echo get_post_meta($promotion->ID, '_literati_promotion_button', true) ?></a>
                            </article>
                        </li>
                      <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php } else { ?>
      No Promotions
    <?php } ?>
</div>
