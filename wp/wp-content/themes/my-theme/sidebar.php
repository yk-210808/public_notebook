<?php

/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

global $template_url;
global $home_url;

// Top Authors
$user_args = array(
  'orderby' => 'post_count',
  'order' => 'DESC',
  'number' => 3,
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'show_in_front',
      'value' => true
    )
  )
);
$authors = get_users($user_args);

function author_meta($id) {
  $user_meta = get_user_meta($id);

  return $user_meta;
}

// Categories
$blogs_terms = get_terms(array(
  'taxonomy' => 'tax_blogs',
  'hide_empty' => true,
));

// search with tags
$blogs_tags = get_terms(array(
  'taxonomy' => 'tax_blogs_tag',
  'hide_empty' => true,
));
?>

<div class="c-side-items">
  <?php if ($authors && count($authors)): ?>
    <div class="side-author">
      <h2 class="c-ttl01"><span class="bg">Top</span> authors</h2>
      <ul class="c-author-list">
        <?php foreach ($authors as $author): ?>
          <?php $author_meta = author_meta($author->ID); ?>
          <li>
            <div class="thumb"><?php echo get_avatar($author->ID, 150); ?></div>
            <div class="txt-items">
              <p class="name"><?php echo esc_html($author->display_name); ?></p>
              <?php if ($author_meta['author_description'][0]): ?>
                <p class="description"><?php echo nl2br($author_meta['author_description'][0]); ?></p>
              <?php endif; ?>
              <ul class="sns-list">
                <?php if ($author_meta['facebook_url'][0]): ?>
                  <li><a href="<?php echo esc_url($author_meta['facebook_url'][0]); ?>" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_facebook.svg" alt=""></a></li>
                <?php endif; ?>
                <?php if ($author_meta['twitter_url'][0]): ?>
                  <li><a href="<?php echo esc_url($author_meta['twitter_url'][0]); ?>" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_twitter.svg" alt=""></a></li>
                <?php endif; ?>
                <?php if ($author_meta['instagram_url'][0]): ?>
                  <li><a href="<?php echo esc_url($author_meta['instagram_url'][0]); ?>" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_insta.svg" alt=""></a></li>
                <?php endif; ?>
              </ul>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($blogs_terms && count($blogs_terms)): ?>
    <div class="side-cat">
      <h2 class="c-ttl01"><span class="bg">Categories</span></h2>
      <ul class="c-side-cat-list">
        <?php foreach ($blogs_terms as $blog_term): ?>
          <li><a href="<?php echo get_term_link($blog_term); ?>"><?php echo esc_html($blog_term->name); ?><span class="count"><?php echo sprintf('%02d', $blog_term->count); ?></span></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <!-- <div class="side-update">
    <h2 class="c-ttl01"><span class="bg">Today’s</span> update</h2>
    <ul class="update-list">
      <li>
        <p class="number">14</p>
        <p class="txt">New posts</p>
      </li>
      <li>
        <p class="number">480</p>
        <p class="txt">total visitors</p>
      </li>
      <li>
        <p class="number">29</p>
        <p class="txt">New subscribers</p>
      </li>
      <li>
        <p class="number">138</p>
        <p class="txt">blog read</p>
      </li>
    </ul>
  </div> -->
  <?php if ($blogs_tags && count($blogs_tags)): ?>
    <div class="side-tag">
      <h2 class="c-ttl01"><span class="bg">search</span> with tags</h2>
      <ul class="c-tag-list">
        <?php foreach ($blogs_tags as $tag): ?>
          <li><a href="<?php echo get_term_link($tag); ?>"><?php echo esc_html($tag->name); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>