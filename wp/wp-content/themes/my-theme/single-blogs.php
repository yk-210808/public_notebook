<?php require_once(get_template_directory() . '/utils/post-util.php'); ?>

<?php

/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

  <?php
  $this_term = get_the_terms(get_the_ID(), 'tax_blogs')[0];

  /**
   * See Related Posts
   */
  function get_taxonomy_args($term) {
    if ($term) {
      return array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'tax_blogs',
          'field' => 'slug',
          'terms' => $term->slug
        )
      );
    } else {
      return '';
    }
  }

  function set_args($term = false) {
    return array(
      'post_type' => array('blogs'),
      'post_status' => 'publish',
      'posts_per_page' => 2,
      'post__not_in' => array(get_the_ID()),
      'tax_query' => get_taxonomy_args($term)
    );
  }

  $the_query = new WP_Query(set_args($this_term));

  if (!$the_query->posts) {
    $the_query = new WP_Query(set_args(false));
  }

  /**
   * Comments
   */
  $comment_args = array(
    'logged_in_as' => '',
    'title_reply' => '',
    'url' => '',
    'comment_notes_before' => '',
    'comment_notes_after' => '',
  );

  $comments = get_comments(array('post_id' => get_the_ID()));

  $thumb = get_the_post_thumbnail($post_id, 'full', array('class' => 'thumb'));
  ?>

  <main class="p-blogs">
    <div class="blog-article-block">
      <div class="inner-block">
        <div class="main-items">
          <article class="c-card">
            <div class="txt-area">
              <?php if ($this_term): ?>
                <ul class="c-cat-list">
                  <li><?php echo esc_html($this_term->name); ?></li>
                </ul>
              <?php endif; ?>
              <h3 class="ttl"><?php echo get_the_title(); ?></h3>
              <div class="info-area">
                <div class="author">
                  <div class="img"><img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt=""></div>
                  <p class="name"><?php the_author(); ?></p>
                </div>
                <div class="date">
                  <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_calender.svg" alt=""></div>
                  <p class="day"><?php the_time('Y.m.d'); ?></p>
                </div>
                <div class="time">
                  <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_time.svg" alt=""></div>
                  <p class="min"><?php echo postUtil_get_reading_time(get_the_ID()); ?> Min. To Read</p>
                </div>
              </div>
            </div>
            <?php if($thumb): ?>
              <div class="thumb"><span class="inn"><?php echo $thumb; ?></span></div>
            <?php endif; ?>
            <div class="article-content">
              <?php the_content(); ?>
            </div>
          </article>

          <ul class="article-sns-list">
            <li><a href="#"><img src="<?php echo $template_url; ?>/img/common/icon_box.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo $template_url; ?>/img/common/icon_facebook02.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo $template_url; ?>/img/common/icon_twitter02.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo $template_url; ?>/img/common/icon_insta.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo $template_url; ?>/img/common/icon_pinterest.svg" alt=""></a></li>
          </ul>
          <a href="#" class="share-btn">
            <img src="<?php echo $template_url; ?>/img/common/icon_share.svg" alt="">
          </a>

          <?php if ($the_query->have_posts()): ?>
            <div class="related-post-items">
              <h2 class="c-ttl01"><span class="bg">See Related</span> Posts</h2>
              <ul class="c-card-list">
                <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                  <?php get_template_part('components/c-cardList', null, $post) ?>
                <?php endwhile; ?>
              </ul>
            </div>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
          <div class="comment-form c-form">
            <h2 class="c-ttl01"><span class="bg">Comments</span></h2>
            <?php comment_form($comment_args); ?>

            <?php if ($comments && count($comments)): ?>
              <ul class="comment-list">
                <?php foreach ($comments as $comment): ?>
                  <li class="comment-item">
                    <div class="comment-content">
                      <div class="comment-info">
                        <div class="comment-name">
                          <p class="item-ttl">Name : </p>
                          <p class="name"><?php echo $comment->comment_author; ?></p>
                        </div>
                        <div class="comment-date">
                          <div class="icon"><img src="<?php echo $template_url; ?>/img/common/icon_calender.svg" alt=""></div>
                          <p class="date"><?php echo get_comment_date('Y.m.d'); ?></p>
                        </div>
                      </div>
                      <p class="comment-text"><?php echo $comment->comment_content; ?></p>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

          </div>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </main>
<?php endwhile; ?>

<?php get_footer(); ?>