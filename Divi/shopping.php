<?php
/*
Template Name: shopping
*/
/* Below code checking if class has only one category than it will check follwoing things
 --- if subcategory is there or not if yes than page will be redirected to subcategory page
 -- if no subcategory than page will directly redirect to product page of that category 

*/
							
get_header();

if(isset($_GET['page'])){
	$pages=array("shop_product","cart");
	if(in_array($_GET['page'],$pages)){
		$_page=$_GET['page'];
	}else{
		$_page="shop_product";
	}
}else{
	$_page="shop_product";
}

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>
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

					<div class="entry-content">
                    <div class="et_pb_section et_section_regular">
	
					<?php
						the_content();
						
						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
							
						?>
						<div class="et_pb_row">
						<?php require($_page.".php");?>
                    </div> <!-- .et_pb_row -->
					</div> <!-- .et_pb_section -->
                    
                    <div class="entry-content">
                    <div class="et_pb_section et_section_regular">
                    <div class="et_pb_row">
                    <h1>Cart Item</h1>
                    <?php 
					if(isset($_SESSION['cart'])){
						global $wpdb;
						$sql="SELECT * FROM aa_2r53c_spareparts WHERE partnumber IN (";
						foreach($_SESSION['cart'] as $id =>$value){
							$sql.="'".$id."',";
						}
							$sql=substr($sql,0, -1).")";
							$session= $wpdb->get_results($sql);
							foreach ($session as $row){
								echo "<p>".$row->partnumber." X ".$_SESSION['cart'][$row->partnumber]['quantity']."</p>";
							}
					}else{
						echo "your cart is empty";
					}
					?>
                    <a href="?page=cart">Veiw Cart</a>
                    </div></div></div>
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>