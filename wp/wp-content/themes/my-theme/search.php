<?php

/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<main class="p-blogs">
  <?php if (have_posts()) : ?>

    <section class="blog-list-block">
      <div class="inner-block">
        <h2 class="c-ttl03">search result for : <span class="bold"><?php echo get_search_query(); ?></span></h2>
        <ul class="c-card-list list02">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('components/c-cardList', null, $post) ?>
          <?php endwhile ?>
        </ul>
        <?php
        set_query_var('paging_query', $wp_query);
        get_template_part('paging');
        ?>
      </div>
    </section>

  <?php endif; ?>
</main>
<?php get_footer(); ?>