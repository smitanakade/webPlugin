<?php
/*
Template Name: Product Class
*/

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif; ?>
 <?php if (function_exists('qt_custom_breadcrumbs')) qt_custom_breadcrumbs($pageHeading->groupDescription); ?>
					<div class="entry-content">
                    <div class="et_pb_section et_section_regular">
	
					<?php
						the_content();
						global $wpdb;
						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
							
							$result = $wpdb->get_results("SELECT classCode,classDescription FROM aa_2r53c_classdetail WHERE publish = 'P'");
						
						$i= $numOfRow;?>
						<div class="et_pb_row">
   
	<?php
						foreach ($result as $row){
								?>
							
                                <div class="et_pb_column et_pb_column_1_4">
                                <div class="et_pb_promo et_pb_bg_layout_light et_pb_text_align_center et_pb_no_bg">
                                <div class="et_pb_promo_description">
			
							<?php
								echo "<h2>".$row->groupCode."</h2>";
								if($row->classCode =="CO"){?>
								<a  href="http://www.antsig.com" target="_blank"><img class="alignnone size-full wp-image-355" src="<?php echo network_home_url();?>/wp-content/files/<?php echo $row->classCode;?>.jpg" alt="images (1)" width="122px" height="124px"  /></a></p>

								<?php }
								else{
								?>
                                
								<a  href="<?php echo network_home_url();?>/categories?sh=<?php echo $row->classCode; ?>"><img class="alignnone size-full wp-image-355" src="<?php echo network_home_url();?>/wp-content/files/<?php echo $row->classCode;?>.jpg" alt="images (1)" width="122px" height="124px"  /></a></p>
                           <?php } echo "<strong>".$row->classDescription."</strong>";?>
                            </div>
							
          			 			 </div>
								</div>
                                
					<?php }?>
                    </div> <!-- .et_pb_row -->
					</div> <!-- .et_pb_section -->
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>