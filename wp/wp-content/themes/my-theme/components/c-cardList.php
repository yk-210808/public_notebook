<?php 
global $template_url;
require_once(get_template_directory() . '/utils/post-util.php');

$this_term = get_the_terms(get_the_ID(), 'tax_blogs')[0];
?>

<li>
  <a href="<?php the_permalink(); ?>">
    <div class="thumb"><span class="inn"><?php echo postUtil_get_thumb(get_the_ID()); ?></span></div>
    <div class="txt-area">
      <ul class="c-cat-list">
        <li><?php echo esc_html($this_term->name); ?></li>
      </ul>
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
      <p class="description"><?php echo mb_strimwidth(strip_tags(get_the_content()), 0, 200, "…", "UTF-8") ?></p>
    </div>
  </a>
</li>