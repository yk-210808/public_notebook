<form role="search" method="get" class="my-search-form c-form" action="<?php echo esc_url(home_url('/')); ?>">
  <input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="Keyword" class="search-input" />
  <input type="submit" value="Search" class="btn" />
  <input type="hidden" name="post_type" value="blogs">
</form>