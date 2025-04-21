<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div class="page-not-found">
  <div class="inner-block">
    <p class="number">404</p>
    <p class="txt">the page you are looking for does not exist!</p>
    <a href="<?php echo $home_url; ?>/" class="back-btn">Back to homepage</a>
  </div>
</div>

<?php get_footer(); ?>