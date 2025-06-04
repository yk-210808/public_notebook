<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

global $template_url;
global $home_url;

// Tags
$blogs_terms = get_terms(array(
  'taxonomy' => 'tax_blogs_tag',
  'hide_empty' => true,
));

?>
<footer class="c-footer">
  <div class="inner-block">
    <div class="inn">
      <div class="logo-area">
        <div class="logo"><img src="<?php echo $template_url; ?>/img/common/icon_company.svg" alt=""></div>
        <p class="description">Did you come here for something in particular or just general Riker</p>
      </div>
      <div class="main-items">
        <?php if ($blogs_terms && count($blogs_terms)): ?>
          <div class="link-list">
            <p class="ttl"><a href="<?php echo $home_url; ?>/blogs/">blogs</a></p>
            <ul class="list">
              <?php foreach ($blogs_terms as $term): ?>
                <li><a href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <div class="link-list">
          <p class="ttl">quick links</p>
          <ul class="list">
            <li><a href="<?php echo $home_url; ?>/faq/">FAQ</a></li>
            <li><a href="<?php echo $home_url; ?>/privacy/">Privacy Policy</a></li>
            <li><a href="<?php echo $home_url; ?>/contact/">Contact</a></li>
          </ul>
        </div>
        <div class="subsc-sns-area">
          <!-- <div class="subsc-box">
            <p class="ttl">Subscribe for newsletter</p>
            <form action="" method="POST" class="subsc-form">
              <input type="email" name="email" class="input" placeholder="Your Email" required>
              <button type="submit" class="btn">Subcribe</button>
            </form>
          </div> -->
          <div class="sns-box">
            <p class="ttl">follow on:</p>
            <ul class="c-sns-list">
              <li><a href="https://x.com/" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_twitter.svg" alt=""></a></li>
              <li><a href="https://www.facebook.com/" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_facebook.svg" alt=""></a></li>
              <li><a href="https://jp.pinterest.com/" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_pinterest.svg" alt=""></a></li>
              <li><a href="https://www.instagram.com/" target="_blank"><img src="<?php echo $template_url; ?>/img/common/icon_insta.svg" alt=""></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <p class="copyright">Designed By Themefisher & Developed By Gethugothemes</p>
  </div>
</footer>



<?php wp_footer(); ?>

</div> <!-- /#wrapper -->

</body>

</html>