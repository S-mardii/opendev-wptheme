<?php get_header(); ?>

<?php
  if (is_front_page()) {
?>

 <?php
     $options = get_option('opendev_options');
    if ($options['frontpage_slider_id']) : ?>
     <section id="featured-content" class="page-section row">
      <div class="container">
       <div class="twelve columns">
        <div class="section-featured-content">
          <?php
            if (function_exists('fa_display_slider')) {
                fa_display_slider($options['frontpage_slider_id']);
            }
          ?>
        </div>
       </div>
      </div>
     </section>
 <?php endif;?>

 <?php $is_mapgroup = jeo_get_mapgroup_data(); ?>
 <section id="news" class="page-section row" <?php // if($is_mapgroup) : echo "style='padding-top:60px'"; endif; ?>>
  <div class="container">
   <div class="twelve columns">
   <?php $site_name = str_replace('Open Development ', '', get_bloginfo('name'));?>
   <h2><?php _e("News <em> from ", "opendev"); _e($site_name, "opendev") ?></em></h2>

   <!-- <section class="tabbed-posts-section">
            <script>
              /* jQuery(function($) {
                  $('#tabbed-post-type-nav li').first().addClass('tab-tag-active');
                  $('.sticky-posts').first().addClass('sticky-posts-active');
            	   // $('#tabbed-post-type-nav li').first().css('backgrond', 'red');
                    var tab_active_id = $('#tabbed-post-type-nav li.active').attr('id');
                    $("#sticky-"+tab_active_id).show();
                    $('#tabbed-post-type-nav li div.tag-name').click(function(event){
                            $('#tabbed-post-type-nav li').removeClass('tab-tag-active');
                            $('.sticky-posts').removeClass('sticky-posts-active');
                            $( event.target).parent().addClass('tab-tag-active');
                            var target = $( event.target );
                            var current_active_id = $(this).parent().attr('id');
                            $('.sticky-posts').hide();
                            $("#sticky-"+current_active_id).addClass('sticky-posts-active');
                            $("#sticky-"+current_active_id).show();
                           // $( event.target ).css('background-color', 'red');

                    });
              }); */
            </script>
            <nav id="tabbed-post-type-nav">
            	<ul>
            		<?php
                    /* $options_news_tags = get_option('opendev_options');
    if ($options_news_tags['news_tags']) {
        $news_tags = preg_replace('/,$/', '', $options_news_tags['news_tags']);
                    //$news_tags = rtrim($options_news_tags['news_tags'], ',');
                    $news_tags = explode(',', $news_tags);
        $tag_count = 1;
        foreach ($news_tags as $tag) {
            if ($tag_count <= 6) {
                echo '<li class="tab-tag" id="tag-'.strtolower(str_replace(' ', '-', trim($tag))).'"><div class="tag-name">'.ucwords($tag).'</div></li>';
            }
            ++$tag_count;
        }
    } else {
        echo '<li class="tab-tag" id="tag-regional"><div class="tag-name">Regional</div></li>';
        echo '<li class="tab-tag" id="tag-cambodia"><div class="tag-name">Cambodia</div></li>';
        echo '<li class="tab-tag" id="tag-laos"><div class="tag-name">Laos</div></li>';
        echo '<li class="tab-tag" id="tag-myanmar"><div class="tag-name">Myanmar</div></li>';
        echo '<li class="tab-tag" id="tag-thailand"><div class="tag-name">Thailand</div></li>';
        echo '<li class="tab-tag" id="tag-vietnam"><div class="tag-name">Vietnam</div></li>';
    } */
    ?>
            	</ul>
            </nav>
        </section>   -->
    <div class="section-map">
     <?php
     jeo_map();
    ?>
    </div>
    <?php
        $page_news_archive = get_page_by_path( 'news-archive' );
        $page_news = get_page_by_path( 'news' );
          if($page_news_archive) { ?>
            <div class="view-more"><a href="<?php echo get_page_link($page_news_archive->ID) ?>"><?php _e("View more... »", "opendev"); ?></a></div>
    <?php }else if ($page_news){?>
        <div class="view-more"><a href="<?php echo get_page_link($page_news->ID) ?>"><?php _e("View more... »", "opendev"); ?></a></div>
    <?php
          }?>
   </div>
  </div>
 </section>


 <section id="announcements-and-updates" class="page-section row">
   <div class="container">
     <div class="row">
      <div class="eight columns">
        <?php dynamic_sidebar('frontpage-footer-left'); ?>
      </div>
      <div class="four columns">
        <?php dynamic_sidebar('frontpage-footer-right'); ?>
      </div>
    </div>
   </div>
 </section>

 <?php //get_template_part('section', 'content-summary'); ?>

<?php
}
?>

<?php // get_template_part('content', 'interactive-map'); ?>

<?php get_footer(); ?>
