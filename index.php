<?php get_header();?>
    <!-- main -->
<!--    横幅指定用のクラスを追加（ページ左側の幅）-->
<!--   col-sm-768px以上なら8カラムにする(レスポンシブデザイン)-->
    <div id="content" class="col-sm-8" role="main">
      <!-- post -->
            
<?php if(have_posts() ) :
      while(have_posts() ) : the_post(); ?>
<!--      記事間の枠線-->
      <div id="article1">
           
      <div id="post-<?php the_ID();?>" <?php post_class(); ?>>
<!--      the_permalink記事のパーマリンクを出力-->
<!--     the_title記事のタイトルを表示-->
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
       <div class="articleheader">
<!--         the_date記事の日付を表示-->
<span class="post-date glyphicon glyphicon-calendar"><?php echo get_the_date(); ?> </span>
<!--          the_category記事のカテゴリーを表示-->
          <span class="glyphicon glyphicon-tag"><?php the_category(',') ?></span>
<!--           comment_popup_linkコメント数を表示-->
           <span class="label label-danger">
             <?php comments_popup_link('0','1','%');?>
          </span>
        </div>
<!--               アイキャッチ-->
<!--col-md-(992px≦) col-sm-(768px≦) col-xs-(<768)-->
        <div id="eyecatch" class="col-md-12 col-sm-12 col-xs-12"><a href="<?php the_permalink() ?>">
      <?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
<!--      autopostthumbnailを有効にしたら画像のトリミングが可能-->
<!--     幅が745px以上ないと、高さがそのまま出る-->
      <?php the_post_thumbnail(); ?>
      <?php else: // サムネイルを持っていないときの処理 ?>
      <img src="<?php echo get_template_directory_uri(); ?>/images/noimage.png" alt="no image" title="no image" width="300" height="221">
      <?php endif; ?>
          </a>
      
<!--        the_contentコンテンツ（画像を含む）、続きを読むのリンクを表示-->
        <div><?php the_excerpt(); ?></div>
            <div id="articlenext">
               <a href="<?php the_permalink() ?>" class="btn btn-default btn-lg">続きを読む <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></div>
             </div>
      </div>
      </div>
             
              
      <?php
//この部分で記事を表示する処理をしています。
endwhile;//繰り返し処理終了
else: ?>
   
    
     <div class="post">
       <h2>記事はありません</h2>
       <p>お探しの記事は見つかりませんでした</p>
      </div>
      
      <?php endif;?>
      
      <!-- pager -->
      <div class="navigation">
      <!--      1ページより多かったらtrue（条件分岐）-->
<?php if($wp_query -> max_num_pages > 1):?>
<?php 
$args = array(
  'prev_text' => '前へ',     //「前へ」のテキスト。
  'next_text' => '次へ',   //「次へ」のテキスト
  'class_name' => 'pagination'  //これはdiv要素のクラスなので必須ではない
);
pagenavi($args);
?>
      <!-- /pager	 -->
    
        <?php endif; ?>
 </div>
        <!-- 一番上に戻るボタン-->
<!-- <div id="page-top"></div>-->
 </div>

<div id="container" class="row">
    <?php get_sidebar(); ?>
      </div>
<div id="container">
<?php get_footer(); ?>
</div>
