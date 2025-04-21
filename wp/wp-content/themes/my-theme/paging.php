<?php
global $wp_rewrite, $template_url;
$paginate_base = get_pagenum_link(1);
if (strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()) {
  $paginate_format = '';
  $paginate_base = add_query_arg('paged', '%#%');
} else {
  $paginate_format = (substr($paginate_base, -1, 1) == '/' ? '' : '/') .
    user_trailingslashit('page/%#%/', 'paged');;
  $paginate_base .= '%_%';
}
$page_links =  paginate_links(array(
  'base' => $paginate_base,
  'format' => $paginate_format,
  'total' => $paging_query->max_num_pages,
  'end_size' => 1,
  'mid_size' => 2,
  'current' => ($paged ? $paged : 1),
  'prev_text' => 'Prev',
  'next_text' => 'Next',
));


if (strcmp($page_links, "") != 0) :
?>
  <div class="c-pagination">
    <div class="list"><?php print $page_links; ?></div>
  </div><!-- /paging-area -->
<?php endif; ?>