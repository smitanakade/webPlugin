<?php get_header(); ?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
		<?php
		
		
		if(!have_posts()){
					global $query_string;
	$query_args = explode("&", $query_string);
	$search_query = array();
	
	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		$field= $query_split[1];
		 $field = str_replace('%20', ' ', $field);
		$search_query[$query_split[0]] = urldecode($query_split[1]);
	} // foreach
	
	global $wpdb;
	
	$subField=substr($field,0,4);

	$product =$wpdb->get_results("SELECT p.productCode, p.productTitle,p.APN FROM `aa_2r53c_productdetails` as p 
Where  p.approved !='N' && (p.productCode like '%".$field."%' or p.productTitle like '%".$field."%' or p.whereToBuy like '%".$field."%' or p.specification like '%".$field."%' or p.productDescription like '%".$field."%' ) 
UNION SELECT g.groupCode, g.groupDescription, g.classCode FROM `aa_2r53c_groupdetail` as g WHERE g.publish='P' && (g.groupCode like'%".$field."%' or g.groupDescription like '%".$field."%')
Union SELECT sub.subGCode,sub.subGDescription,sub.groupCode FROM `aa_2r53c_subgroup` as sub 
WHERE  sub.publish='P' && (sub.subGCode like '%".$field."%' or sub.subGDescription like '%".$field."%')");
			$rows= $wpdb->num_rows;
			
				if($rows !=0 ){
					foreach($product as $data){
					
						if(is_numeric($data->APN) ){
							?>
							<h2><a href="<?php network_home_url(); ?>detail-2/?de=<?php echo $data->productCode;?>"><?php echo $data->productTitle;?></a></h2> 
				<?php }?>
                	<?php if(strlen($data->APN) == 2 && !is_numeric($data->APN)){
						
						?>
							<h2><a href="<?php network_home_url(); ?>productlist/?PO=<?php echo $data->productCode;?>"><?php echo $data->productTitle;?></a></h2> 
				<?php }?>
                <?php if(!is_numeric($data->APN) && strlen($data->APN) == 4 ){
					
					if($data->productCode == 58){?>
						<h2><a href="http://orionlive.com.au/" target="_blank"><?php echo $data->productTitle;?></a></h2>
					<?php }else{
					?>
							<h2><a href="<?php network_home_url(); ?>productlist/?PO=<?php echo $data->productCode;?>"><?php echo $data->productTitle;?></a></h2> 
				<?php } }?>
					
			<?php }
			
				}
				else{
					get_template_part( 'includes/no-results', 'index' );
				}
				}
		
			if ( have_posts() ) :
global $wpdb;
	
	$subField=substr($field,0,4);
	$field= $_GET['s'];


$product =$wpdb->get_results("SELECT p.productCode, p.productTitle,p.APN FROM `aa_2r53c_productdetails` as p 
Where  p.approved !='N' && (p.productCode like '%".$field."%' or p.productTitle like '%".$field."%' or p.whereToBuy like '%".$field."%' or p.specification like '%".$field."%' or p.productDescription like '%".$field."%' ) 
UNION SELECT g.groupCode, g.groupDescription, g.classCode FROM `aa_2r53c_groupdetail` as g WHERE g.publish='P' && (g.groupCode like'%".$field."%' or g.groupDescription like '%".$field."%')
Union SELECT sub.subGCode,sub.subGDescription,sub.groupCode FROM `aa_2r53c_subgroup` as sub 
WHERE  sub.publish='P' && (sub.subGCode like '%".$field."%' or sub.subGDescription like '%".$field."%')");
			$rows= $wpdb->num_rows;
			
				if($rows !=0 ){
					foreach($product as $data){
					
						if(is_numeric($data->APN) ){
							?>
							<h2><a href="<?php network_home_url(); ?>detail-2/?de=<?php echo $data->productCode;?>"><?php echo $data->productTitle;?></a></h2> 
				<?php }?>
                	<?php if(strlen($data->APN) == 2 && !is_numeric($data->APN)){
						
						?>
							<h2><a href="<?php network_home_url(); ?>productlist/?PO=<?php echo $data->productCode;?>"><?php echo $data->productTitle;?></a></h2> 
				<?php }?>
                <?php if(!is_numeric($data->APN) && strlen($data->APN) == 4 ){
					
					if($data->productCode == 58){?>
						<h2><a href="http://orionlive.com.au/" target="_blank"><?php echo $data->productTitle;?></a></h2>
					<?php }else{
					?>
							<h2><a href="<?php network_home_url(); ?>productlist/?PO=<?php echo $data->productCode;?>"><?php echo $data->productTitle;?></a></h2> 
				<?php } }?>
					
			<?php }
			
				}

				
				while ( have_posts() ) : the_post();
					$post_format = get_post_format(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								$first_video
							);
						elseif ( 'gallery' === $post_format ) :
							et_gallery_images();
						elseif ( 'on' == et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb  ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						endif;
					} ?>

				<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ) ) ) : ?>
					<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) )
							truncate_post( 270 );
						else
							the_content();
					?>
				<?php endif; ?>

					</article> <!-- .et_pb_post -->
			<?php
					endwhile;

					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
					
				else :
					
					
				
				endif;
				
			?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>