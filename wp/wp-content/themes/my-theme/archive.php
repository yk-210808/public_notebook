<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

    <?php if ( have_posts() ) : ?>

      <?php
        while ( have_posts() ) : the_post();
          $thumbnail = wp_get_attachment_url(get_post_thumbnail_id());
          $this_taxs = wp_get_object_terms($post->ID, 'category');
      ?>
      
        <ul class="tag-list">
          <?php foreach ( $this_taxs as $this_tax ) : ?>
            <li class="tag"><?php print $this_tax->name; ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="date"><?php the_time('Y.m.d'); ?></div>
        <div class="title"><?php the_title(); ?></div>
        <div class="description"><?php print mb_strimwidth(strip_tags(get_the_content()), 0, 200, "…", "UTF-8"); ?></div>
        
      <?php endwhile; ?>

      <?php
        set_query_var( 'paging_query', $wp_query );
        get_template_part('paging');
      ?>

    <?php else : ?>
      何も投稿がありません。
    <?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
