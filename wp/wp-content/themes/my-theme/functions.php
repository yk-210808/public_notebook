<?php

// head内 script読み込み
function theme_name_files() {
  //jQuery読み込み
  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'theme_name_files');


function my_after_setup() {
  // 投稿でサムネイルを有効にする
  add_theme_support('post-thumbnails');
  // html5で出力する
  add_theme_support('html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
  ));
}
add_action('after_setup_theme', 'my_after_setup');


/**
 * /?author=1 などでアクセスしたら404ページへリダイレクトさせる
 * @see https://www.webdesignleaves.com/pr/wp/wp_user_enumeration.html
 */
function disable_author_archive() {
  if (!is_user_logged_in() && (isset($_GET['author']) || preg_match('#/author/.+#', $_SERVER['REQUEST_URI']))) {
    wp_redirect(home_url('/not-found'));
    exit;
  }
}
add_action('init', 'disable_author_archive');

/**
 * WordPress REST API によるユーザー情報を隠す
 */
function my_filter_rest_endpoints($endpoints) {
  if (isset($endpoints['/wp/v2/users'])) {
    unset($endpoints['/wp/v2/users']);
  }
  if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
    unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
  }
  return $endpoints;
}
add_filter('rest_endpoints', 'my_filter_rest_endpoints', 10, 1);


// ウィジェットの設定 サイドバー
function my_widgets_init() {
  register_sidebar(array(
    'name'          => 'Sidebar',
    'id'            => 'sidebar-1',
    'before_widget' => '<section id="%1$s" class="widget %2$s c-side-cont-section">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title" style="display: none;">',
    'after_title'   => '</h2>',
  ));
}
add_action('widgets_init', 'my_widgets_init');




/*** wp_head()の自動挿入の削除 ***/
// フィード出力を削除
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
// スタイルシートを削除
remove_action('wp_head', 'wp_print_styles', 8);
// スクリプトを削除
// remove_action('wp_head', 'wp_print_head_scripts', 9);
// リンク情報「prev」「next」を削除
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
// リンク情報「shortlink」を削除
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
// リンク情報「canonical」を削除
remove_action('wp_head', 'rel_canonical');
// リンク情報「EditURI」を削除
remove_action('wp_head', 'rsd_link');
// リンク情報「wlwmanifest」を削除
remove_action('wp_head', 'wlwmanifest_link');
// WordPressのバージョン情報を削除
remove_action('wp_head', 'wp_generator');

// WordPress 4.4から追加された「Embed」機能に関する出力
// 必要ない場合に以下で出力を削除
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

// WordPress4.6から追加になったdns-prefetch
remove_action('wp_head', 'wp_resource_hints', 2);

// wpemojiSettings を削除
function disable_emoji() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'disable_emoji');

function remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'remove_recent_comments_style');
/*** wp_head()の自動挿入の削除 ここまで ***/

/* 自動更新のお知らせ停止 */
add_filter('auto_core_update_send_email', '__return_false');
/* テーマファイルのアップデートを非通知にする */
remove_action('load-update-core.php', 'wp_update_themes');
add_filter('pre_site_transient_update_themes', function () {
  return null;
});

/**
 * バージョンアップ通知の非表示
 */
function update_nag_hide() {
  remove_action('admin_notices', 'update_nag', 3);
  remove_action('admin_notices', 'maintenance_nag', 10);
}
add_action('admin_init', 'update_nag_hide');

// 不要なメニューの削除
function remove_menus() {
  global $menu;

  unset($menu[20]);  // 固定ページが複数になってしまうので、１つ目を消去

  remove_menu_page('edit.php'); // 投稿
  // remove_menu_page('edit-comments.php'); // コメント
}
add_action('admin_menu', 'remove_menus');


function my_admin_style() {
  wp_enqueue_style('my_admin_style', get_template_directory_uri() . '/css/admin.css');
}
add_action('admin_enqueue_scripts', 'my_admin_style');


// デフォルトをhtmlエディタにする
add_filter('wp_default_editor', function () {
  return "html";
});



// テンプレートURLを記事で使うショートコード
function shortcode_templateurl() {
  return get_bloginfo('template_url');
}
add_shortcode('template_url', 'shortcode_templateurl');


// サイトURLを記事で使うショートコード
function shortcode_siteurl() {
  return get_bloginfo('url');
}
add_shortcode('site_url', 'shortcode_siteurl');


// グローバル変数の設定
global $template_url;
$template_url = get_template_directory_uri();
global $home_url;
$home_url = home_url();


// bodyのクラスにslugをつける
function pagename_class($classes = '') {
  if (is_page()) {
    $page = get_post(get_the_ID());
    $classes[] = 'page-' . $page->post_name;
    if ($page->post_parent) {
      $classes[] = 'page-' . get_page_uri($page->post_parent) . '-child';
    }
  }
  return $classes;
}
add_filter('body_class', 'pagename_class');


/*********************  以下適宜変更 ************************/

// 固定ページの REST API を falseに
add_action('init', 'update_page_rest_api');
function update_page_rest_api() {
  register_post_type('page', array(
    'labels' => array(
      'name' => '固定ページ',
      'singular_name' => '固定ページ',
      'add_new' => '新規追加',
      'add_new_item' => '新規固定ページを追加',
      'edit_item' => '固定ページを編集',
      'new_item' => '新規固定ページ',
      'view_item' => '固定ページを表示',
      'view_items' => '固定ページ一覧を表示',
      'search_items' => '固定ページを検索',
      'not_found' => 'ページが見つかりませんでした。',
      'not_found_in_trash' => 'ゴミ箱内にページが見つかりませんでした。',
      'parent_item_colon' => '親ページ:',
      'all_items' => '固定ページ一覧',
      'archives' => '固定ページアーカイブ',
      'attributes' => 'ページ属性',
      'insert_into_item' => '固定ページに挿入',
      'uploaded_to_this_item' => 'この固定ページへのアップロード',
      'featured_image' => 'アイキャッチ画像',
      'set_featured_image' => 'アイキャッチ画像を設定',
      'remove_featured_image' => 'アイキャッチ画像を削除',
      'use_featured_image' => 'アイキャッチ画像として使用',
      'filter_items_list' => '固定ページ一覧を絞り込む',
      'filter_by_date' => '日付で絞り込む',
      'items_list_navigation' => '固定ページリストナビゲーション',
      'items_list' => '固定ページリスト',
      'item_published' => '固定ページを公開しました。',
      'item_published_privately' => '固定ページを限定公開しました。',
      'item_reverted_to_draft' => '固定ページを下書きに戻しました。',
      'item_scheduled' => '固定ページを予約しました。',
      'item_updated' => '固定ページを更新しました。',
      'menu_name' => '固定ページ',
      'name_admin_bar' => '固定ページ',
    ),
    'description' => false,
    'public' => true,
    'hierarchical' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true,
    'menu_position' => 20,
    'menu_icon' => 'dashicons-admin-page',
    'capability_type' => 'page',
    'map_meta_cap' => true,
    'register_meta_box_cb' => false,
    'has_archive' => false,
    'query_var' => false,
    'can_export' => true,
    'delete_with_user' => true,
    'rewrite' => false,
    'show_in_rest' => false,
  ));
}


// 指定のパスのファイルが存在するかどうか（catch_that_imageで使用）
function file_check($path) {
  $response = get_headers($path);
  if (strpos($response[0], 'OK')) {
    return true;
  } else {
    return false;
  }
}
// 記事内で出現する最初の画のパス像を返す
function catch_that_image() {
  global $post, $posts, $template_url;

  if (preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)) {
    $first_img = $matches[1][0];
  }

  if (empty($first_img) || !file_check($first_img)) {
    // 記事内で画像がなかったときのためのデフォルト画像を指定
    $first_img = $template_url . "/img/default.jpg";
  }
  return $first_img;
}

// 特定の属性内でのショートコードを展開する
function my_kses_allowed_html($tags, $context) {
  if ($context == 'post') {
    $tags['use']['xlink:href'] = true;
    $tags['div']['data-src'] = true;
  }
  return $tags;
}
add_filter('wp_kses_allowed_html', 'my_kses_allowed_html', 10, 2);


/**
 * カスタム投稿の追加
 */
add_action('init', 'create_blogs');
function create_blogs() {
  register_post_type('blogs', array(
    'labels' => array(
      'name' => 'ブログ',
      'singular_name' => 'ブログ',
    ),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_rest' => true,  // true: ブロックエディタ,  false: クラシックエディタ
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'comments')
  ));

  // タクソノミー追加
  register_taxonomy('tax_blogs', array('blogs'), array(
    'hierarchical' => true,  // true: カテゴリー,  false: タグ
    'label' => 'カテゴリー',
    'show_ui' => true,
    'public' => true,
    'show_in_rest' => true,
    'rewrite' => array(
      'slug' => 'blogs/category',
    ),
  ));
  register_taxonomy('tax_blogs_tag', array('blogs'), array(
    'hierarchical' => true,  // true: カテゴリー,  false: タグ
    'label' => 'タグ',
    'show_ui' => true,
    'public' => true,
    'show_in_rest' => true,
    'rewrite' => array(
      'slug' => 'blogs/tag',
    ),
  ));
}

function add_custom_rewrite_rules() {
  // tax_blogs
  add_rewrite_rule('blogs/category/([^0-9]+)/?$', 'index.php?tax_blogs=$matches[1]&taxonomy=tax_blogs', 'top');
  add_rewrite_rule('blogs/category/([^0-9]+)/page/([^/]+)/?$', 'index.php?tax_blogs=$matches[1]&taxonomy=tax_blogs&paged=$matches[2]', 'top');
  // tax_blogs_tag
  add_rewrite_rule('blogs/tag/([^0-9]+)/?$', 'index.php?tax_blogs_tag=$matches[1]&taxonomy=tax_blogs_tag', 'top');
  add_rewrite_rule('blogs/tag/([^0-9]+)/page/([^/]+)/?$', 'index.php?tax_blogs_tag=$matches[1]&taxonomy=tax_blogs_tag&paged=$matches[2]', 'top');
}
add_action('init', 'add_custom_rewrite_rules');

/*** カスタム投稿のアーカイブページでの表示数 ***/
add_action('pre_get_posts', 'my_pre_get_posts');
function my_pre_get_posts($query) {
  if (!is_admin() && $query->is_main_query() && (is_post_type_archive('blogs') || is_tax('tax_blogs') || is_tax('tax_blogs_tag'))) {
    $query->set('posts_per_page', 2);
  }
}

/**
 * 環境に合わせてスクリプトを読み込む
 */
function get_script_src() {
  $themaPath = get_template_directory();

  if (defined('DEV_ENV')) {
    $json = file_get_contents("{$themaPath}/manifest.dev.json");
    $data = json_decode($json, true);
    $url = $data['url'];
    $src = $url . '@vite/client';
    $src2 = $url . $data['inputs']['main'];
    echo "
      <script src='{$src}' type='module'></script>
      <script src='{$src2}' type='module'></script>
      ";
  } else if (file_exists("{$themaPath}/manifest.json")) {
    $json = file_get_contents("{$themaPath}/manifest.json");
    $data = json_decode($json, true);
    $src = get_template_directory_uri() . '/' . $data['js/main.js']['file'];
    wp_enqueue_script('main.js', $src, array(), '1.0.0');
  }
}

function get_style_src() {
  $themaPath = get_template_directory();
  if (defined('DEV_ENV')) {
    $json = file_get_contents("{$themaPath}/manifest.dev.json");
    $data = json_decode($json, true);
    $url = $data['url'];

    echo "<link href='{$url}{$data['inputs']['style']}' rel='stylesheet'></link>";
  } else if (file_exists("{$themaPath}/manifest.json")) {
    $json = file_get_contents("{$themaPath}/manifest.json");
    $data = json_decode($json, true);
    $src = get_template_directory_uri() . '/' . $data['scss/style.scss']['file'];
    wp_enqueue_style('style', $src, array(), '1.0.0');
  }
}
function enqueue_name() {
  get_script_src();
  get_style_src();
}
add_action('wp_enqueue_scripts', 'enqueue_name');

function add_type_attribute($tag, $handle, $src) {
  if ('main.js' !== $handle) {
    return $tag;
  }
  $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
  return $tag;
}

add_filter('script_loader_tag', 'add_type_attribute', 10, 3);

// 自動改行を削除
remove_filter('the_content', 'wpautop');

// エラーを表示しない
error_reporting(0);