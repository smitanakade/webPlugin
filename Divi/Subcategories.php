<?php
/*
Template Name: Sub categories
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

				<?php endif;
							global $wpdb;
							$field=$_GET['sh'];
						
							$pageHeading = $wpdb->get_row("SELECT * FROM `aa_2r53c_classdetail` as c, `aa_2r53c_groupdetail` as g WHERE g.groupCode='".$field."' AND g.classCode= c.classCode");
							$result = $wpdb->get_results("SELECT * FROM aa_2r53c_subgroup  WHERE groupCode='".$field."' and publish='P'");
					
				 ?>
                 
    <?php 
	the_breadcrumb('Our Product',$pageHeading->classDescription,$pageHeading->groupDescription,$pageHeading->classCode,'','',''); ?>
					<div class="entry-content">
                    <div class="et_pb_section et_section_regular">
	
					<?php
						the_content();
						
						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
							
						?>
						<div class="et_pb_row">
    <h1><?php echo $pageHeading->groupDescription; ?></h1>
           
    
	<?php
						foreach ($result as $row){
								?>
							
                                <div class="et_pb_column et_pb_column_1_4">
                                <div class="et_pb_promo et_pb_bg_layout_light et_pb_text_align_center et_pb_no_bg">
                                <div class="et_pb_promo_description">
                                
                                <?php 	
								/*removing space from sub category name*/
								$sub = preg_replace('/\s+/', '', $row->subGDescription);
								$network=network_home_url();
								/*checking image is present or not if not than assigning defaul image*/
							   	$image_url = ($network."/wp-content/files/".$row->groupCode."_".$sub.".jpg") ? $network."/wp-content/files/".$row->groupCode."_".$sub.".jpg" :$network."/wp-content/files/ACON.jpg" ;?>                                
                               <?php if($row->subGDescription =="Orion Security"){?>
								   <a  href="http://orionlive.com.au" target="_blank" title="Orion Security">  
							   <?php }else{?>
                                <a  href="<?php network_home_url();?>/productlist/?PO=<?php echo $row->subGCode; ?>">
                                 <?php } ?>
                                 <img class="alignnone size-full wp-image-355"  src="<?php echo $image_url;?>" alt="<?php echo $row->subGDescription;?>" width="133" height="134" /></p></a>
                          <strong> <?php echo $row->subGDescription;?></strong>
                            </div></div></div>
                                
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