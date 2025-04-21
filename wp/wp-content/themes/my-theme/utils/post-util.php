<?php

/**
 * 投稿のサムネイル取得
 */
function postUtil_get_thumb($post_id) {
  global $template_url;

  $thumb = get_the_post_thumbnail($post_id, 'full', array('class' => 'thumb'));
  if ($thumb) {
    return $thumb;
  } else {
    return '<img src="' . esc_url($template_url) . '/img/common/no-image.png" alt="No Image">';
  }
}

/**
 * 記事が何分で読めるかを取得
 */
function postUtil_get_reading_time($post_id) {
  $content = get_post($post_id)->post_content;
  $word_count = str_word_count(strip_tags($content));

  if ($word_count === 0) { // 日本語の場合
    $word_count = mb_strlen(strip_tags($content));
  }

  $reading_time = ceil($word_count / 300);
  return $reading_time;
}
