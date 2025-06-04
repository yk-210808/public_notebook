<?php

global $template_url;
global $home_url;

// Categories
$blogs_terms = get_terms(array(
  'taxonomy' => 'tax_blogs',
  'hide_empty' => true,
));

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrapper">
  <header class="c-header">
    <div class="inner-block">
      <h1 class="header-logo">
        <a href="<?php echo $home_url; ?>"><img src="<?php echo $template_url; ?>/img/common/icon_company.svg" alt="NoteBook."></a>
      </h1>
      <ul class="link-list">
        <li><a href="<?php echo $home_url; ?>" class="trigger">Home</a></li>
        <?php if ($blogs_terms && count($blogs_terms)): ?>
          <li>
            <button type="button" class="trigger btn js--headerSubMenuTrigger"><span class="inn">Categories</span></button>
            <ul class="sub-menu">
              <?php foreach ($blogs_terms as $term): ?>
                <li><a href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a></li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endif; ?>
        <li>
          <button type="button" class="trigger btn js--headerSubMenuTrigger"><span class="inn">Pages</span></button>
          <ul class="sub-menu">
            <li><a href="<?php echo $home_url; ?>/faq/">FAQ</a></li>
            <li><a href="<?php echo $home_url; ?>/privacy/">Privacy Policy</a></li>
          </ul>
        </li>

        <li><a href="<?php echo $home_url; ?>/contact/" class="trigger">Contact</a></li>
        <li>
          <a href="<?php echo $home_url; ?>/search/" class="trigger icon">
            <img src="<?php echo $template_url; ?>/img/common/icon_search.svg" alt="">
            <span class="sp icon-sub-txt">Search</span>
          </a>
        </li>
      </ul>
      <button type="button" class="menu-trigger js--headerMenuTrigger">
        <span class="inn"></span>
        <span class="inn"></span>
        <span class="inn"></span>
      </button>
    </div>
  </header>