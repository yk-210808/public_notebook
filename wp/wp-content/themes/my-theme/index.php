<?php
require_once(get_template_directory() . '/utils/post-util.php');

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header();


/**
 * Featured This Month
 */
$featured_this_month_posts_ids = get_option('top_posts_editing_featured_this_month_post');

/**
 * Popular Posted
 */
$popular_posted_posts_ids = get_option('top_posts_editing_popular_posts');

/**
 * Recently Posted
 */
$recently_posts_args = array(
  'post_type' => array('blogs'),
  'post_status' => 'publish',
  'posts_per_page' => 8,
);
$recently_posts_query = new WP_Query($recently_posts_args);
?>

<main class="p-home">
  <section class="mv-block">
    <div class="inner-block">
      <?php if ($featured_this_month_posts_ids && count($featured_this_month_posts_ids)): ?>
        <div class="main-items">
          <h2 class="c-ttl01">
            <span class="bg">Featured</span> This Month
          </h2>
          <div class="splide-scroll-vertical splide">
            <div class="splide__track">
              <ul class="splide__list">
                <?php foreach ($featured_this_month_posts_ids as $post_id): ?>
                  <?php
                  $featured_this_month_post = get_post($post_id);
                  $this_term = get_the_terms($featured_this_month_post->ID, 'tax_blogs')[0];
                  ?>
                  <li class="splide__slide c-card c-card01">
                    <a href="<?php echo get_permalink($post_id); ?>">
                      <div class="txt-area">
                        <?php if ($this_term): ?>
                          <ul class="c-cat-list">
                            <li><?php echo esc_html($this_term->name); ?></li>
                          </ul>
                        <?php endif; ?>
                        <h3 class="ttl"><?php echo $featured_this_month_post->post_title; ?></h3>
                        <div class="info-area">
                          <div class="author">
                            <div class="img"><img src="<?php echo get_avatar_url(get_the_author_meta('ID', $popular_posted_post->post_author)); ?>" alt=""></div>
                            <p class="name"><?php echo get_the_author_meta('display_name', $featured_this_month_post->post_author); ?></p>
                          </div>
                          <div class="date">
                            <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_calender.svg" alt=""></div>
                            <p class="day"><?php echo get_the_date('Y.m.d', $featured_this_month_post); ?></p>
                          </div>
                          <div class="time">
                            <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_time.svg" alt=""></div>
                            <p class="min"><?php echo postUtil_get_reading_time($featured_this_month_post->ID); ?> Min. To Read</p>
                          </div>
                        </div>
                        <p class="description"><?php echo mb_strimwidth(strip_tags(get_the_content(null, null, $featured_this_month_post)), 0, 200, "…", "UTF-8"); ?></p>
                      </div>
                      <div class="thumb">
                        <span class="inn"><?php echo postUtil_get_thumb($featured_this_month_post->ID); ?></span>
                      </div>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php if ($popular_posted_posts_ids && count($popular_posted_posts_ids)): ?>
        <div class="sub-items">
          <h2 class="c-ttl01">
            <span class="bg">Popular</span> Posted
          </h2>
          <div class="splide-scroll-side splide">
            <div class="splide__track">
              <ul class="splide__list">
                <?php foreach ($popular_posted_posts_ids as $post_id): ?>
                  <?php
                  $popular_posted_post = get_post($post_id);
                  $this_term = get_the_terms($popular_posted_post->ID, 'tax_blogs')[0];
                  ?>
                  <li class="splide__slide c-card small">
                    <a href="<?php echo get_permalink($post_id); ?>">
                      <div class="txt-area">
                        <?php if ($this_term): ?>
                          <ul class="c-cat-list">
                            <li><?php echo esc_html($this_term->name); ?></li>
                          </ul>
                        <?php endif; ?>
                        <h3 class="ttl"><?php echo $popular_posted_post->post_title; ?></h3>
                        <div class="info-area">
                          <div class="author">
                            <div class="img"><img src="<?php echo get_avatar_url(get_the_author_meta('ID', $popular_posted_post->post_author)); ?>" alt=""></div>
                            <p class="name"><?php echo get_the_author_meta('display_name', $popular_posted_post->post_author); ?></p>
                          </div>
                          <div class="date">
                            <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_calender.svg" alt=""></div>
                            <p class="day"><?php echo get_the_date('Y.m.d', $popular_posted_post); ?></p>
                          </div>
                          <div class="time">
                            <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_time.svg" alt=""></div>
                            <p class="min"><?php echo postUtil_get_reading_time($popular_posted_post->ID); ?> Min. To Read</p>
                          </div>
                        </div>
                        <p class="description"><?php echo mb_strimwidth(strip_tags(get_the_content(null, null, $popular_posted_post)), 0, 200, "…", "UTF-8"); ?></p>
                      </div>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="post-block">
    <div class="inner-block">
      <?php if ($recently_posts_query->have_posts()): ?>
        <div class="recently-post-items">
          <h2 class="c-ttl01">
            <span class="bg">Recently</span> Posted
          </h2>
          <ul class="c-card-list">
            <?php while ($recently_posts_query->have_posts()): $recently_posts_query->the_post(); ?>
              <?php get_template_part('components/c-cardList', null, $post) ?>
            <?php endwhile; ?>
          </ul>
          <a href="<?php echo $home_url; ?>/blogs/" class="c-btn">More</a>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>

      <?php get_sidebar(); ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>