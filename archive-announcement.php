<?php
if(is_category()) {
	include_once(STYLESHEETPATH . '/category-announcement.php');
	die();
}
get_header();

if (function_exists(qtranxf_getLanguage)){
    if (qtranxf_getLanguage() <> "en") $lang = "_". CURRENT_LANGUAGE; else $lang = "";
    //Get all languages that is available
    $languages = qtranxf_getSortedLanguages();
    $local_language = $languages[1];
    $local_lang =  "_".$languages[1];
}	else $lang ="";

?>

<div class="section-title">
	<div class="container">
		<div class="eight columns">
			<h1 class="archive-title"><?php
					if( is_tag() || is_category() || is_tax() ) :
						printf( __( '%s', 'jeo' ), single_term_title() );
					elseif ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'jeo' ), get_the_date() );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'jeo' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'jeo' ) ) );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'jeo' ), get_the_date( _x( 'Y', 'yearly archives date format', 'jeo' ) ) );
					elseif ( is_post_type_archive() ) :
						_e(post_type_archive_title('', 0));
					else :
						_e( 'Archives', 'jeo' );
					endif;
				?></h1>
				<?php //get_template_part('section', 'query-actions'); ?>
		</div>
	</div>
</div>

<?php /*loop for Achive-Announcement*/
	if(have_posts()) : ?>
	<section class="posts-section row">
		<div class="container">
			<div class="eight columns">
				<?php get_template_part('section', 'query-actions'); ?>
							<?php if(is_search() || get_query_var('opendev_advanced_nav')) : ?>
											<?php $search_results =& new WP_Query("s=$s & showposts=-1");
														$NumResults = $search_results->post_count; ?>
											<div id="advanced_search_results"><h2>Site Results (<?php echo $NumResults; ?>)</h2> </div>
							<?php endif; ?>

				<ul class="opendev-posts-list">
					<?php while(have_posts()) : the_post(); ?>
						<li id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
							<article id="post-<?php the_ID(); ?>">
								<header class="post-header">
									<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
									<?php if(get_post_type() != 'map' && get_post_type() != 'map-layer' && get_post_type() != 'page') { ?>
										<div class="meta">
												<?php show_date_and_source_of_the_post(); ?>
										</div>
									<?php } ?>
								</header>
								<section class="post-content">
									<?php
									//Get Cover image
										if (get('cover')=="" && get('cover'.$local_lang)==""){
											echo '';
										}
										else{
											$img_attr = array("h" => 600, "w" => 800, "zc" => 1, "q" =>100);
											echo '<div class="announcements-singlepage-img">';
											if(get('cover'.$lang)!=""){
												$get_img = '<img class="attachment-thumbnail" src="'.get_image('cover'.$lang,1,1,0).'">';
												$large_img = get_image('cover'.$lang,1,1,0,null,$img_attr);
											}
											else{
												if(get('cover')!=""){
													$get_img = '<img class="attachment-thumbnail" src="'.get_image('cover',1,1,0).'">';
													$large_img = get_image('cover',1,1,0,null,$img_attr);
												}
												else {
													$get_img = '<img class="attachment-thumbnail" src="'.get_image('cover'.$local_lang,1,1,0).'">';
													$large_img = get_image('cover'.$local_lang,1,1,0,null,$img_attr);
												}
											}
											echo '<a target="_blank" href="'.$large_img.'" rel="" >'.$get_img.'</a>';
											echo '</div>'; //<!-- announcements-singlepage-img -->
										}
									?>

									<?php
									//Get Download files
									if (get('upload_document')=="" && get('upload_document'.$local_lang)==""){
										echo "";
									}
									else{
										echo "<span>";
										_e("Download: ");
										//Get English PDF
										if(get('upload_document')!=""){
											$file_name_en = substr(strrchr(get('upload_document'), '/'), 1);
											echo '<a target="_blank" href="'.get_bloginfo("url").'/pdf-viewer/?pdf=files_mf/'.$file_name_en.'">';
												echo '<img src="'.get_bloginfo('stylesheet_directory').'/img/en_us.png" /> ';
												_e ('English PDF');
											echo '</a>';
										}
										else{
											echo '<img src="'.get_bloginfo('stylesheet_directory').'/img/en_us.png" /> ';
											_e("English PDF not available");
										}
										echo "&nbsp; &nbsp;";
										//Get Khmer PDF
										if(get('upload_document'.$local_lang)!=""){
											$file_name = substr(strrchr(get('upload_document'.$local_lang), '/'), 1);
											echo '<a target="_blank" href="'.get_bloginfo("url").'/pdf-viewer/?pdf=files_mf/'.$file_name.'">';
												echo '<img src="'.get_bloginfo('stylesheet_directory').'/img/cambodia.png" /> ';
												_e ('Khmer PDF');
											echo '</a>';
										}
										else{
											echo '<img src="'.get_bloginfo('stylesheet_directory').'/img/cambodia.png" /> ';
											_e("Khmer PDF not available");
										}
										echo "</span>";
									}
									?>

									<div class="post-excerpt">
										<?php the_excerpt(); ?>
									</div>
								</section>
								<aside class="actions clearfix">
									<a href="<?php the_permalink(); ?>"><?php _e('Read more', 'jeo'); ?></a>
								</aside>
							</article>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
			<?php if(is_search() || get_query_var('opendev_advanced_nav')) : ?>
				<section id="wpckan_search_results" class="four columns">
					<h2><?php _e('Data results'); ?></h2>
					<?php echo do_shortcode('[wpckan_query_datasets query="' . $_GET['s'] . '" limit="10" include_fields_resources="format"]'); ?>
					<?php
					$data_page_id = opendev_get_data_page_id();
					if($data_page_id) {
						?>
						<a class="button" href="<?php echo get_permalink($data_page_id); ?>?ckan_s=<?php echo $_GET['s']; ?>"><?php _e('View all data results', 'opendev'); ?></a>
						<?php
					}
					?>
				</section>
			<?php else : ?>
				<!--<div class="three columns offset-by-one move-up">-->

				<div class="three columns move-up">
					<aside id="sidebar">
						<ul class="widgets">
							<li class="widget share-widget">
								<div class="share clearfix">
									<ul>
										<!--<li>
											<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="box_count" data-show-faces="false" data-send="false"></div>
										</li>-->
										<li>
											<div class="fb-share-button" data-href="<?php echo get_permalink( $post->ID )?>" data-send="false" data-layout="button" data-show-faces="false"></div>
										</li>
										<li>
											<div class="twitter-share-button"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="en" data-count="vertical">Tweet</a></div>
										</li>
										<li>
											<div class="g-plusone" data-width="50" data-annotation="none" data-size="tall" data-href="<?php the_permalink(); ?>" data-count="false"></div>
										</li>
									</ul>
								</div>
							</li>
							<!--
							<li id="opendev_taxonomy_widget" class="widget widget_opendev_taxonomy_widget">
								<?php list_category_by_post_type(get_post_type()); ?>
							</li>
							-->
							<?php if ( get_post_type() == 'mekong-storm-flood'){
												dynamic_sidebar('mekong-storm-flood');
									  }else{
												dynamic_sidebar('general');
									 	}
							?>
						</ul>
					</aside>
				</div>
			<?php endif; ?>

		<div class="twelve columns">
			<div class="navigation">
				<?php
				global $wp_query;

				$big = 999999999; // need an unlikely integer

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, $paged ),
					'total' => $wp_query->max_num_pages
				) );
				?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
