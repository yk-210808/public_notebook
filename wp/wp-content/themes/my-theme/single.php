<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

    <?php while ( have_posts() ) : the_post(); ?>
    
      <?php the_content(); ?>
      
      <div class="paging-area">
        <?php if ($prev_post = get_previous_post()):?>
          <a href="<?php print get_the_permalink($prev_post->ID); ?>">前の記事</a>
        <?php endif; ?>
        <a class="list page-numbers" href="<?php print $home_url; ?>/blog/">記事一覧へ戻る</a>
        <?php if ($next_post = get_next_post()):?>
          <a href="<?php print get_the_permalink($next_post->ID); ?>">次の記事</a>
        <?php endif; ?>
      </div><!-- /paging-area -->
      
    <?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
