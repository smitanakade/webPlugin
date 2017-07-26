<?php
/*
Template Name: categories
*/
/* Below code checking if class has only one category than it will check follwoing things
 --- if subcategory is there or not if yes than page will be redirected to subcategory page
 -- if no subcategory than page will directly redirect to product page of that category 

*/

global $wpdb;
$field=$_GET['sh'];
$result = $wpdb->get_results("SELECT * FROM aa_2r53c_groupdetail WHERE classCode='".$field."' and publish='P'");
$numRow = $wpdb->num_rows;
if($numRow ==1){
	$subGroup = $wpdb->get_results("SELECT * FROM aa_2r53c_subgroup WHERE classCode='".$field."' AND groupCode ='".$result[0]->groupCode."' ");
	$nr_sub=$wpdb->num_rows;
	if($nr_sub == 0){
		$network_url=network_home_url()."/productlist/?PO=".$result[0]->groupCode;
	}
	if($nr_sub > 0){
		$network_url=network_home_url()."/subcategories/?sh=".$result[0]->groupCode;
	}
	header("Location:".$network_url);
}
							

							
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
							$pageHeading = $wpdb->get_row("SELECT classDescription FROM aa_2r53c_classdetail  WHERE classCode='".$field."'");
							$result = $wpdb->get_results("SELECT * FROM aa_2r53c_groupdetail WHERE classCode='".$field."' and publish='P'");
						
				?>
  <?php the_breadcrumb('Our Product',$pageHeading->classDescription,'','','','',''); ?>
					<div class="entry-content">
                    <div class="et_pb_section et_section_regular">
	
					<?php
						the_content();
						
						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
							
						?>
						<div class="et_pb_row">
    <h1><?php echo $pageHeading->classDescription; ?></h1>
	<?php
						foreach ($result as $row){
								?>
							
                                <div class="et_pb_column et_pb_column_1_4">
                                <div class="et_pb_promo et_pb_bg_layout_light et_pb_text_align_center et_pb_no_bg">
                                <div class="et_pb_promo_description">
			<?php 
								$subGroup = $wpdb->get_results("SELECT * FROM aa_2r53c_subgroup WHERE classCode='".$field."' AND groupCode ='".$row->groupCode."' ");
								$numrow=$wpdb->num_rows;
			   if($numrow){?>
					
							<a  href="<?php network_home_url();?>subcategories/?sh=<?php echo $row->groupCode; ?>">
                            	<?php }
				else{
			?>															
							<a  href="<?php network_home_url();?>/productlist/?PO=<?php echo $row->groupCode; ?>">
                          <?php }?>  
                      <?php    $url=network_home_url(); 
            				 $image_url =($url."/wp-content/files/".$row->groupCode.".jpg") ? $url."/wp-content/files/".$row->groupCode.".jpg" :  $url."/wp-content/files/ACON.jpg";
			 
			 ?>          
                                <img class="alignnone size-full wp-image-355" src="<?php echo $image_url;?>" alt="images (1)" width="133" height="134" /></p></a>
                          <strong> <?php echo $row->groupDescription;?></strong>
                            </div>
			<?php 
			
			//echo "SELECT * FROM aa_2r53c_subgroup WHERE classCode='".$field."' AND groupCode ='".$row->groupCode."' ";
			
				
        ?>
                      
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