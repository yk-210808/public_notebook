<?php get_header(); ?>

<?php if (get_post_type() === 'blogs'): ?>
  <?php get_template_part('templates/taxonomy-blogs'); ?>
<?php endif; ?>

<?php get_footer(); ?>