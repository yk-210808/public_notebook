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

get_header();

$terms = get_terms(array(
  'taxonomy' => 'tax_blogs',
  'hide_empty' => true,
));
?>

<main class="p-blogs">
  <?php if (have_posts()) : ?>

    <section class="categories-block">
      <div class="inner-block">
        <h2 class="c-ttl02">Categories</h2>
        <ul class="list">
          <?php if ($terms[0]): ?>
            <?php foreach ($terms as $term): ?>
              <li>
                <a href="<?php echo get_term_link($term); ?>">
                  <span class="icon"><img src="<?php echo wp_get_attachment_image_url(get_term_meta($term->term_id, 'logo')[0]); ?>" alt=""></span>
                  <span class="txt"><?php echo esc_html($term->name); ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </section>

  <?php endif; ?>
</main>

<?php get_footer(); ?>