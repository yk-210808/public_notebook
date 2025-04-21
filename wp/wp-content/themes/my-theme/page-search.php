<?php

/* Template Name: 検索ページ */

get_header();
?>

<main class="p-search">
  <div class="inner-block p-page-inner">
    <div class="c-ttl-area">
      <h2 class="c-ttl01"><span class="bg">Search</span></h2>
    </div>
    <?php get_search_form(); ?>
  </div>
</main>

<?php get_footer(); ?>