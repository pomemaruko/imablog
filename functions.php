<?php
register_sidebar( array(
'name' => 'サイドバーウィジェット-1',
  'id' => 'sidebar-1',
  'description' => 'サイドバーのウィジェットエリアです。',
//  サイドバーでウィジェットを表示する際の記述
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>',
) );
?>
  <?php
//カスタムメニューを有効化
add_theme_support('menus');
//カスタムメニューの「場所」を設定するコード
//header.phpのheader-naviに設定したカスタムメニューを反映させる
register_nav_menu('header-navi','ヘッダーのナビゲーション');
register_nav_menu( 'header-sub-navi', 'サブナビゲーション' );
//カスタムメニューは複数作れる。footer.phpにwp_nav_menu(array('theme_location'=>'footer-navi'));を書き加えればOK。
register_nav_menu( 'footer-navi', 'フッターのナビゲーション' );
?>
    <?php
if(!isset($content_width))$content_width=600;
?>
      <?php
add_theme_support('automatic-feed-links');
?>
        <?php
function add_my_scripts() {  
  if(is_admin()) return; //管理画面にはスクリプトは追加しない
  wp_deregister_script( 'jquery');  //デフォルトの jQuery は読み込まない
  //CDN から読み込む
  wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.10.2', false);
  wp_enqueue_script( 'jquery-mig', '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js', array(), '1.2.1', false);
}
//add_action('wp_print_scripts', 'add_my_scripts'); 訂正：以下のフックを使ったほうが良い
add_action('wp_enqueue_scripts', 'add_my_scripts');
?>
          <?php
function my_bootstrap_scripts() {
wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bs/css/bootstrap.min.css');
wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/bs/js/bootstrap.min.js', array(), '3.3.5', true );
}
add_action( 'wp_enqueue_scripts', 'my_bootstrap_scripts' );
?>
            <?php
function pagenavi($args = array()) {
  //デフォルト値
  $defaults = array(
    'class_name' => 'pagenavi',  //div 要素のクラス名
    'show_all' => false,    //全件表示するかどうか。
    'prev_next' =>  true,    //「前へ」「次へ」のリンクの有無
    'prev_text' => __('&laquo; Previous'),     //「前へ」のテキスト。
    'next_text' => __('Next &raquo;'),   //「次へ」のテキスト
    'end_size' => 1,  //最初のページと最終のページ部の表示件数（1以上）
    'mid_size' => 3,  //現在のページ部分（但し現在のページを含まない）の表示件数（0以上）
  );
  $args = wp_parse_args( $args, $defaults );    //パラメータを解析し、省略されたパレメータにはデフォルト値をセット
  extract( $args, EXTR_SKIP );    //キーを変数名、値を変数の値として処理  
  echo '<div class="' .$class_name. '">'; 
  global $wp_rewrite;
  $paginate_base = get_pagenum_link(1);
  if (strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()) {
    $paginate_format = '';
    $paginate_base = esc_url(add_query_arg('paged', '%#%'));
  } else {
    $paginate_format = (substr($paginate_base, -1 ,1) == '/' ? '' : '/') .
    user_trailingslashit('page/%#%/', 'paged');;
    $paginate_base .= '%_%';
  }
  global $paged;
  global $wp_query;
  //paginate_links()の出力を $outputs に格納
  $outputs = paginate_links( array(
    'base' => $paginate_base,
    'format' => $paginate_format,
    'total' => $wp_query->max_num_pages,
    'current' => ($paged ? $paged : 1),
    'show_all' => $show_all,    
    'prev_next' =>  $prev_next,  
    'prev_text' => $prev_text ,  
    'next_text' => $next_text ,  
    'end_size' => $end_size,
    'mid_size' => $mid_size,
    'type' => 'list'
  )); 
  //★ ul 要素のクラス名を変更（置換）して出力
  echo str_replace("<ul class='page-numbers'>", "<ul class='pagination'>", $outputs);
  echo '</div>';  
}
?>
                <?php 
function new_excerpt_mblength($length) {
     return 20;
}
add_filter('excerpt_mblength', 'new_excerpt_mblength');
?>
                  <?php
function new_excerpt_more($more) {//見出し記事の文末を...にする
    return '.....';
}
add_filter('excerpt_more', 'new_excerpt_more');
?>
                    <?php
  function scrolltop_button_js(){//途中からトップへ戻るボタン出現
?>
                      <script type="text/javascript">
                        jQuery(function() {
                          var showFlag = false;
                          var topBth = jQuery('#page-top');
                          topBth.css('bottom', '-100px');
                          var showFlag = false;
                          //スクロールが200に達したらボタン表示
                          jQuery(window).scroll(function() {
                            if (jQuery(this).scrollTop() > 200) {
                              if (showFlag == false) {
                                showFlag = true;
                                topBth.stop().animate({
                                  'bottom': '20px'
                                }, 300);
                              }
                            } else {
                              if (showFlag) {
                                showFlag = false;
                                topBth.stop().animate({
                                  'bottom': '-100px'
                                }, 300);
                              }
                            }
                          });
                          //スクロールしてトップ
                          topBth.click(function() {
                            jQuery('body,html').animate({
                              scrollTop: 0
                            }, 500);
                            return false;
                          });
                        });

                      </script>
                      <?php
    }
    add_action("wp_head", "scrolltop_button_js");
?>
              <?php 
//add_theme_support('post-thumbnails');//アイキャッチ項目追加
//add_image_size('thumb', 700, 406,true);//引数,x,y,true
add_theme_support('post-thumbnails');
set_post_thumbnail_size(745, 400, true);
?>
<?php
add_filter( 'wp_list_categories', 'my_list_categories', 10, 2 );
function my_list_categories( $output, $args ) {
  $output = preg_replace('/<\/a>\s*\((\d+)\)/',' <span class="count">$1</span></a>',$output);
  return $output;
}
?>
<?php
// SVGファイルに対応する
add_filter( 'upload_mimes', 'my_add_mime_type' );
if( !function_exists('my_add_mime_type') ) {
	function my_add_mime_type($mime_types)
	{
		$mime_types['svg'] = 'image/svg+xml';
		$mime_types['svgz'] = 'image/svg+xml';
		return $mime_types;
	}
}
add_filter('ext2type', 'my_ext2type');
if( !function_exists('my_ext2type') ) {
	function my_ext2type($ext2types)
	{
		array_push($ext2types['image'], 'svg', 'svgz');
		return $ext2types;
	}
}
add_filter('wp_generate_attachment_metadata', 'my_wp_generate_attachment_metadata',1,2);
if( !function_exists('my_wp_generate_attachment_metadata') ) {
	function my_wp_generate_attachment_metadata($metadata, $attachment_id)
	{
		$attachment_post = $post = get_post($attachment_id);
		$type = $attachment_post->post_mime_type;
		if ($type === 'image/svg+xml' && empty($metadata)) {
			$upload_dir = wp_upload_dir();
			$base_name = basename($attachment_post->guid);
			$metadata = array(
				'file' => $upload_dir['subdir'] . '/' . $base_name
			);
		}
		return $metadata;
	}
}